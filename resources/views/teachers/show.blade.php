@extends('layouts.dashboard')

@section('title', 'Detail Guru')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4 gap-2">
        <h1 class="h3 mb-0 text-gray-800">Detail Guru</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-secondary shadow-sm">
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
    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Guru</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <span class="d-inline-block bg-light rounded-circle mb-2" style="width:100px; height:100px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-chalkboard-teacher fa-3x text-success"></i>
                        </span>
                        <h5 class="mt-3">{{ $teacher->name }}</h5>
                        <span class="badge badge-info">Guru</span>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Email:</div>
                        <div class="col-7">{{ $teacher->email }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">No. Telepon:</div>
                        <div class="col-7">{{ $teacher->phone ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Alamat:</div>
                        <div class="col-7">{{ $teacher->address ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Terdaftar Pada:</div>
                        <div class="col-7">{{ $teacher->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <div class="icon-circle bg-primary text-white">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="small text-gray-500">Total Siswa</div>
                            <h5 class="mb-0">{{ $teacher->students->count() }}</h5>
                        </div>
                    </div>
                    
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <div class="icon-circle bg-success text-white">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="small text-gray-500">Total Pertemuan</div>
                            <h5 class="mb-0">{{ isset($totalPertemuan) ? $totalPertemuan : 0 }}</h5>
                        </div>
                    </div>
                    
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="icon-circle bg-info text-white">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="small text-gray-500">Total Laporan</div>
                            <h5 class="mb-0">{{ isset($totalLaporan) ? $totalLaporan : 0 }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-8">
            <!-- Students List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
                </div>
                <div class="card-body">
                    @if($teacher->students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Program</th>
                                    <th>Kelas</th>
                                    <th>Orang Tua</th>
                                    @if(auth()->user()->role !== 'admin')
                                    <th class="text-end">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teacher->students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->program ?? '-' }}</td>
                                    <td>{{ $student->grade ?? '-' }}</td>
                                    <td>{{ $student->parent ? $student->parent->name : '-' }}</td>
                                    @if(auth()->user()->role !== 'admin')
                                    <td class="text-end">
                                        <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '4' : '5' }}" class="text-center">Tidak ada data siswa</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-3">
                        <p class="mb-0">Belum ada siswa yang diajar oleh guru ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .icon-circle {
            height: 2rem;
            width: 2rem;
        }

        .icon-circle i {
            font-size: 0.875rem;
        }

        .card-header h6 {
            font-size: 0.875rem;
        }

        .table th, .table td {
            font-size: 0.875rem;
        }
    }
</style>
@endpush 