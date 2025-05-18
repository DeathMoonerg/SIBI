<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SIBI - Sistem Informasi Bimbel Alfarizqi')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Memuat...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
            <a href="{{ route('home') }}" class="navbar-brand">
                <h1 class="m-0 text-primary"><i class="fa fa-book-reader me-3"></i>SIBI</h1>
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('about') }}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang Kami</a>
                    <a href="{{ route('testimonial') }}" class="nav-item nav-link {{ request()->routeIs('testimonial') ? 'active' : '' }}">Ulasan</a>
                    <a href="{{ route('contact') }}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
                </div>
                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">Masuk<i class="fa fa-sign-in-alt ms-3"></i></a>
            </div>
        </nav>
        <!-- Navbar End -->

        @if(isset($dbConnectionError) && $dbConnectionError)
            <div class="alert alert-danger m-3">
                <strong>Error Database:</strong> Saat ini kami mengalami masalah dengan koneksi database. Mohon maaf atas ketidaknyamanan ini.
            </div>
        @endif

        @yield('content')

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn parallax-section" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Hubungi Kami</h3>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. Pendidikan No. 123, Balikpapan, Indonesia</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+62 812 3456 7890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@bimbelalfarizqi.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Tautan Cepat</h3>
                        <a class="btn btn-link text-white-50" href="{{ route('home') }}">Beranda</a>
                        <a class="btn btn-link text-white-50" href="{{ route('about') }}">Tentang Kami</a>
                        <a class="btn btn-link text-white-50" href="{{ route('testimonial') }}">Ulasan</a>
                        <a class="btn btn-link text-white-50" href="{{ route('contact') }}">Kontak</a>
                        <a class="btn btn-link text-white-50" href="{{ route('login') }}">Masuk</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Layanan Kami</h3>
                        <a class="btn btn-link text-white-50" href="#">CaLisTung</a>
                        <a class="btn btn-link text-white-50" href="#">Matematika</a>
                        <a class="btn btn-link text-white-50" href="#">Bahasa Inggris</a>
                        <a class="btn btn-link text-white-50" href="#">Hijaiyah</a>
                        <a class="btn btn-link text-white-50" href="#">Mata Pelajaran SD</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Jam Operasional</h3>
                        <p>Kami melayani pembelajaran di rumah anak didik dengan jadwal yang fleksibel</p>
                        <p class="mb-1"><strong>Senin - Jumat:</strong> 08.00 - 18.00</p>
                        <p class="mb-1"><strong>Sabtu:</strong> 09.00 - 16.00</p>
                        <p><strong>Minggu:</strong> Tutup</p>
                    </div>
                </div>
            </div>
            <div class="container-fluid copyright">
            <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Bimbel Alfarizqi</a>, Hak Cipta Dilindungi.
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="{{ route('home') }}">Beranda</a>
                                <a href="{{ route('about') }}">Tentang Kami</a>
                                <a href="{{ route('contact') }}">Kontak</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html> 