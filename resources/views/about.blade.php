@extends('layouts.app')

@section('title', 'Tentang Kami - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header about-header mb-5 p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="container-fluid">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h1 class="display-4 text-white animated slideInDown mb-3">Tentang Kami</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
                    </ol>
                </nav>
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
    <!-- Page Header End -->

    <!-- About Start -->
    <div class="container-xxl py-5 parallax-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="mb-4">Bimbingan Belajar Alfarizqi</h1>
                    <p class="mb-4">Bimbel Alfarizqi adalah lembaga pendidikan non-formal yang fokus pada pendidikan anak usia dini (PAUD), taman kanak-kanak (TK), dan sekolah dasar (SD) dengan pendekatan pembelajaran personal melalui tutor yang datang ke rumah.</p>
                    <p class="mb-4">Didirikan pada tahun 2018, Bimbel Alfarizqi hadir untuk memberikan solusi pendidikan berkualitas dengan metode yang disesuaikan dengan karakter dan kebutuhan masing-masing anak.</p>
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-users fa-3x text-primary flex-shrink-0"></i>
                                <div class="ms-3">
                                    <h2 class="mb-0" data-toggle="counter-up">45</h2>
                                    <p class="mb-0">Anak Didik Aktif</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-tie fa-3x text-primary flex-shrink-0"></i>
                                <div class="ms-3">
                                    <h2 class="mb-0" data-toggle="counter-up">12</h2>
                                    <p class="mb-0">Tutor Profesional</p>
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

    <!-- Visi Misi Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Visi & Misi</h1>
                <p>Bimbel Alfarizqi memiliki tujuan dan arah yang jelas dalam mengembangkan pendidikan anak-anak.</p>
            </div>
            <div class="bg-light rounded p-4 p-sm-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative overflow-hidden h-100" style="min-height: 400px;">
                            <img class="position-absolute w-100 h-100 rounded" src="{{ asset('img/vision.jpg') }}" alt="" style="object-fit: cover;">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-10 text-center">
                                            <h2 class="display-4 text-white animated slideInDown mb-4">Pendidikan Berkualitas</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <div class="h-100">
                            <div class="d-inline-block rounded-pill bg-primary text-white px-4 mb-4">Visi & Misi</div>
                            <div class="d-flex align-items-center mb-4 bg-white p-4 rounded shadow-sm">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle" style="width: 50px; height: 50px;">
                                    <i class="fa fa-eye text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-1">Visi</h5>
                                    <p class="mb-0">Menjadi lembaga pendidikan non-formal terdepan yang membentuk generasi berakhlak mulia, cerdas, dan mandiri.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4 bg-white p-4 rounded shadow-sm">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle" style="width: 50px; height: 50px;">
                                    <i class="fa fa-bullseye text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-1">Misi</h5>
                                    <p class="mb-0">Memberikan pendidikan berkualitas yang menyenangkan, mengembangkan potensi akademik dan karakter anak, serta mendampingi orang tua dalam proses pendidikan anak.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center bg-white p-4 rounded shadow-sm">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle" style="width: 50px; height: 50px;">
                                    <i class="fa fa-handshake text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-1">Komitmen</h5>
                                    <p class="mb-0">Kami berkomitmen membantu anak didik mengembangkan potensi akademik dan karakternya melalui bimbingan belajar yang efektif dan menyenangkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Visi Misi End -->

    <!-- Program Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Program Kami</h1>
                <p>Bimbel Alfarizqi menawarkan berbagai program belajar yang disesuaikan dengan kebutuhan dan tingkat pendidikan anak didik.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="facility-item hover-grow hover-shadow">
                        <div class="facility-icon bg-primary">
                            <span class="bg-primary"></span>
                            <i class="fa fa-book fa-3x text-primary"></i>
                            <span class="bg-primary"></span>
                        </div>
                        <div class="facility-text bg-primary">
                            <h3 class="text-primary mb-3">Program PAUD & TK</h3>
                            <p class="mb-0">Pembelajaran mendasar untuk anak usia dini dengan fokus pada Calistung, Motorik Halus, dan Dasar Bahasa Inggris.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="facility-item hover-grow hover-shadow">
                        <div class="facility-icon bg-success">
                            <span class="bg-success"></span>
                            <i class="fa fa-calculator fa-3x text-success"></i>
                            <span class="bg-success"></span>
                        </div>
                        <div class="facility-text bg-success">
                            <h3 class="text-success mb-3">Program SD Kelas 1-3</h3>
                            <p class="mb-0">Pendampingan belajar untuk siswa kelas 1-3 sekolah dasar dengan metode menyenangkan dan mudah dipahami.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="facility-item hover-grow hover-shadow">
                        <div class="facility-icon bg-warning">
                            <span class="bg-warning"></span>
                            <i class="fa fa-graduation-cap fa-3x text-warning"></i>
                            <span class="bg-warning"></span>
                        </div>
                        <div class="facility-text bg-warning">
                            <h3 class="text-warning mb-3">Program SD Kelas 4-6</h3>
                            <p class="mb-0">Pendalaman materi pelajaran dan persiapan ujian untuk siswa kelas 4-6 sekolah dasar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Program End -->

    <!-- Tutor Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Tim Tutor Kami</h1>
                <p>Tim tutor kami terdiri dari profesional pendidikan yang berpengalaman dan memiliki komitmen tinggi dalam mendidik anak.</p>
            </div>
            <div class="row g-4">
                @if(isset($popularTeachers) && $popularTeachers->count() > 0)
                    @foreach($popularTeachers as $teacher)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item position-relative">
                            <img class="img-fluid rounded-circle w-75 mx-auto" src="{{ asset($teacher->image ?? 'img/team-1.jpg') }}" alt="{{ $teacher->name }}">
                            <div class="team-text">
                                <h4>{{ $teacher->name }}</h4>
                                <p>{{ $teacher->position }}</p>
                                <div class="d-flex align-items-center">
                                    <a class="btn btn-square btn-primary mx-1" href="{{ $teacher->facebook_url ?? '#' }}"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary mx-1" href="{{ $teacher->instagram_url ?? '#' }}"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item position-relative">
                            <img class="img-fluid rounded-circle w-75 mx-auto" src="{{ asset('img/team-1.jpg') }}" alt="">
                            <div class="team-text">
                                <h4>Anisa Rahmawati, S.Pd</h4>
                                <p>Koordinator Program PAUD & TK</p>
                                <div class="d-flex align-items-center">
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item position-relative">
                            <img class="img-fluid rounded-circle w-75 mx-auto" src="{{ asset('img/team-2.jpg') }}" alt="">
                            <div class="team-text">
                                <h4>Budi Santoso, S.Pd</h4>
                                <p>Koordinator Program SD</p>
                                <div class="d-flex align-items-center">
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item position-relative">
                            <img class="img-fluid rounded-circle w-75 mx-auto" src="{{ asset('img/team-3.jpg') }}" alt="">
                            <div class="team-text">
                                <h4>Diana Putri, S.S</h4>
                                <p>Spesialis Bahasa Inggris</p>
                                <div class="d-flex align-items-center">
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Tutor End -->

    <!-- Keunggulan Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Keunggulan Kami</h1>
                <p>Mengapa memilih Bimbel Alfarizqi untuk mendampingi proses belajar anak Anda?</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-home fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Belajar di Rumah</h5>
                        <p class="m-0">Tutor datang ke rumah sehingga anak dapat belajar di lingkungan yang nyaman dan aman</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-user-graduate fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Tutor Berkualitas</h5>
                        <p class="m-0">Tim tutor lulusan perguruan tinggi dengan pengalaman mengajar dan terlatih dalam mendidik anak</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-book-open fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Kurikulum Terstruktur</h5>
                        <p class="m-0">Materi pembelajaran terstruktur yang disesuaikan dengan kurikulum nasional dan kebutuhan anak</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-chart-line fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Pemantauan Kemajuan</h5>
                        <p class="m-0">Sistem pemantauan kemajuan belajar anak yang memudahkan orang tua memantau perkembangan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Keunggulan End -->

    <!-- Call to Action Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="bg-light rounded">
                <div class="row g-0">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="h-100 d-flex flex-column justify-content-center p-5">
                            <h1 class="mb-4">Bergabung dengan Bimbel Alfarizqi</h1>
                            <p class="mb-4">Jadikan anak Anda siap menghadapi masa depan dengan pendidikan yang berkualitas bersama Bimbel Alfarizqi. Kami siap membantu mereka mencapai potensi terbaik.</p>
                            <a class="btn btn-primary py-3 px-5" href="{{ route('contact') }}">Hubungi Kami Sekarang</a>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <img class="position-absolute w-100 h-100 rounded" src="{{ asset('img/call-to-action.jpg') }}" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->
@endsection