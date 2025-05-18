@extends('layouts.app')

@section('title', 'Kontak - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header contact-header mb-5 p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="container-fluid">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h1 class="display-4 text-white animated slideInDown mb-3">Kontak</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kontak</li>
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

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Hubungi Kami</h1>
                <p>Untuk informasi lebih lanjut mengenai program Bimbel Alfarizqi atau pendaftaran, silakan hubungi kami melalui kontak di bawah ini atau isi formulir yang tersedia.</p>
            </div>
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-4 text-center wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 75px; height: 75px;">
                        <i class="fa fa-map-marker-alt fa-2x text-primary"></i>
                    </div>
                    <h6>Kantor Pusat</h6>
                    <p class="mb-0">Jl. Pendidikan No. 123, Balikpapan, Indonesia</p>
                </div>
                <div class="col-md-6 col-lg-4 text-center wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 75px; height: 75px;">
                        <i class="fa fa-phone-alt fa-2x text-primary"></i>
                    </div>
                    <h6>Telepon / WhatsApp</h6>
                    <p class="mb-0">+62 812 3456 7890</p>
                </div>
                <div class="col-md-6 col-lg-4 text-center wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 75px; height: 75px;">
                        <i class="fa fa-envelope-open fa-2x text-primary"></i>
                    </div>
                    <h6>Email</h6>
                    <p class="mb-0">info@bimbelalfarizqi.com</p>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="mb-4">Kirim Pesan</h3>
                    <p class="mb-4">Jika Anda memiliki pertanyaan tentang program bimbingan belajar kami atau ingin mendaftarkan anak Anda, silakan kirimkan pesan melalui formulir di bawah ini. Tim kami akan segera menghubungi Anda kembali.</p>
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}">
                                    <label for="name">Nama Lengkap</label>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                    <label for="email">Email</label>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Nomor Telepon/WA" value="{{ old('phone') }}">
                                    <label for="phone">Nomor Telepon/WA</label>
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subjek" value="{{ old('subject') }}">
                                    <label for="subject">Subjek</label>
                                    @error('subject')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Tulis pesan Anda di sini" id="message" name="message" style="height: 150px">{{ old('message') }}</textarea>
                                    <label for="message">Pesan</label>
                                    @error('message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                        <iframe class="position-relative rounded w-100 h-100" 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8138362745027!2d116.85865151101786!3d-1.2656133356582937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df146e9cbf0b165%3A0x93ebbed3944a498a!2sBalikpapan%2C%20Kota%20Balikpapan%2C%20Kalimantan%20Timur!5e0!3m2!1sid!2sid!4v1647415862329!5m2!1sid!2sid"
                            frameborder="0" style="min-height: 400px; border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>

            <!-- Kontak Form dengan Layout Sesuai Ulasan -->
            <div class="container-xxl py-5">
                <div class="bg-light rounded">
                    <div class="row g-0">
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                            <div class="position-relative h-100">
                                <div class="position-absolute w-100 h-100 rounded" 
                                    style="background: linear-gradient(135deg, #FE5D37 0%, #FF8F7D 100%);
                                           opacity: 0.1;"></div>
                                <div class="position-absolute w-100 h-100 rounded d-flex align-items-center justify-content-center">
                                    <div class="text-center p-4">
                                        <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                                        <h4 class="text-primary mb-3">Lokasi Kami</h4>
                                        <p class="text-dark mb-0">Kunjungi kantor pusat kami di Jl. Pendidikan No. 123, Balikpapan, Indonesia atau minta tutor kami datang langsung ke rumah Anda!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="h-100 d-flex flex-column justify-content-center p-5">
                                <h1 class="mb-4">Hubungi Kami</h1>
                                <p class="mb-4">Anda dapat menghubungi kami melalui berbagai cara berikut untuk mendapatkan informasi lebih lanjut tentang program bimbingan belajar kami.</p>
                                
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fa fa-phone-alt fa-lg text-white"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Telepon / WhatsApp</h5>
                                        <p class="mb-0">+62 812 3456 7890</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fa fa-envelope fa-lg text-white"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Email</h5>
                                        <p class="mb-0">info@bimbelalfarizqi.com</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fa fa-map-marker-alt fa-lg text-white"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Alamat</h5>
                                        <p class="mb-0">Jl. Pendidikan No. 123, Balikpapan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Kontak Form dengan Layout Sesuai Ulasan -->
        </div>
    </div>
    <!-- Contact End -->
@endsection 