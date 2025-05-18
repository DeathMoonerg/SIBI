<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resources.
     */
    public function index()
    {
        // Menampilkan ulasan berdasarkan role
        if (Auth::user()->role === 'admin') {
            // Admin bisa melihat semua ulasan (termasuk yang belum disetujui)
            $query = Review::with('user');
            
            // Filter berdasarkan status persetujuan
            if (request()->get('filter') === 'pending') {
                $query->where('is_approved', false);
            }
            
            $reviews = $query->latest()->paginate(10);
        } elseif (Auth::user()->role === 'teacher') {
            // Guru bisa melihat semua ulasan yang sudah disetujui dan ulasan yang dibuat sendiri
            // Juga bisa melihat ulasan yang belum disetujui ketika filter 'pending' dipilih
            $query = Review::with('user');
            
            // Filter berdasarkan status persetujuan
            if (request()->get('filter') === 'pending') {
                $query->where('is_approved', false);
            } else {
                $query->where(function($q) {
                    $q->where('is_approved', true)
                      ->orWhere('user_id', Auth::id());
                });
            }
            
            $reviews = $query->latest()->paginate(10);
        } else {
            // Orang tua hanya bisa melihat ulasan yang sudah disetujui dan ulasan yang dibuat sendiri
            $reviews = Review::with('user')
                ->where(function($query) {
                    $query->where('is_approved', true)
                          ->orWhere('user_id', Auth::id());
                })
                ->latest()->paginate(10);
        }

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = new Review([
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'user_id' => Auth::id(),
            'is_approved' => Auth::user()->role === 'teacher', // Hanya guru yang bisa langsung menyetujui ulasan
        ]);
        
        $review->save();

        return redirect()->route('reviews.index')
            ->with('success', 'Ulasan berhasil ditambahkan' . 
                  (Auth::user()->role !== 'teacher' ? ' dan sedang menunggu persetujuan guru' : ''));
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        // Cek akses
        if (!$this->checkAccess($review)) {
            return redirect()->route('reviews.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat ulasan ini');
        }

        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        // Cek akses
        if (!$this->checkAccess($review)) {
            return redirect()->route('reviews.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah ulasan ini');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Cek akses
        if (!$this->checkAccess($review)) {
            return redirect()->route('reviews.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah ulasan ini');
        }

        $request->validate([
            'content' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->content = $request->input('content');
        $review->rating = $request->input('rating');
        
        // Hanya guru yang bisa mengubah status persetujuan
        if (Auth::user()->role === 'teacher' && $request->has('is_approved')) {
            $review->is_approved = $request->boolean('is_approved');
        }
        
        $review->save();

        return redirect()->route('reviews.index')
            ->with('success', 'Ulasan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        // Cek akses
        if (!$this->checkAccess($review, true)) {
            return redirect()->route('reviews.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus ulasan ini');
        }

        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Ulasan berhasil dihapus');
    }

    /**
     * Approve a review
     */
    public function approve(Review $review)
    {
        // Hanya guru yang bisa menyetujui ulasan
        if (Auth::user()->role !== 'teacher') {
            return redirect()->route('reviews.index')
                ->with('error', 'Anda tidak memiliki akses untuk menyetujui ulasan');
        }

        $review->is_approved = true;
        $review->save();

        return redirect()->route('reviews.index')
            ->with('success', 'Ulasan berhasil disetujui');
    }

    /**
     * Check if user has access to the review
     */
    private function checkAccess(Review $review, $isDelete = false)
    {
        // Guru memiliki akses penuh untuk menghapus ulasan
        if (Auth::user()->role === 'teacher' && $isDelete) {
            return true;
        }

        // Guru memiliki akses penuh untuk melihat dan mengedit
        if (Auth::user()->role === 'teacher') {
            return true;
        }

        // Admin dan orang tua hanya bisa mengakses ulasan mereka sendiri
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'parent') {
            return $review->user_id === Auth::id();
        }

        return false;
    }
}

