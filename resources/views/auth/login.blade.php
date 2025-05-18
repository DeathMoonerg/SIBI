@extends('layouts.app')

@section('title', 'Login - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="container-fluid">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
                <h1 class="display-4 text-white animated slideInDown mb-3">Login</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Login Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-5">
                    <div class="bg-light rounded p-5 wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="mb-4 text-center">Masuk ke SIBI</h2>
                        
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                            name="email" id="email" placeholder="Email" 
                                            value="{{ old('email') }}" required>
                                        <label for="email">Email</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-4 position-relative">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                            id="password" name="password" placeholder=" " required>
                                        <label for="password">Password</label>
                                        <span onclick="togglePassword()" class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                            id="togglePassword" style="cursor: pointer; z-index: 1000; padding: 0.5rem;">
                                            <i class="fas fa-eye-slash text-muted"></i>
                                        </span>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" 
                                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Login</button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p>Silahkan hubungi admin jika Anda lupa password atau memerlukan bantuan.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="h-100 d-flex flex-column justify-content-center p-5">
                        <h1 class="mb-4">Selamat Datang di SIBI</h1>
                        <p class="mb-4">SIBI (Sistem Informasi Bimbel Alfarizqi) membantu orang tua dan guru untuk:
                        </p>
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa fa-check-circle text-primary me-3"></i>
                                <h5 class="mb-0">Memantau perkembangan belajar anak didik</h5>
                            </div>
                            <span>Orang tua dapat melihat kemajuan belajar anak mereka secara real-time dan terhubung langsung dengan guru.</span>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa fa-check-circle text-primary me-3"></i>
                                <h5 class="mb-0">Mencatat jumlah pertemuan dengan guru</h5>
                            </div>
                            <span>Memastikan transparansi dan akurasi dalam pencatatan kehadiran dan sesi pembelajaran.</span>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa fa-check-circle text-primary me-3"></i>
                                <h5 class="mb-0">Menyediakan laporan kemajuan terstruktur</h5>
                            </div>
                            <span>Dokumentasi terstruktur tentang perkembangan anak didik yang dapat diakses kapan saja.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->

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
    </script>
@endsection 