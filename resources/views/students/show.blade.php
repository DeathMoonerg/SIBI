@extends('layouts.dashboard')

@section('title', 'Detail Siswa')

@section('styles')
<style>
.progress-bar-custom {
    height: 8px;
}

.progress-bar-custom .progress-bar {
    transition: width 0.6s ease;
}

.score-badge {
    min-width: 60px;
    text-align: center;
}

.progress-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.progress-wrapper {
    flex-grow: 1;
}

.attendance-status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.attendance-status-indicator.bg-success {
    background-color: #28a745;
}

.attendance-status-indicator.bg-warning {
    background-color: #ffc107;
}

.attendance-status-indicator.bg-danger {
    background-color: #dc3545;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Siswa</h1>
        <div class="d-flex gap-1">
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
            <a href="{{ route('students.edit', $student) }}" class="btn btn-warning" title="Edit Siswa">
                <i class="fas fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('students.index') }}" class="btn btn-secondary" title="Kembali">
                <i class="fas fa-arrow-left"></i> Kembali
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
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Siswa</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <span class="d-inline-block bg-light rounded-circle mb-2" style="width:100px; height:100px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-user-graduate fa-3x text-primary"></i>
                        </span>
                        <h5 class="mt-3">{{ $student->name }}</h5>
                        <span class="badge badge-success">Siswa</span>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Email:</div>
                        <div class="col-7">{{ $student->email }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Program:</div>
                        <div class="col-7">{{ $student->program ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Kelas/Grade:</div>
                        <div class="col-7">{{ $student->grade ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Alamat:</div>
                        <div class="col-7">{{ $student->address ?? '-' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Terdaftar Pada:</div>
                        <div class="col-7">{{ $student->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8 col-lg-7">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Terkait</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="m-0 font-weight-bold">Orang Tua</h6>
                                        </div>
                                        <div class="card-body">
                                            @if($student->parent)
                                                <div class="mb-2">
                                                    <strong>Nama:</strong> {{ $student->parent->name }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Email:</strong> {{ $student->parent->email }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Telepon:</strong> {{ $student->parent->phone ?? '-' }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Jumlah Anak:</strong> {{ $student->parent->children->count() }}
                                                </div>
                                                <a href="{{ route('parents.show', $student->parent) }}" class="btn btn-sm btn-info" title="Lihat Detail Orang Tua">
                                                    <i class="fas fa-eye"></i> Lihat Detail
                                                </a>
                                            @else
                                                <p class="text-muted">Belum ada orang tua terdaftar untuk siswa ini.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="m-0 font-weight-bold">Guru</h6>
                                        </div>
                                        <div class="card-body">
                                            @if($student->teacher)
                                                <div class="mb-2">
                                                    <strong>Nama:</strong> {{ $student->teacher->name }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Email:</strong> {{ $student->teacher->email }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Telepon:</strong> {{ $student->teacher->phone ?? '-' }}
                                                </div>
                                                <a href="{{ route('teachers.show', $student->teacher) }}" class="btn btn-sm btn-info" title="Lihat Detail Guru">
                                                    <i class="fas fa-eye"></i> Lihat Detail
                                                </a>
                                            @else
                                                <p class="text-muted">Belum ada guru terdaftar untuk siswa ini.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Perkembangan</h6>
                    @if(auth()->user()->role === 'teacher')
                    <div>
                        <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-success" title="Tambah Laporan">
                            <i class="fas fa-plus"></i> Tambah Laporan
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if(count($student->progresses ?? []) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Materi</th>
                                    <th>Skor</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->progresses as $progress)
                                <tr>
                                    <td>{{ $progress->date->format('d M Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($progress->material_covered, 50) }}</td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress-wrapper">
                                                <div class="progress progress-bar-custom">
                                                    <div class="progress-bar bg-{{ $progress->score >= 80 ? 'success' : ($progress->score >= 60 ? 'warning' : 'danger') }}" 
                                                         role="progressbar" 
                                                         data-width="{{ $progress->score }}"
                                                         aria-valuenow="{{ $progress->score }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge score-badge bg-{{ $progress->score >= 80 ? 'success' : ($progress->score >= 60 ? 'warning' : 'danger') }}">
                                                {{ $progress->score }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $progress->score >= 80 ? 'success' : ($progress->score >= 60 ? 'warning' : 'danger') }}">
                                            {{ $progress->score >= 80 ? 'Baik' : ($progress->score >= 60 ? 'Cukup' : 'Perlu Perhatian') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('progress.show', $progress) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-3">
                        <p class="mb-0">Belum ada laporan perkembangan untuk siswa ini.</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Presensi Kehadiran</h6>
                    @if(auth()->user()->role === 'teacher')
                    <div>
                        <a href="{{ route('attendance.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-success" title="Tambah Presensi">
                            <i class="fas fa-plus"></i> Tambah Presensi
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if(count($student->attendances ?? []) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                    <th>Materi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="attendance-status-indicator me-2 bg-{{ $attendance->status == 'present' ? 'success' : ($attendance->status == 'late' ? 'warning' : 'danger') }}"></div>
                                            <span class="badge bg-{{ $attendance->status == 'present' ? 'success' : ($attendance->status == 'late' ? 'warning' : 'danger') }}">
                                                {{ $attendance->status == 'present' ? 'Hadir' : ($attendance->status == 'late' ? 'Terlambat' : 'Tidak Hadir') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-muted me-2"></i>
                                            {{ $attendance->start_time }} - {{ $attendance->end_time }}
                                        </div>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($attendance->material, 30) }}</td>
                                    <td>
                                        <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-3">
                        <p class="mb-0">Belum ada data presensi untuk siswa ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set progress bar widths
    const progressBars = document.querySelectorAll('.progress-bar[data-width]');
    progressBars.forEach(bar => {
        const width = bar.getAttribute('data-width');
        bar.style.width = width + '%';
    });
});
</script>
@endsection
@endsection 