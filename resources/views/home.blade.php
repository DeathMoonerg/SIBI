@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Beranda - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('img/carousel-1.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-2 text-white animated slideInDown mb-4">Bimbel Terbaik untuk Anak Anda di Balikpapan</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Kami menyediakan layanan pendidikan nonformal dengan guru pribadi yang mengajar langsung di rumah anak didik Anda.</p>
                                <a href="{{ route('about') }}" class="btn btn-primary rounded-pill py-sm-3 px-sm-5 me-3 animated slideInLeft">Pelajari Lebih Lanjut</a>
                                <a href="{{ route('login') }}" class="btn btn-dark rounded-pill py-sm-3 px-sm-5 animated slideInRight">Masuk</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cloud-animation">
                    <div class="cloud-1"></div>
                    <div class="cloud-2"></div>
                    <div class="cloud-3"></div>
                    <div class="cloud-4"></div>
                    <div class="cloud-5"></div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('img/carousel-2.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-2 text-white animated slideInDown mb-4">Pantau Perkembangan Anak dengan Mudah</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">SIBI membantu orang tua memantau perkembangan belajar dan kehadiran guru dengan sistem yang transparan dan terorganisir.</p>
                                <a href="{{ route('about') }}" class="btn btn-primary rounded-pill py-sm-3 px-sm-5 me-3 animated slideInLeft">Pelajari Lebih Lanjut</a>
                                <a href="{{ route('login') }}" class="btn btn-dark rounded-pill py-sm-3 px-sm-5 animated slideInRight">Masuk</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cloud-animation">
                    <div class="cloud-1"></div>
                    <div class="cloud-2"></div>
                    <div class="cloud-3"></div>
                    <div class="cloud-4"></div>
                    <div class="cloud-5"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Facilities Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Layanan Kami</h1>
                <p>Bimbel Alfarizqi menyediakan berbagai layanan pendidikan nonformal dengan guru profesional yang mengajar langsung di rumah anak didik.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="facility-item hover-grow hover-shadow">
                        <div class="facility-icon bg-primary">
                            <span class="bg-primary"></span>
                            <i class="fa fa-book fa-3x text-primary"></i>
                            <span class="bg-primary"></span>
                        </div>
                        <div class="facility-text bg-primary">
                            <h3 class="text-primary mb-3">CaLisTung</h3>
                            <p class="mb-0">Program Baca, Tulis, dan Hitung untuk anak usia dini, fokus pada kemampuan dasar literasi dan numerasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="facility-item hover-grow hover-shadow">
                        <div class="facility-icon bg-success">
                            <span class="bg-success"></span>
                            <i class="fa fa-calculator fa-3x text-success"></i>
                            <span class="bg-success"></span>
                        </div>
                        <div class="facility-text bg-success">
                            <h3 class="text-success mb-3">Matematika</h3>
                            <p class="mb-0">Pembelajaran matematika dengan metode yang menyenangkan untuk meningkatkan kemampuan berhitung anak</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="facility-item hover-grow hover-shadow">
                        <div class="facility-icon bg-warning">
                            <span class="bg-warning"></span>
                            <i class="fa fa-language fa-3x text-warning"></i>
                            <span class="bg-warning"></span>
                        </div>
                        <div class="facility-text bg-warning">
                            <h3 class="text-warning mb-3">Bahasa Inggris</h3>
                            <p class="mb-0">Pembelajaran bahasa Inggris dengan pendekatan komunikatif dan menyenangkan untuk anak-anak</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="facility-item hover-grow hover-shadow">
                        <div class="facility-icon bg-info">
                            <span class="bg-info"></span>
                            <i class="fa fa-graduation-cap fa-3x text-info"></i>
                            <span class="bg-info"></span>
                        </div>
                        <div class="facility-text bg-info">
                            <h3 class="text-info mb-3">Mata Pelajaran SD</h3>
                            <p class="mb-0">Bimbingan untuk semua mata pelajaran SD kelas 1-6 sesuai dengan kurikulum terbaru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Facilities End -->

    <!-- About Start -->
    <div class="container-xxl py-5 parallax-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="mb-4">Tentang Bimbel Alfarizqi</h1>
                    <p>Bimbel Alfarizqi adalah UMKM (Usaha Mikro, Kecil, dan Menengah) bidang pendidikan di Balikpapan yang menyediakan layanan pendidikan nonformal dengan menghadirkan guru pribadi yang mengajar di rumah anak didik.</p>
                    <p class="mb-4">Kami menerima jenjang PAUD, TK, dan SD kelas 1–6, dan menawarkan berbagai materi pembelajaran, seperti CaLisTung (Baca, Tulis, dan Hitung), matematika, bahasa Inggris, hijaiyah, dan semua mata pelajaran SD.</p>
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-6">
                            <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('about') }}">Baca Lebih Lanjut</a>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle flex-shrink-0" src="{{ asset('img/user.jpg') }}" alt="" style="width: 45px; height: 45px;">
                                <div class="ms-3">
                                    <h6 class="text-primary mb-1">Rizqi Fajriah</h6>
                                    <small>Founder Bimbel Alfarizqi</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 about-img wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="img-hover-zoom">
                            <img class="img-fluid w-75 rounded-circle bg-light p-3" src="{{ asset('img/about-1.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-6 text-start" style="margin-top: -150px;">
                            <div class="img-hover-zoom">
                            <img class="img-fluid w-100 rounded-circle bg-light p-3" src="{{ asset('img/about-2.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-6 text-end" style="margin-top: -150px;">
                            <div class="img-hover-zoom">
                            <img class="img-fluid w-100 rounded-circle bg-light p-3" src="{{ asset('img/about-3.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Call To Action Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="bg-light rounded">
                <div class="row g-0">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <img class="position-absolute w-100 h-100 rounded" src="{{ asset('img/call-to-action.jpg') }}" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <div class="h-100 d-flex flex-column justify-content-center p-5">
                            <h1 class="mb-4">Fitur SIBI</h1>
                            <p class="mb-4">Sistem Informasi Bimbel Alfarizqi memiliki fitur-fitur unggulan yang memudahkan orang tua dan guru:
                            </p>
                            <ul class="mb-4">
                                <li>Pantau perkembangan belajar anak secara real-time</li>
                                <li>Lihat riwayat kehadiran dan jadwal pembelajaran</li>
                                <li>Komunikasi langsung dengan guru</li>
                                <li>Laporan kemajuan belajar yang terstruktur</li>
                            </ul>
                            <a class="btn btn-primary py-3 px-5" href="{{ route('login') }}">Masuk Sekarang<i class="fa fa-sign-in-alt ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Call To Action End -->

    <!-- Stats Counter Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-5">Bimbel Alfarizqi dalam Angka</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="fact-item text-center bg-light h-100 p-5 pt-0 hover-shadow">
                        <div class="fact-icon">
                            <i class="fa fa-users fa-4x text-primary mb-4"></i>
                        </div>
                        <h3 class="mb-3 counter">50</h3>
                        <p class="mb-0">Anak Didik Aktif</p>
                                    </div>
                                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="fact-item text-center bg-light h-100 p-5 pt-0 hover-shadow">
                        <div class="fact-icon">
                            <i class="fa fa-chalkboard-teacher fa-4x text-primary mb-4"></i>
                        </div>
                        <h3 class="mb-3 counter">15</h3>
                        <p class="mb-0">Guru Profesional</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="fact-item text-center bg-light h-100 p-5 pt-0 hover-shadow">
                        <div class="fact-icon">
                            <i class="fa fa-book-open fa-4x text-primary mb-4"></i>
                        </div>
                        <h3 class="mb-3 counter">5</h3>
                        <p class="mb-0">Program Pembelajaran</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="fact-item text-center bg-light h-100 p-5 pt-0 hover-shadow">
                        <div class="fact-icon">
                            <i class="fa fa-award fa-4x text-primary mb-4"></i>
                        </div>
                        <h3 class="mb-3 counter">3</h3>
                        <p class="mb-0">Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Stats Counter End -->

    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Ulasan Orang Tua & Guru</h1>
                <p>Dengarkan langsung dari mereka yang telah bergabung dengan Bimbel SIBI.</p>
                                        </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                @forelse($reviews as $review)
                <div class="testimonial-item position-relative bg-light border-top border-5 border-primary rounded p-4 mt-4">
                    <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 65px; height: 65px; margin-top: -35px;">
                        <i class="fa fa-quote-left text-white fs-4"></i>
                                    </div>
                    <p class="mb-4">{{ Str::limit($review->content, 200) }}</p>
                    <div class="d-flex align-items-center">
                        <img class="flex-shrink-0 rounded-circle" src="{{ asset('img/default-avatar.png') }}" alt="{{ $review->user->name }}" style="width: 55px; height: 55px;">
                        <div class="ms-3">
                            <h5 class="mb-1">{{ $review->user->name }}</h5>
                            <span>
                                @if($review->user->role === 'parent')
                                    Orang Tua Murid
                                @elseif($review->user->role === 'teacher')
                                    Guru
                                @else
                                    Pengguna Bimbel SIBI
                                @endif
                            </span>
                            <div class="mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                                        </div>
                                    </div>
                                        </div>
                @empty
                <div class="testimonial-item position-relative bg-light border-top border-5 border-primary rounded p-4 mt-4">
                    <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 65px; height: 65px; margin-top: -35px;">
                        <i class="fa fa-quote-left text-white fs-4"></i>
                                    </div>
                    <p class="mb-4">Belum ada ulasan yang tersedia. Jadilah yang pertama memberikan ulasan!</p>
                    <div class="d-flex align-items-center">
                        <div class="ms-3">
                            <a href="{{ route('testimonial') }}" class="btn btn-primary">Lihat Semua Ulasan</a>
                        </div>
                    </div>
                </div>
                @endforelse
                
                <!-- Tombol untuk lihat semua ulasan -->
                <div class="testimonial-item position-relative bg-light border-top border-5 border-primary rounded p-4 mt-4">
                    <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 65px; height: 65px; margin-top: -35px;">
                        <i class="fa fa-comments text-white fs-4"></i>
                    </div>
                    <p class="mb-4 text-center">Ingin melihat lebih banyak ulasan dari orang tua dan guru?</p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('testimonial') }}" class="btn btn-primary">Lihat Semua Ulasan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Programs Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Program Pembelajaran Terstruktur</h1>
                <p>Kami menawarkan berbagai program belajar terstruktur untuk anak usia dini hingga SD kelas 6 dengan metode pembelajaran yang menyenangkan.</p>
            </div>
            <div class="row g-4">
                <!-- Default static program cards for when database is unavailable -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="class-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('img/program-1.jpg') }}" alt="">
                        </div>
                        <div class="bg-light rounded-bottom p-4 pt-5 mt-n5">
                            <div class="d-block bg-primary rounded text-white position-absolute top-0 start-50 translate-middle py-2 px-3">
                                PAUD & TK
                            </div>
                            <h5 class="mb-3">Program Pendidikan Anak Usia Dini</h5>
                            <div class="mb-3 d-flex justify-content-between">
                                <small class="text-primary"><i class="fa fa-star me-2"></i>4.9/5</small>
                                <small class="text-primary"><i class="fa fa-user-graduate me-2"></i>Usia 3-6 Tahun</small>
                            </div>
                            <p class="mb-4">Pembelajaran fondasi dasar untuk anak PAUD dan TK dengan fokus pada:</p>
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-primary rounded-pill mb-2 me-1 p-2">Calistung</span>
                                <span class="badge bg-primary rounded-pill mb-2 me-1 p-2">Motorik</span>
                                <span class="badge bg-primary rounded-pill mb-2 p-2">Hijaiyah</span>
                            </div>
                            <div class="d-flex mt-4">
                                <a class="btn btn-sm btn-primary rounded-pill px-3" href="{{ route('about') }}#programs">Detail Program</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="class-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('img/program-2.jpg') }}" alt="">
                        </div>
                        <div class="bg-light rounded-bottom p-4 pt-5 mt-n5">
                            <div class="d-block bg-warning rounded text-white position-absolute top-0 start-50 translate-middle py-2 px-3">
                                SD Kelas 1-3
                            </div>
                            <h5 class="mb-3">Program SD Awal</h5>
                            <div class="mb-3 d-flex justify-content-between">
                                <small class="text-warning"><i class="fa fa-star me-2"></i>4.8/5</small>
                                <small class="text-warning"><i class="fa fa-user-graduate me-2"></i>Usia 7-9 Tahun</small>
                            </div>
                            <p class="mb-4">Penguatan kemampuan dasar literasi, numerasi, dan mata pelajaran SD kelas awal:</p>
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-warning rounded-pill mb-2 me-1 p-2">Matematika</span>
                                <span class="badge bg-warning rounded-pill mb-2 me-1 p-2">B. Indonesia</span>
                                <span class="badge bg-warning rounded-pill mb-2 p-2">B. Inggris</span>
                            </div>
                            <div class="d-flex mt-4">
                                <a class="btn btn-sm btn-warning rounded-pill px-3" href="{{ route('about') }}#programs">Detail Program</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="class-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('img/program-3.jpg') }}" alt="">
                        </div>
                        <div class="bg-light rounded-bottom p-4 pt-5 mt-n5">
                            <div class="d-block bg-success rounded text-white position-absolute top-0 start-50 translate-middle py-2 px-3">
                                SD Kelas 4-6
                            </div>
                            <h5 class="mb-3">Program SD Lanjutan</h5>
                            <div class="mb-3 d-flex justify-content-between">
                                <small class="text-success"><i class="fa fa-star me-2"></i>4.7/5</small>
                                <small class="text-success"><i class="fa fa-user-graduate me-2"></i>Usia 10-12 Tahun</small>
                            </div>
                            <p class="mb-4">Pendalaman materi pelajaran SD kelas tinggi dan persiapan ujian:</p>
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-success rounded-pill mb-2 me-1 p-2">Matematika</span>
                                <span class="badge bg-success rounded-pill mb-2 me-1 p-2">IPA</span>
                                <span class="badge bg-success rounded-pill mb-2 p-2">IPS</span>
                            </div>
                            <div class="d-flex mt-4">
                                <a class="btn btn-sm btn-success rounded-pill px-3" href="{{ route('about') }}#programs">Detail Program</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Programs End -->

    <!-- Appointment Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="bg-light rounded">
                <div class="row g-0">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="h-100 d-flex flex-column justify-content-center p-5">
                            <h1 class="mb-4">Tertarik Mendaftarkan Anak Anda?</h1>
                            <p class="mb-4">Mulai perjalanan belajar anak Anda bersama Bimbel Alfarizqi. Isi formulir di samping atau hubungi kami langsung untuk konsultasi gratis.</p>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
                                        <i class="fa fa-phone-alt fs-4 text-primary"></i>
            </div>
                                    <div class="ms-4">
                                        <p class="mb-2">Telepon/WA</p>
                                        <h5 class="mb-0">+62 812 3456 7890</h5>
                        </div>
                    </div>
                </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <!-- Registration Form -->
                            <div class="registration-form">
                                <h2>Daftar Sekarang</h2>
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('register.store') }}" method="POST">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                            id="parentName" name="parent_name" 
                                            placeholder=" "
                                            value="{{ old('parent_name') }}" required>
                                        <label for="parentName">Nama Orang Tua</label>
                                        @error('parent_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('child_name') is-invalid @enderror" 
                                            id="childName" name="child_name" 
                                            placeholder=" "
                                            value="{{ old('child_name') }}" required>
                                        <label for="childName">Nama Anak</label>
                                        @error('child_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select @error('grade') is-invalid @enderror" 
                                            id="grade" name="grade" required>
                                            <option value="" selected disabled></option>
                                            <option value="PAUD" {{ old('grade') == 'PAUD' ? 'selected' : '' }}>PAUD (2-4 tahun)</option>
                                            <option value="TK" {{ old('grade') == 'TK' ? 'selected' : '' }}>TK (4-6 tahun)</option>
                                            <option value="SD1-3" {{ old('grade') == 'SD1-3' ? 'selected' : '' }}>SD Kelas 1-3</option>
                                            <option value="SD4-6" {{ old('grade') == 'SD4-6' ? 'selected' : '' }}>SD Kelas 4-6</option>
                                        </select>
                                        <label for="grade">Pilih Jenjang</label>
                                        @error('grade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                            id="phone" name="phone" 
                                            placeholder=" "
                                            value="{{ old('phone') }}" 
                                            required pattern="[0-9]{10,13}">
                                        <label for="phone">Nomor Telepon/WA</label>
                                        <div class="form-text">Contoh: 081234567890</div>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                            id="message" name="message" 
                                            placeholder=" "
                                            style="height: 120px">{{ old('message') }}</textarea>
                                        <label for="message">Pesan (Opsional)</label>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-register">
                                        Daftar Sekarang
                                    </button>
                                </form>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Appointment End -->
@endsection 