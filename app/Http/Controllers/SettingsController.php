<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Check if the current user is an admin.
     *
     * @return bool
     */
    private function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Display the settings page.
     */
    public function index()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $settings = Setting::pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        foreach ($validated as $key => $value) {
            // Skip file uploads
            if (in_array($key, ['logo', 'favicon']) && !$request->hasFile($key)) {
                continue;
            }

            // Handle file uploads
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = $key . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $value = 'images/' . $filename;
            }

            // Update or create setting
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
} 