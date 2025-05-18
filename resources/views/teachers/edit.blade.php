@extends('layouts.dashboard')

@section('title', 'Edit Guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="mb-0">Edit Guru</h5>
                        <p class="text-muted mb-0">Edit informasi guru</p>
                    </div>
                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary w-100 w-md-auto">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('teachers.update', $teacher) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $teacher->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $teacher->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $teacher->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder=" ">
                                    <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                                    <span onclick="togglePassword()" 
                                          class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                          id="togglePassword" 
                                          style="cursor: pointer; z-index: 1000; padding: 0.5rem;">
                                        <i class="fas fa-eye-slash text-muted"></i>
                                    </span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="password-requirements mt-2">
                                    <small class="text-muted">Password harus memenuhi kriteria berikut:</small>
                                    <ul class="list-unstyled mb-0">
                                        <li class="requirement" data-requirement="length">
                                            <i class="fas fa-times text-danger"></i> Minimal 8 karakter
                                        </li>
                                        <li class="requirement" data-requirement="uppercase">
                                            <i class="fas fa-times text-danger"></i> Mengandung huruf besar
                                        </li>
                                        <li class="requirement" data-requirement="lowercase">
                                            <i class="fas fa-times text-danger"></i> Mengandung huruf kecil
                                        </li>
                                        <li class="requirement" data-requirement="number">
                                            <i class="fas fa-times text-danger"></i> Mengandung angka
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder=" ">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <span onclick="toggleConfirmPassword()" 
                                          class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                          id="toggleConfirmPassword" 
                                          style="cursor: pointer; z-index: 1000; padding: 0.5rem;">
                                        <i class="fas fa-eye-slash text-muted"></i>
                                    </span>
                                </div>
                                <div class="password-match mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-times text-danger"></i> Password harus sama
                                    </small>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $teacher->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-column flex-md-row gap-2 justify-content-end">
                                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary w-100 w-md-auto">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-success w-100 w-md-auto">
                                        <i class="fas fa-save me-2"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.password-requirements {
    font-size: 0.875rem;
}

.password-requirements ul {
    margin-top: 0.5rem;
}

.password-requirements li {
    margin-bottom: 0.25rem;
}

.password-requirements li i {
    margin-right: 0.5rem;
}

.password-requirements li.valid i {
    color: #28a745;
}

.password-match i {
    margin-right: 0.5rem;
}

.password-match.valid i {
    color: #28a745;
}

@media (max-width: 768px) {
    .password-requirements {
        font-size: 0.8rem;
    }
    
    .password-requirements ul {
        margin-top: 0.25rem;
    }
    
    .password-requirements li {
        margin-bottom: 0.15rem;
    }
}
</style>
@endpush

@section('scripts')
<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.querySelector('#togglePassword i');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
}

function toggleConfirmPassword() {
    const passwordField = document.getElementById('password_confirmation');
    const toggleIcon = document.querySelector('#toggleConfirmPassword i');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
}

// Password validation
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const requirements = document.querySelectorAll('.requirement');
    const passwordMatch = document.querySelector('.password-match');

    function checkPasswordStrength(password) {
        const hasLength = password.length >= 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);

        requirements.forEach(req => {
            const type = req.getAttribute('data-requirement');
            let isValid = false;

            switch(type) {
                case 'length':
                    isValid = hasLength;
                    break;
                case 'uppercase':
                    isValid = hasUpperCase;
                    break;
                case 'lowercase':
                    isValid = hasLowerCase;
                    break;
                case 'number':
                    isValid = hasNumber;
                    break;
            }

            const icon = req.querySelector('i');
            if (isValid) {
                icon.className = 'fas fa-check text-success';
                req.classList.add('valid');
            } else {
                icon.className = 'fas fa-times text-danger';
                req.classList.remove('valid');
            }
        });
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        const icon = passwordMatch.querySelector('i');
        const text = passwordMatch.querySelector('small');

        if (confirm === '') {
            icon.className = 'fas fa-times text-danger';
            text.className = 'text-muted';
            passwordMatch.classList.remove('valid');
        } else if (password === confirm) {
            icon.className = 'fas fa-check text-success';
            text.className = 'text-success';
            passwordMatch.classList.add('valid');
        } else {
            icon.className = 'fas fa-times text-danger';
            text.className = 'text-danger';
            passwordMatch.classList.remove('valid');
        }
    }

    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        if (confirmInput.value !== '') {
            checkPasswordMatch();
        }
    });

    confirmInput.addEventListener('input', checkPasswordMatch);
});
</script>
@endsection 