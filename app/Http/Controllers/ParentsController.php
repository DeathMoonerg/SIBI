<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ParentsController extends Controller
{
    /**
     * Check if the current user is an admin or teacher.
     *
     * @return bool
     */
    private function isAuthorized()
    {
        return Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'teacher');
    }

    /**
     * Display a listing of parents.
     */
    public function index()
    {
        if (!$this->isAuthorized()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $parents = User::where('role', 'parent')
            ->withCount(['children' => function($query) {
                $query->where('role', 'student');
            }])
            ->latest()
            ->paginate(10);
        
        return view('parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new parent.
     */
    public function create()
    {
        if (!$this->isAuthorized()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return view('parents.create');
    }

    /**
     * Store a newly created parent in storage.
     */
    public function store(Request $request)
    {
        if (!$this->isAuthorized()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $parent = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'parent',
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('parents.index')
            ->with('success', 'Orang tua berhasil ditambahkan!');
    }

    /**
     * Display the specified parent.
     */
    public function show(User $parent)
    {
        if (!$this->isAuthorized()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        if ($parent->role !== 'parent') {
            return redirect()->route('parents.index')
                ->with('error', 'Pengguna bukan orang tua.');
        }

        // Get children (students) associated with this parent
        $children = $parent->children;
                       
        return view('parents.show', compact('parent', 'children'));
    }

    /**
     * Show the form for editing the specified parent.
     */
    public function edit(User $parent)
    {
        if (!$this->isAuthorized()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        if ($parent->role !== 'parent') {
            return redirect()->route('parents.index')
                ->with('error', 'Pengguna bukan orang tua.');
        }
        
        return view('parents.edit', compact('parent'));
    }

    /**
     * Update the specified parent in storage.
     */
    public function update(Request $request, User $parent)
    {
        if (!$this->isAuthorized()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        if ($parent->role !== 'parent') {
            return redirect()->route('parents.index')
                ->with('error', 'Pengguna bukan orang tua.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $parent->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            $parent->password = Hash::make($request->password);
        }

        $parent->name = $validated['name'];
        $parent->email = $validated['email'];
        $parent->phone = $validated['phone'];
        $parent->address = $validated['address'];
        $parent->save();

        return redirect()->route('parents.index')
            ->with('success', 'Informasi orang tua berhasil diperbarui!');
    }

    /**
     * Remove the specified parent from storage.
     */
    public function destroy(User $parent)
    {
        if (!$this->isAuthorized()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        if ($parent->role !== 'parent') {
            return redirect()->route('parents.index')
                ->with('error', 'Pengguna bukan orang tua.');
        }

        // Check if has children
        $hasChildren = User::where('role', 'student')
                          ->where('parent_id', $parent->id)
                          ->exists();
                          
        if ($hasChildren) {
            return redirect()->route('parents.index')
                            ->with('error', 'Tidak dapat menghapus orang tua yang memiliki anak terdaftar.');
        }
        
        $parent->delete();

        return redirect()->route('parents.index')
            ->with('success', 'Orang tua berhasil dihapus!');
    }
} 