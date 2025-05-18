<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form
     * 
     * @return \Illuminate\View\View
     */
    public function loginForm()
    {
        // If user is already logged in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle user login
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Debug log
        Log::info('Login attempt', [
            'email' => $credentials['email'],
            'remember' => $request->filled('remember')
        ]);

        // Check if user exists
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            Log::warning('Login failed - user not found', ['email' => $credentials['email']]);
            return back()
                ->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput($request->except('password'));
        }

        // Debug user data
        Log::info('User found', [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
            'has_password' => !empty($user->password)
        ]);

        // Try to authenticate
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            Log::info('Login successful', [
                'user_id' => $user->id,
                'name' => $user->name,
                'role' => $user->role
            ]);

            return redirect()->intended('dashboard')
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
        }

        // If we get here, password is wrong
        Log::warning('Login failed - wrong password', [
            'email' => $credentials['email'],
            'provided_password_length' => strlen($credentials['password'])
        ]);

        // Reset password for testing (temporary)
        $user->password = Hash::make('password123');
        $user->save();

        Log::info('Password reset for testing', [
            'email' => $user->email,
            'new_password' => 'password123'
        ]);

        return back()
            ->withErrors(['email' => 'Password yang dimasukkan tidak cocok.'])
            ->withInput($request->except('password'));
    }

    /**
     * Handle user logout
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Get user info before logout for logging
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $userName = $user ? $user->name : 'Unknown';
        
        // Logout
        Auth::logout();
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Log the logout
        Log::info('Logout successful', ['user_id' => $userId, 'name' => $userName]);
        
        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
