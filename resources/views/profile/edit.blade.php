@extends('layouts.dashboard')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center">
                        @if(auth()->user()->role === 'admin')
                            <i class="fas fa-user-shield fa-2x text-primary me-3"></i>
                        @elseif(auth()->user()->role === 'teacher')
                            <i class="fas fa-chalkboard-teacher fa-2x text-success me-3"></i>
                        @else
                            <i class="fas fa-user fa-2x text-info me-3"></i>
                        @endif
                        <div>
                            <h5 class="mb-0">Edit Profil</h5>
                            <p class="text-muted mb-0">Perbarui informasi profil Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary" title="Kembali">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success" title="Simpan Perubahan">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <hr>

                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating mb-4 position-relative">
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           placeholder=" ">
                                    <label for="current_password">Password Saat Ini</label>
                                    <span onclick="toggleCurrentPassword()" 
                                          class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                          id="toggleCurrentPassword" 
                                          style="cursor: pointer; z-index: 1000; padding: 0.5rem;">
                                        <i class="fas fa-eye-slash text-muted"></i>
                                    </span>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-floating mb-4 position-relative">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder=" ">
                                    <label for="password">Password Baru</label>
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
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating mb-4 position-relative">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder=" ">
                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
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
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
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
</style>
@endpush

@section('scripts')
<script>
function toggleCurrentPassword() {
    const passwordField = document.getElementById('current_password');
    const toggleIcon = document.querySelector('#toggleCurrentPassword i');
    
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

    // Check password strength on input
    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        if (confirmInput.value) {
            checkPasswordMatch();
        }
    });

    // Check password match on input
    confirmInput.addEventListener('input', checkPasswordMatch);

    // Initial checks
    if (passwordInput.value) {
        checkPasswordStrength(passwordInput.value);
    }
    if (confirmInput.value) {
        checkPasswordMatch();
    }
});
</script>
@endsection 