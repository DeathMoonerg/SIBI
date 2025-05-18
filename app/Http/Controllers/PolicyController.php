<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Access control will be handled in routes
    }

    /**
     * Check user access
     */
    private function checkAccess()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'teacher'])) {
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
        
        return null;
    }

    /**
     * Display a listing of the policies.
     */
    public function index(Request $request)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }
        
        $query = Policy::with(['creator', 'updater'])->latest();
        
        // Filter by status
        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }
        
        $policies = $query->paginate(10);

        return view('policies.index', compact('policies'));
    }

    /**
     * Show the form for creating a new policy.
     */
    public function create()
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }
        
        return view('policies.create');
    }

    /**
     * Store a newly created policy in storage.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        Policy::create($validated);

        return redirect()->route('policies.index')
            ->with('success', 'Kebijakan berhasil ditambahkan!');
    }

    /**
     * Display the specified policy.
     */
    public function show(Policy $policy)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }
        
        return view('policies.show', compact('policy'));
    }

    /**
     * Show the form for editing the specified policy.
     */
    public function edit(Policy $policy)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }
        
        return view('policies.edit', compact('policy'));
    }

    /**
     * Update the specified policy in storage.
     */
    public function update(Request $request, Policy $policy)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['updated_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        $policy->update($validated);

        return redirect()->route('policies.index')
            ->with('success', 'Kebijakan berhasil diperbarui!');
    }

    /**
     * Remove the specified policy from storage.
     */
    public function destroy(Policy $policy)
    {
        if ($redirect = $this->checkAccess()) {
            return $redirect;
        }
        
        // Only admin (super admin) can delete policies
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('policies.index')
                ->with('error', 'Hanya Super Admin yang dapat menghapus kebijakan.');
        }

        $policy->delete();

        return redirect()->route('policies.index')
            ->with('success', 'Kebijakan berhasil dihapus!');
    }

    /**
     * Toggle the status of the specified policy.
     */
    public function toggleStatus(Policy $policy)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        try {
            $policy->update([
                'is_active' => !$policy->is_active,
                'updated_by' => auth()->id()
            ]);

            return redirect()->back()
                ->with('success', 'Status kebijakan berhasil diubah menjadi ' . ($policy->is_active ? 'aktif' : 'nonaktif') . '.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah status kebijakan. Silakan coba lagi.');
        }
    }
}
