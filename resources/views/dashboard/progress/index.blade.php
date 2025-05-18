@extends('layouts.dashboard')

@section('title', 'Perkembangan Siswa - Sistem Informasi Bimbel Alfarizqi')

@section('styles')
<style>
.info-item {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
}

.info-item h6 {
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--dark);
}

.info-item p {
    margin-bottom: 0;
    color: #666;
}

.chart-container {
    position: relative;
    height: 60vh;
    min-height: 300px;
    max-height: 600px;
    width: 100%;
    margin: 1rem 0;
}

.chart-container canvas {
    width: 100% !important;
    height: 100% !important;
}

.chart-summary {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}
</style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Perkembangan Anak Didik</h2>
                        <p class="card-text">Pantau perkembangan belajar dan capaian anak didik.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Siswa</h5>
                        <h2 class="mb-0">{{ number_format($stats['total_students']) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pertemuan</h5>
                        <h2 class="mb-0">{{ number_format($stats['total_meetings']) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Laporan</h5>
                        <h2 class="mb-0">{{ number_format($stats['total_reports']) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        
        @if(auth()->user()->role === 'parent')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Pilih Anak</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($children as $child)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 {{ request()->get('student_id') == $child->id ? 'border-primary' : '' }}">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                @if($child->role === 'admin')
                                                    <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
                                                @elseif($child->role === 'teacher')
                                                    <i class="fas fa-chalkboard-teacher fa-4x text-success mb-3"></i>
                                                @elseif($child->role === 'parent')
                                                    <i class="fas fa-user-friends fa-4x text-info mb-3"></i>
                                                @else
                                                    <i class="fas fa-user-graduate fa-4x text-secondary mb-3"></i>
                                                @endif
                                            </div>
                                            <h5>{{ $child->name }}</h5>
                                            <p class="text-muted">{{ $child->grade }}</p>
                                            <a href="{{ route('progress.detail', ['student_id' => $child->id]) }}" class="btn btn-sm btn-{{ request()->get('student_id') == $child->id ? 'primary' : 'outline-primary' }} w-100">
                                                Lihat Perkembangan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(request()->has('student_id') && $student)
                <div class="row mb-4">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Informasi Anak</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    @if($student->role === 'admin')
                                        <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
                                    @elseif($student->role === 'teacher')
                                        <i class="fas fa-chalkboard-teacher fa-4x text-success mb-3"></i>
                                    @elseif($student->role === 'parent')
                                        <i class="fas fa-user-friends fa-4x text-info mb-3"></i>
                                    @else
                                        <i class="fas fa-user-graduate fa-4x text-secondary mb-3"></i>
                                    @endif
                                    <h4>{{ $student->name }}</h4>
                                    <p class="text-muted mb-0">{{ $student->grade }}</p>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <h6><i class="fa fa-book me-2 text-primary"></i>Program</h6>
                                    <p class="mb-0">{{ $student->program ?? 'Belum diatur' }}</p>
                                </div>
                                
                                <div class="info-item">
                                    <h6><i class="fa fa-chalkboard-teacher me-2 text-primary"></i>Guru</h6>
                                    <p class="mb-0">{{ $student->teacher ? $student->teacher->name : 'Belum diatur' }}</p>
                                </div>
                                
                                <div class="info-item">
                                    <h6><i class="fa fa-calendar-check me-2 text-primary"></i>Total Pertemuan</h6>
                                    <p class="mb-0">{{ $totalMeetings }} Pertemuan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Kurva Perkembangan</h5>
                                @if(auth()->user()->role !== 'parent')
                                    <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus-circle me-2"></i>Tambah Laporan
                                    </a>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($chartData && count($progressRecords) > 0)
                                    <div class="chart-container">
                                        <canvas id="progressDetailChart"></canvas>
                                    </div>
                                    <script id="progress-data" type="application/json">
                                        {!! json_encode($chartData) !!}
                                    </script>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fa fa-chart-line fa-4x text-muted"></i>
                                        </div>
                                        <h5>Belum Ada Data Perkembangan</h5>
                                        <p class="text-muted">Data perkembangan akan ditampilkan setelah ada laporan perkembangan.</p>
                                        @if(auth()->user()->role !== 'parent')
                                            <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-primary mt-3">
                                                <i class="fa fa-plus-circle me-2"></i>Tambah Laporan Perkembangan
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Riwayat Perkembangan</h5>
                                <div class="d-flex">
                                    <select class="form-select me-2" id="filterMonth" onchange="updateProgressRecords()">
                                        <option value="">Semua Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request()->get('month') == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select class="form-select" id="filterYear" onchange="updateProgressRecords()">
                                        <option value="">Semua Tahun</option>
                                        @for($year = 2026; $year >= 2023; $year--)
                                            <option value="{{ $year }}" {{ request()->get('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($progressRecords) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Materi</th>
                                                    <th>Capaian</th>
                                                    <th>Nilai</th>
                                                    <th>Status Verifikasi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($progressRecords as $record)
                                                <tr>
                                                    <td>{{ $record->date->format('d/m/Y') }}</td>
                                                    <td>{{ $record->material_covered }}</td>
                                                    <td>{{ $record->achievements }}</td>
                                                    <td>
                                                        @php
                                                            $scoreClass = 'bg-' . App\Helpers\ProgressHelper::getScoreColor($record->score);
                                                        @endphp
                                                        <span class="badge rounded-pill {{ $scoreClass }}">
                                                            {{ $record->score }}%
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($record->is_verified)
                                                            <span class="badge bg-{{ $record->verification_status === 'approved' ? 'success' : 'danger' }}">
                                                                {{ $record->verification_status === 'approved' ? 'Terverifikasi' : 'Ditolak' }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            @if(auth()->user()->role === 'parent')
                                                                <a href="{{ route('progress.show', $record->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('progress.show', $record->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('progress.edit', $record->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('progress.destroy', $record->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')" title="Hapus">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fa fa-file-alt fa-4x text-muted"></i>
                                        </div>
                                        <h5>Belum Ada Laporan</h5>
                                        <p class="text-muted">Laporan perkembangan akan ditampilkan setelah ada pertemuan dengan guru.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(!request()->has('student_id'))
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fa fa-user-graduate fa-4x text-muted"></i>
                            </div>
                            <h5>Pilih Anak untuk Melihat Perkembangan</h5>
                            <p class="text-muted">Silakan pilih salah satu anak didik untuk melihat laporan perkembangannya.</p>
                        </div>
                    </div>
                </div>
            @endif
        @elseif(auth()->user()->role === 'teacher')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Daftar Anak Didik</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Program</th>
                                            <th>Total Pertemuan</th>
                                            <th>Laporan Terakhir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->grade }}</td>
                                            <td>{{ $student->program }}</td>
                                            <td>{{ $student->meetings_count }}</td>
                                            <td>
                                                {{ $student->lastProgress ? $student->lastProgress->date->format('d/m/Y') : 'Belum ada' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('progress.detail', ['student_id' => $student->id]) }}" class="btn btn-sm btn-info" title="Lihat">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @if(auth()->user()->role === 'teacher')
                                                    <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-success" title="Tambah">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($students instanceof \Illuminate\Pagination\LengthAwarePaginator && $students->total() > 0)
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        Menampilkan {{ $students->firstItem() }}-{{ $students->lastItem() }} dari {{ $students->total() }} data
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            @if(request()->has('student_id') && $student)
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Informasi Anak</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    @if($student->role === 'admin')
                                        <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
                                    @elseif($student->role === 'teacher')
                                        <i class="fas fa-chalkboard-teacher fa-4x text-success mb-3"></i>
                                    @elseif($student->role === 'parent')
                                        <i class="fas fa-user-friends fa-4x text-info mb-3"></i>
                                    @else
                                        <i class="fas fa-user-graduate fa-4x text-secondary mb-3"></i>
                                    @endif
                                    <h4>{{ $student->name }}</h4>
                                    <p class="text-muted mb-0">{{ $student->grade }}</p>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <h6><i class="fa fa-book me-2 text-primary"></i>Program</h6>
                                    <p class="mb-0">{{ $student->program ?? 'Belum diatur' }}</p>
                                </div>
                                
                                <div class="info-item">
                                    <h6><i class="fa fa-calendar-check me-2 text-primary"></i>Total Pertemuan</h6>
                                    <p class="mb-0">{{ $totalMeetings }} Pertemuan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Kurva Perkembangan</h5>
                                @if(auth()->user()->role !== 'parent')
                                    <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus-circle me-2"></i>Tambah Laporan
                                    </a>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($chartData && count($progressRecords) > 0)
                                    <div class="chart-container">
                                        <canvas id="progressDetailChart"></canvas>
                                    </div>
                                    <script id="progress-data" type="application/json">
                                        {!! json_encode($chartData) !!}
                                    </script>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fa fa-chart-line fa-4x text-muted"></i>
                                        </div>
                                        <h5>Belum Ada Data Perkembangan</h5>
                                        <p class="text-muted">Data perkembangan akan ditampilkan setelah ada laporan perkembangan.</p>
                                        @if(auth()->user()->role !== 'parent')
                                            <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-primary mt-3">
                                                <i class="fa fa-plus-circle me-2"></i>Tambah Laporan Perkembangan
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Riwayat Perkembangan</h5>
                                <div class="d-flex">
                                    <select class="form-select me-2" id="filterMonth" onchange="updateProgressRecords()">
                                        <option value="">Semua Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request()->get('month') == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select class="form-select" id="filterYear" onchange="updateProgressRecords()">
                                        <option value="">Semua Tahun</option>
                                        @for($year = 2026; $year >= 2023; $year--)
                                            <option value="{{ $year }}" {{ request()->get('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($progressRecords) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Materi</th>
                                                    <th>Capaian</th>
                                                    <th>Nilai</th>
                                                    <th>Status Verifikasi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($progressRecords as $record)
                                                <tr>
                                                    <td>{{ $record->date->format('d/m/Y') }}</td>
                                                    <td>{{ $record->material_covered }}</td>
                                                    <td>{{ $record->achievements }}</td>
                                                    <td>
                                                        @php
                                                            $scoreClass = 'bg-' . App\Helpers\ProgressHelper::getScoreColor($record->score);
                                                        @endphp
                                                        <span class="badge rounded-pill {{ $scoreClass }}">
                                                            {{ $record->score }}%
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($record->is_verified)
                                                            <span class="badge bg-{{ $record->verification_status === 'approved' ? 'success' : 'danger' }}">
                                                                {{ $record->verification_status === 'approved' ? 'Terverifikasi' : 'Ditolak' }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            @if(auth()->user()->role === 'parent')
                                                                <a href="{{ route('progress.show', $record->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('progress.show', $record->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('progress.edit', $record->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('progress.destroy', $record->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')" title="Hapus">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fa fa-chart-line fa-4x text-muted"></i>
                                        </div>
                                        <h5>Belum Ada Data Perkembangan</h5>
                                        <p class="text-muted">Data perkembangan anak didik akan ditampilkan di sini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @elseif(auth()->user()->role === 'admin')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Daftar Anak Didik</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Program</th>
                                            <th>Guru</th>
                                            <th>Orang Tua</th>
                                            <th>Total Pertemuan</th>
                                            <th>Laporan Terakhir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <td>
                                                
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
                                            <td>{{ $student->grade }}</td>
                                            <td>{{ $student->program }}</td>
                                            <td>{{ $student->teacher ? $student->teacher->name : 'Belum ditentukan' }}</td>
                                            <td>{{ $student->parent ? $student->parent->name : 'Belum ditentukan' }}</td>
                                            <td>{{ $student->meetings_count }}</td>
                                            <td>
                                                {{ $student->lastProgress ? $student->lastProgress->date->format('d/m/Y') : 'Belum ada' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('progress.detail', ['student_id' => $student->id]) }}" class="btn btn-sm btn-info" title="Lihat Laporan">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(auth()->user()->role === 'teacher')
                                                    <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-success" title="Tambah Laporan">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($students instanceof \Illuminate\Pagination\LengthAwarePaginator && $students->total() > 0)
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        Menampilkan {{ $students->firstItem() }}-{{ $students->lastItem() }} dari {{ $students->total() }} data
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            @if(request()->has('student_id') && $student)
                <div class="row mb-4">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Informasi Anak</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    @if($student->role === 'admin')
                                        <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
                                    @elseif($student->role === 'teacher')
                                        <i class="fas fa-chalkboard-teacher fa-4x text-success mb-3"></i>
                                    @elseif($student->role === 'parent')
                                        <i class="fas fa-user-friends fa-4x text-info mb-3"></i>
                                    @else
                                        <i class="fas fa-user-graduate fa-4x text-secondary mb-3"></i>
                                    @endif
                                    <h4>{{ $student->name }}</h4>
                                    <p class="text-muted mb-0">{{ $student->grade }}</p>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <h6><i class="fa fa-book me-2 text-primary"></i>Program</h6>
                                    <p class="mb-0">{{ $student->program ?? 'Belum diatur' }}</p>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <h6><i class="fa fa-chalkboard-teacher me-2 text-primary"></i>Guru</h6>
                                    <p class="mb-0">{{ $student->teacher ? $student->teacher->name : 'Belum diatur' }}</p>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <h6><i class="fa fa-user me-2 text-primary"></i>Orang Tua</h6>
                                    <p class="mb-0">{{ $student->parent ? $student->parent->name : 'Belum diatur' }}</p>
                                </div>
                                
                                <div class="info-item">
                                    <h6><i class="fa fa-calendar-check me-2 text-primary"></i>Total Pertemuan</h6>
                                    <p class="mb-0">{{ $totalMeetings }} Pertemuan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Kurva Perkembangan</h5>
                                @if(auth()->user()->role !== 'parent')
                                    <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus-circle me-2"></i>Tambah Laporan
                                    </a>
                                @endif
                            </div>
                            <div class="card-body">
                                @if($chartData && count($progressRecords) > 0)
                                    <div class="chart-container">
                                        <canvas id="progressDetailChart"></canvas>
                                    </div>
                                    <script id="progress-data" type="application/json">
                                        {!! json_encode($chartData) !!}
                                    </script>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fa fa-chart-line fa-4x text-muted"></i>
                                        </div>
                                        <h5>Belum Ada Data Perkembangan</h5>
                                        <p class="text-muted">Data perkembangan akan ditampilkan setelah ada laporan perkembangan.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Riwayat Perkembangan</h5>
                                <div class="d-flex">
                                    <select class="form-select me-2" id="filterMonth" onchange="updateProgressRecords()">
                                        <option value="">Semua Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request()->get('month') == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select class="form-select" id="filterYear" onchange="updateProgressRecords()">
                                        <option value="">Semua Tahun</option>
                                        @for($year = 2026; $year >= 2023; $year--)
                                            <option value="{{ $year }}" {{ request()->get('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($progressRecords) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Materi</th>
                                                    <th>Capaian</th>
                                                    <th>Nilai</th>
                                                    <th>Guru</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($progressRecords as $record)
                                                <tr>
                                                    <td>{{ $record->date->format('d/m/Y') }}</td>
                                                    <td>{{ $record->material_covered }}</td>
                                                    <td>{{ $record->achievements }}</td>
                                                    <td>
                                                        @php
                                                            $scoreClass = 'bg-' . App\Helpers\ProgressHelper::getScoreColor($record->score);
                                                        @endphp
                                                        <span class="badge rounded-pill {{ $scoreClass }}">
                                                            {{ $record->score }}%
                                                        </span>
                                                    </td>
                                                    <td>{{ $record->teacher ? $record->teacher->name : 'Tidak ada' }}</td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            @if(auth()->user()->role === 'parent')
                                                                <a href="{{ route('progress.show', $record->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('progress.show', $record->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('progress.edit', $record->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('progress.destroy', $record->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')" title="Hapus">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fa fa-chart-line fa-4x text-muted"></i>
                                        </div>
                                        <h5>Belum Ada Data Perkembangan</h5>
                                        <p class="text-muted">Data perkembangan anak didik akan ditampilkan di sini.</p>
                                        <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-primary mt-3">
                                            <i class="fa fa-plus-circle"></i> Tambah Laporan Perkembangan
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/progress-charts.js') }}"></script>
<meta name="student-id" content="{{ request()->get('student_id') }}">
<meta name="progress-index-route" content="{{ route('progress.index') }}">
<script>
function updateProgressRecords() {
    const month = document.getElementById('filterMonth').value;
    const year = document.getElementById('filterYear').value;
    const studentId = "{{ request()->get('student_id') }}";
    const baseUrl = "{{ route('progress.index') }}";
    
    let url = `${baseUrl}?student_id=${studentId}`;
    if (month) url += `&month=${month}`;
    if (year) url += `&year=${year}`;
    
    window.location.href = url;
}
</script>
@endsection
 
 
 
 
 
 
