<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
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
     * Display a listing of payments.
     */
    public function index()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $payments = Payment::with(['student', 'createdBy'])
            ->latest()
            ->paginate(10);
        
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $students = User::where('role', 'student')->get();
        return view('payments.create', compact('students'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'description' => 'required|string',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Payment::create([
            'student_id' => $validated['student_id'],
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'description' => $validated['description'],
            'payment_method' => $validated['payment_method'],
            'status' => $validated['status'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        $payment->load(['student', 'createdBy']);
        return view('payments.show', compact('payment'));
    }
} 