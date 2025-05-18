<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * Display a listing of the billings.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            // Admin sees all billings
            $billings = []; // Replace with actual billing fetching
        } elseif ($user->role === 'parent') {
            // Parent sees their children's billings
            $billings = []; // Replace with actual billing fetching
        } else {
            // Teachers don't have billing access
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        return view('billings.index', compact('billings'));
    }

    /**
     * Display the specified billing.
     */
    public function show($id)
    {
        $billing = null; // Replace with actual billing fetching
        
        return view('billings.show', compact('billing'));
    }
} 
 
 