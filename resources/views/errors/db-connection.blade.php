@extends('layouts.app')

@section('title', 'Masalah Koneksi Database - Sistem Informasi Bimbel Alfarizqi')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <h1><i class="fa fa-database me-3"></i> Masalah Koneksi Database</h1>
                    <p class="lead">Mohon maaf, saat ini kami mengalami masalah koneksi ke database.</p>
                    <hr>
                    <div class="mt-4">
                        <h4>Apa yang dapat Anda lakukan?</h4>
                        <ul class="mt-3">
                            <li>Tunggu beberapa saat dan <a href="{{ url('/') }}" class="alert-link">coba lagi</a>.</li>
                            <li>Hubungi administrator sistem jika masalah berlanjut.</li>
                        </ul>
                    </div>
                    
                    @if(config('app.debug'))
                    <div class="mt-4 p-3 bg-light rounded">
                        <h5>Informasi untuk Administrator:</h5>
                        <ul>
                            <li>Pastikan server database aktif dan berjalan</li>
                            <li>Periksa konfigurasi database di file .env</li>
                            <li>Jalankan migrasi database: <code>php artisan migrate</code></li>
                            <li>Cek log error di <code>storage/logs/laravel.log</code></li>
                        </ul>
                    </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 