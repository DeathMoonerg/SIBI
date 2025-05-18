@extends('layouts.dashboard')

@section('title', 'Detail Orang Tua')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Orang Tua</h1>
        <div>
            <a href="{{ route('parents.edit', $parent) }}" class="btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('parents.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Orang Tua</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block mb-3">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="fas fa-user-friends fa-3x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mt-3">{{ $parent->name }}</h5>
                        <span class="badge badge-primary">Orang Tua</span>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Email:</div>
                        <div class="col-7">{{ $parent->email }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Telepon:</div>
                        <div class="col-7">{{ $parent->phone ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Alamat:</div>
                        <div class="col-7">{{ $parent->address ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Terdaftar Pada:</div>
                        <div class="col-7">{{ $parent->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Anak</h6>
                </div>
                <div class="card-body">
                    @if(count($children) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Program</th>
                                    <th>Kelas/Grade</th>
                                    @if(auth()->user()->role !== 'admin')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parent->children as $child)
                                <tr>
                                    <td>{{ $child->name }}</td>
                                    <td>{{ $child->email }}</td>
                                    <td>{{ $child->program ?? '-' }}</td>
                                    <td>{{ $child->grade ?? '-' }}</td>
                                    @if(auth()->user()->role !== 'admin')
                                    <td>
                                        <a href="{{ route('students.show', $child) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '4' : '5' }}" class="text-center">Tidak ada data anak</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-3">
                        <p class="mb-0">Belum ada anak yang terdaftar untuk orang tua ini.</p>
                        <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-plus fa-sm"></i> Tambah Anak
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 