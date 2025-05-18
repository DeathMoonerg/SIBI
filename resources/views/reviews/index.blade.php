@extends('layouts.dashboard')

@section('title', 'Ulasan')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<style>
    /* Card hover effect */
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    /* Action buttons styling */
    .review-actions .btn {
        margin-left: 5px;
    }
    
    /* Badge styling */
    .pending-badge {
        font-size: 0.7rem;
        padding: 0.25em 0.5em;
        vertical-align: middle;
    }
    
    /* Teacher options highlight */
    .teacher-action-highlight {
        border-left: 3px solid #4e73df;
        padding-left: 8px;
    }
    
    /* Pending review highlighting */
    .border-warning {
        border-width: 2px !important;
    }
    
    /* Card footer for pending reviews */
    .card-footer .text-danger {
        font-weight: bold;
    }
    
    /* Additional spacing for mobile */
    @media (max-width: 767.98px) {
        .review-actions {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .review-actions .btn, .review-actions form {
            margin-top: 5px;
        }
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ulasan dan Testimoni</h1>
        @if(auth()->user()->role === 'teacher' || auth()->user()->role === 'admin' || auth()->user()->role === 'parent')
        <a href="{{ route('reviews.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-2"></i>Tambah Ulasan
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            @if(auth()->user()->role === 'teacher')
                {{ session('success') }}
            @else
                Ulasan berhasil ditambahkan dan akan ditampilkan setelah disetujui oleh guru
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(auth()->user()->role === 'teacher')
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->get('filter') !== 'pending' ? 'active' : '' }}" href="{{ route('reviews.index') }}">
                    Semua Ulasan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->get('filter') === 'pending' ? 'active' : '' }}" href="{{ route('reviews.index', ['filter' => 'pending']) }}">
                    Menunggu Persetujuan
                    @php
                        $pendingCount = \App\Models\Review::where('is_approved', false)->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge bg-danger ms-1 pending-badge">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    @endif

    <div class="row">
        @forelse($reviews as $review)
            @if((auth()->user()->role === 'admin' || auth()->user()->role === 'parent') && !$review->is_approved && $review->user_id !== auth()->id())
                @continue
            @endif
            <div class="col-md-6 mb-4">
                <div class="card {{ $review->is_approved ? 'border-success' : 'border-warning' }} shadow-sm hover-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                {{ $review->user->name }}
                                @if($review->user_id === auth()->id())
                                    <span class="badge bg-info text-white ms-2">Anda</span>
                                @endif
                                @if(auth()->user()->role === 'teacher' && $review->user->role === 'parent')
                                    <span class="badge bg-primary text-white ms-2">Orang Tua</span>
                                @endif
                            </h5>
                            <small class="text-muted">{{ $review->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ Str::limit($review->content, 150) }}</p>
                        
                        <div class="d-flex justify-content-between mt-3">
                            @if(auth()->user()->role === 'teacher')
                            <a href="{{ route('reviews.show', $review) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                            @endif
                            
                            <div class="review-actions">
                                @if(auth()->user()->role === 'teacher' && !$review->is_approved && $review->user_id !== auth()->id())
                                    <form action="{{ route('reviews.approve', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check me-1"></i> Setujui
                                        </button>
                                    </form>
                                @endif
                                
                                @if((auth()->user()->role === 'teacher' || auth()->user()->role === 'admin') && (auth()->id() === $review->user_id || auth()->user()->role === 'teacher'))
                                    <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                @endif
                                
                                @if((auth()->user()->role === 'teacher' || auth()->user()->role === 'admin') && (auth()->id() === $review->user_id || auth()->user()->role === 'teacher'))
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                        <small class="text-{{ $review->is_approved ? 'success' : 'warning' }}">
                            @if($review->is_approved)
                                <i class="fas fa-check-circle me-1"></i> Disetujui
                            @else
                                @if((auth()->user()->role === 'admin' || auth()->user()->role === 'parent') && $review->user_id === auth()->id())
                                    <i class="fas fa-clock me-1"></i> Ulasan Anda akan ditampilkan setelah disetujui oleh guru
                                @else
                                    <i class="fas fa-clock me-1"></i> Menunggu Persetujuan
                                @endif
                            @endif
                        </small>
                        
                        @if(auth()->user()->role === 'teacher' && !$review->is_approved)
                            <small class="text-danger">
                                <i class="fas fa-exclamation-triangle me-1"></i> Perlu ditinjau
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Belum ada ulasan yang tersedia. 
                    @if(auth()->user()->role === 'teacher' || auth()->user()->role === 'admin' || auth()->user()->role === 'parent')
                    <a href="{{ route('reviews.create') }}" class="alert-link">Buat ulasan pertama</a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    @if($reviews->hasPages())
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div>
            <small class="text-muted">
                Menampilkan {{ $reviews->firstItem() }}-{{ $reviews->lastItem() }} dari {{ $reviews->total() }} data
            </small>
        </div>
        <div>
            @if ($reviews->onFirstPage())
                <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
            @else
                <a href="{{ $reviews->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
            @endif

            @if ($reviews->hasMorePages())
                <a href="{{ $reviews->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
            @else
                <button class="btn btn-sm btn-outline-secondary" disabled>Next</button>
            @endif
        </div>
    </div>
    @endif
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi hapus dengan dialog yang lebih deskriptif
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get the review author from the parent card
                const reviewCard = this.closest('.card');
                const reviewAuthor = reviewCard.querySelector('.card-header h5').innerText.split('\n')[0].trim();
                
                const confirmMessage = 'Apakah Anda yakin ingin menghapus ulasan dari "' + reviewAuthor + '"? Tindakan ini tidak dapat dibatalkan.';
                
                if (confirm(confirmMessage)) {
                    this.submit();
                }
            });
        });
        
        // Highlight the pending reviews tab if there are pending reviews
        const pendingBadge = document.querySelector('.pending-badge');
        if (pendingBadge && parseInt(pendingBadge.textContent) > 0) {
            pendingBadge.closest('.nav-link').classList.add('text-danger');
        }
    });
</script>
@endsection
@endsection 