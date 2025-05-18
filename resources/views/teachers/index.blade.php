@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.dashboard')

@section('title', 'Manajemen Guru - SIBI')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <h5 class="mb-0">Daftar Guru</h5>
                    <a href="{{ route('teachers.create') }}" class="btn btn-success w-100 w-md-auto" title="Tambah Guru Baru">
                        <i class="fas fa-plus"></i> Tambah Guru
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(count($teachers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teachers as $teacher)
                                        <tr>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->email }}</td>
                                            <td>{{ $teacher->phone }}</td>
                                            <td>{{ Str::limit($teacher->address, 30) }}</td>
                                            <td>
                                                <div class="d-flex gap-1 justify-content-end">
                                                    <a href="{{ route('teachers.show', $teacher->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($teachers instanceof \Illuminate\Pagination\LengthAwarePaginator && $teachers->total() > 0)
                        <div class="mt-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $teachers->firstItem() }}-{{ $teachers->lastItem() }} dari {{ $teachers->total() }} data
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                @if ($teachers->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                                @else
                                    <a href="{{ $teachers->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                                @endif

                                @if ($teachers->hasMorePages())
                                    <a href="{{ $teachers->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled>Next</button>
                                @endif
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-user-graduate fa-4x text-muted"></i>
                            </div>
                            <h5>Belum Ada Data Guru</h5>
                            <p class="text-muted">Belum ada data guru yang ditambahkan. Silakan tambahkan guru baru.</p>
                            <a href="{{ route('teachers.create') }}" class="btn btn-success" title="Tambah Guru Baru">
                                <i class="fas fa-plus"></i> Tambah Guru
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
 
 