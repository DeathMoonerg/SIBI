@extends('layouts.app')

@section('title', 'Popular Teachers - Kider Preschool')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Teachers</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Teachers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Popular Teachers</h1>
                <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero ipsum sit
                    eirmod sit. Ipsum diam justo sed rebum vero dolor duo.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-1.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-2.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-3.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-1.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-2.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-3.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-1.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-2.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item position-relative">
                        <img class="img-fluid rounded-circle w-75" src="{{ asset('img/team-3.jpg') }}" alt="">
                        <div class="team-text">
                            <h3>Full Name</h3>
                            <p>Designation</p>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary  mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->
@endsection 