@extends('layouts.dashboard')

@section('title', 'Daftar Siswa')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Siswa</h1>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        <a href="{{ route('students.create') }}" class="btn btn-success">
            <i class="fas fa-user-plus me-2"></i> Tambah Siswa Baru
        </a>
        @endif
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
                    <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                            <a class="dropdown-item" href="{{ route('students.create') }}">Tambah Siswa</a>
                            <a class="dropdown-item" href="#" id="exportDataBtn">Export Data</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('students.index') }}">Refresh Data</a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('students.index') }}" method="GET">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari siswa...">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="studentsTable" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Program</th>
                                    <th>Orang Tua</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-circle bg-primary text-white">
                                                    {{ substr($student->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div>
                                                <span class="fw-medium">{{ $student->name }}</span>
                                                @if($student->program)
                                                <br>
                                                <small class="text-muted">Program: {{ $student->program }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->program }}</td>
                                    <td>
                                        @if($student->parent)
                                        {{ $student->parent->name }}
                                        @else
                                        <span class="text-muted">Belum ditentukan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-user-graduate fa-3x text-gray-300 mb-3"></i>
                                            <h5 class="mb-0">Belum ada data siswa</h5>
                                            <p class="text-muted">Belum ada siswa yang terdaftar dalam sistem</p>
                                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                                            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary mt-2">
                                                <i class="fas fa-plus me-1"></i> Tambah Siswa
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Controls -->
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Menampilkan {{ $students->firstItem() ?? 0 }}-{{ $students->lastItem() ?? 0 }} dari {{ $students->total() ?? 0 }} data
                            </small>
                        </div>
                        <div>
                            @if ($students->onFirstPage())
                                <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                            @else
                                <a href="{{ $students->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                            @endif

                            @if ($students->hasMorePages())
                                <a href="{{ $students->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
                            @else
                                <button class="btn btn-sm btn-outline-secondary" disabled>Next</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    
    .avatar-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Pagination Styles */
    .btn-outline-primary {
        color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-outline-primary:hover {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }

    .btn-outline-secondary:disabled {
        color: #6c757d;
        background-color: transparent;
        opacity: 0.65;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Confirm delete
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus siswa ini?')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
 
 