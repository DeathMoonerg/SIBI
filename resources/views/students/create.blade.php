@extends('layouts.dashboard')

@section('title', 'Tambah Siswa')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form Tambah Siswa</h1>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Siswa</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name') }}" required
                                        placeholder="Masukkan nama lengkap siswa">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="grade" class="form-label">Kelas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('grade') is-invalid @enderror" 
                                        id="grade" name="grade" value="{{ old('grade') }}" required
                                        placeholder="Contoh: TK-A, TK-B, SD-1, SD-2, dll">
                                    @error('grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="parent_id" class="form-label">Orang Tua <span class="text-danger">*</span></label>
                                    <select class="form-select @error('parent_id') is-invalid @enderror" 
                                        id="parent_id" name="parent_id" required>
                                        <option value="">Pilih Orang Tua</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ (old('parent_id') == $parent->id) ? 'selected' : '' }}>
                                                {{ $parent->name }} ({{ $parent->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Siswa akan menggunakan akun orang tua ini</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="teacher_id" class="form-label">Guru <span class="text-danger">*</span></label>
                                    <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                        id="teacher_id" name="teacher_id" required>
                                        <option value="">Pilih Guru</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="program" class="form-label">Program</label>
                                    <input type="text" class="form-control" id="program" name="program" 
                                           value="{{ old('program') }}" required
                                           placeholder="Contoh: Matematika SD, IPA SD, Bahasa Indonesia SD, Paket Lengkap SD">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                        id="address" name="address" rows="3" required
                                        placeholder="Masukkan alamat lengkap siswa">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('students.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success me-2">
                                <i class="fas fa-save me-2"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

 