@extends('layouts.app')

@section('title', 'Ulasan - Sistem Informasi Bimbel Alfarizqi')

@section('styles')
<style>
    /* Styling untuk tombol navigasi carousel */
    .owl-nav-buttons {
        position: absolute;
        bottom: -60px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .carousel-prev,
    .carousel-next {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #FE5D37;
        color: white;
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .carousel-prev:hover,
    .carousel-next:hover {
        background-color: #e04d29;
        transform: translateY(-3px);
    }

    .testimonial-carousel .testimonial-item {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
    }

    .testimonial-carousel .owl-item.center .testimonial-item {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .testimonial-carousel .owl-item:not(.center) .testimonial-item {
        opacity: 0.8;
    }

    .testimonial-section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
    }
    
    .testimonial-section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(to right, #FE5D37, transparent);
        width: 80px;
        margin: 0 auto;
    }

    .carousel-container {
        padding-top: 20px;
        padding-bottom: 80px;
    }

    @media (max-width: 768px) {
        .testimonial-carousel .owl-item.center .testimonial-item {
            transform: scale(1.05);
        }
    }
</style>
@endsection

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header testimonial-header mb-5 p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="container-fluid">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h1 class="display-4 text-white animated slideInDown mb-3">Ulasan</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ulasan</li>
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

    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Apa Kata Mereka?</h1>
                <p>Berikut adalah testimoni dari orang tua anak didik yang telah mempercayakan pendidikan anak mereka kepada Bimbel SIBI.</p>
            </div>
            
            <!-- Testimonial Carousel -->
            <div class="position-relative mb-5 carousel-container">
                <h4 class="text-center testimonial-section-title wow fadeInUp" data-wow-delay="0.2s">Jelajahi Ulasan</h4>
                
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    @forelse($reviews as $review)
                <div class="testimonial-item position-relative bg-light border-top border-5 border-primary rounded p-4 mt-4">
                    <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 65px; height: 65px; margin-top: -35px;">
                        <i class="fa fa-quote-left text-white fs-4"></i>
                        </div>
                        <p class="mb-4">{{ $review->content }}</p>
                    <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 rounded-circle bg-{{ $review->user->role === 'parent' ? 'info' : ($review->user->role === 'teacher' ? 'success' : 'primary') }} d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="fa fa-{{ $review->user->role === 'parent' ? 'user-friends' : ($review->user->role === 'teacher' ? 'chalkboard-teacher' : 'user') }} text-white fa-2x"></i>
                            </div>
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
                        <p class="mb-4">Belum ada ulasan yang tersedia saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <!-- End Testimonial Carousel -->
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Hasil Belajar Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Hasil Belajar Anak Didik</h1>
                <p>Berikut adalah beberapa pencapaian dan peningkatan kemampuan yang telah diraih oleh anak didik Bimbel Alfarizqi.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-book-reader fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Kemampuan Membaca</h5>
                        <p class="mb-4">85% anak TK dan PAUD di Bimbel Alfarizqi mengalami peningkatan signifikan dalam kemampuan membaca setelah 3 bulan belajar.</p>
                        <div class="progress-section">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-calculator fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Kemampuan Matematika</h5>
                        <p class="mb-4">78% anak SD di Bimbel Alfarizqi mengalami peningkatan nilai matematika di sekolah formal mereka.</p>
                        <div class="progress-section">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">78%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item d-flex flex-column text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-language fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Bahasa Inggris</h5>
                        <p class="mb-4">72% anak didik menunjukkan peningkatan pemahaman dan penguasaan kosakata bahasa Inggris dasar.</p>
                        <div class="progress-section">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100">72%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hasil Belajar End -->

    <!-- Kirim Ulasan Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="bg-light rounded">
                <div class="row g-0">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <div class="position-absolute w-100 h-100 rounded" 
                                style="background: linear-gradient(135deg, #FE5D37 0%, #FF8F7D 100%);
                                       opacity: 0.1;"></div>
                            <div class="position-absolute w-100 h-100 rounded d-flex align-items-center justify-content-center">
                                <div class="text-center p-4">
                                    <i class="fas fa-quote-left fa-3x text-primary mb-3"></i>
                                    <h4 class="text-primary mb-3">Berbagi Cerita Sukses</h4>
                                    <p class="text-dark mb-0">Setiap pengalaman yang Anda bagikan akan membantu orang tua lain dalam memilih pendidikan terbaik untuk anak mereka.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <div class="h-100 d-flex flex-column justify-content-center p-5">
                            <h1 class="mb-4">Bagikan Pengalaman Anda</h1>
                            <p class="mb-4">Jika Anda adalah orang tua dari anak didik Bimbel SIBI, kami sangat menghargai jika Anda dapat berbagi pengalaman dan kesan selama anak Anda belajar bersama kami.</p>
                            
                            @auth
                                <div class="text-center">
                                    <a href="{{ route('reviews.create') }}" class="btn btn-primary py-3 px-5">
                                        <i class="fas fa-edit me-2"></i> Tulis Ulasan Baru
                                    </a>
                                        </div>
                            @else
                                <div class="text-center">
                                    <p>Silakan login untuk memberikan ulasan Anda</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary py-3 px-5">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login Untuk Menulis Ulasan
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kirim Ulasan End -->

    <!-- Galeri Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Galeri Aktivitas</h1>
                <p>Berikut adalah beberapa kegiatan pembelajaran yang dilakukan oleh anak didik bersama tutor Bimbel Alfarizqi.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative rounded overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('img/gallery-1.jpg') }}" alt="">
                        <div class="gallery-overlay d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h5 class="text-white">Belajar Berhitung</h5>
                                <p class="text-white">Anak didik TK belajar berhitung dengan metode menyenangkan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="position-relative rounded overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('img/gallery-2.jpg') }}" alt="">
                        <div class="gallery-overlay d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h5 class="text-white">Belajar Membaca</h5>
                                <p class="text-white">Kegiatan belajar membaca untuk anak PAUD</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative rounded overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('img/gallery-3.jpg') }}" alt="">
                        <div class="gallery-overlay d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h5 class="text-white">Pelajaran Matematika</h5>
                                <p class="text-white">Anak SD sedang belajar matematika dengan tutor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Galeri End -->
@endsection 
 
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Testimonial Carousel
        var testimonialCarousel = $('.testimonial-carousel').owlCarousel({
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 1000,
            center: true,
            margin: 24,
            dots: true,
            loop: true,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });

        // Tombol navigasi kustom
        $('.carousel-next').click(function() {
            testimonialCarousel.trigger('next.owl.carousel');
        });
        
        $('.carousel-prev').click(function() {
            testimonialCarousel.trigger('prev.owl.carousel');
        });
    });
</script>
@endsection 