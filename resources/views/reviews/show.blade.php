@extends('layouts.dashboard')

@section('title', 'Detail Ulasan')

@section('content')
<div class="container-fluid">
    <div class="card dashboard-card">
        <div class="card-header bg-white">
            <div class="d-flex align-items-center">
                <i class="fas fa-comment-dots fa-2x text-primary me-3"></i>
                <div>
                    <h5 class="mb-0">Detail Ulasan</h5>
                    <p class="text-muted mb-0">Ulasan dari {{ $review->user->name }}</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-2">
                        <strong class="me-2">Dibuat oleh:</strong>
                        <span>{{ $review->user->name }}</span>
                        @if($review->user_id === auth()->id())
                            <span class="badge bg-info text-white ms-2">Anda</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <strong class="me-2">Status:</strong>
                        <span class="badge {{ $review->is_approved ? 'bg-success' : 'bg-warning' }}">
                            {{ $review->is_approved ? 'Disetujui' : 'Menunggu Persetujuan' }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <strong class="me-2">Tanggal:</strong>
                        <span>{{ $review->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($review->created_at != $review->updated_at)
                        <div class="d-flex align-items-center mb-2">
                            <strong class="me-2">Diperbarui:</strong>
                            <span>{{ $review->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-2">
                        <strong class="me-2">Rating:</strong>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="ms-2">{{ $review->rating }}/5</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Isi Ulasan</h6>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $review->content }}</p>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                
                <div>
                    @if((auth()->user()->role === 'admin' || auth()->user()->role === 'teacher') && !$review->is_approved)
                        <form action="{{ route('reviews.approve', $review) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i> Setujui
                            </button>
                        </form>
                    @endif
                    
                    @if(auth()->id() === $review->user_id || auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        
                        @if(!$review->is_approved || auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi hapus
        const deleteForm = document.querySelector('.delete-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus ulasan ini?')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endsection
@endsection 