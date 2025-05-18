@extends('layouts.dashboard')

@section('title', 'Edit Ulasan')

@section('content')
<div class="container-fluid">
    <div class="card dashboard-card">
        <div class="card-header bg-white">
            <div class="d-flex align-items-center">
                <i class="fas fa-edit fa-2x text-warning me-3"></i>
                <div>
                    <h5 class="mb-0">Edit Ulasan</h5>
                    <p class="text-muted mb-0">Perbarui ulasan Anda tentang Bimbel SIBI</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reviews.update', $review) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                    <div class="rating-container">
                        <div class="rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input 
                                    type="radio" 
                                    id="rating-{{ $i }}" 
                                    name="rating" 
                                    value="{{ $i }}" 
                                    {{ old('rating', $review->rating) == $i ? 'checked' : '' }}
                                >
                                <label for="rating-{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="content" class="form-label">Ulasan <span class="text-danger">*</span></label>
                    <textarea 
                        class="form-control @error('content') is-invalid @enderror" 
                        id="content" 
                        name="content" 
                        rows="5" 
                        placeholder="Bagikan pengalaman dan pendapat Anda tentang Bimbel SIBI..."
                        required
                    >{{ old('content', $review->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 10 karakter</small>
                </div>
                
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                    <div class="mb-4">
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                id="is_approved" 
                                name="is_approved" 
                                value="1" 
                                {{ old('is_approved', $review->is_approved) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="is_approved">
                                Setujui Ulasan
                            </label>
                        </div>
                    </div>
                @else
                    @if(!$review->is_approved)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Perubahan pada ulasan Anda akan memerlukan persetujuan ulang dari Admin
                        </div>
                    @endif
                @endif
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.rating-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.rating {
    display: flex;
    flex-direction: row-reverse;
    gap: 5px;
}

.rating input {
    display: none;
}

.rating label {
    cursor: pointer;
    color: #ccc;
    font-size: 24px;
}

.rating input:checked ~ label {
    color: #ffc107;
}

.rating label:hover,
.rating label:hover ~ label {
    color: #ffc107;
}
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingInputs = document.querySelectorAll('.rating input');
        const ratingLabels = document.querySelectorAll('.rating label');
        
        ratingLabels.forEach(label => {
            label.addEventListener('click', function() {
                const forId = this.getAttribute('for');
                const value = forId.split('-')[1];
                document.querySelector('#' + forId).checked = true;
            });
        });
    });
</script>
@endsection
@endsection 