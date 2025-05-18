@extends('layouts.dashboard')

@section('title', 'Detail Presensi - Sistem Informasi Bimbel Alfarizqi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Detail Presensi</h5>
                        <p class="text-muted mb-0">Informasi lengkap presensi siswa</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        @if(auth()->user()->role === 'teacher')
                        <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                        <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus presensi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Siswa</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Nama Siswa</th>
                                    <td>{{ $attendance->student->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>{{ $attendance->student->grade }}</td>
                                </tr>
                                <tr>
                                    <th>Program</th>
                                    <td>{{ $attendance->student->program }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Presensi</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Tanggal</th>
                                    <td>{{ $attendance->date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu</th>
                                    <td>{{ $attendance->start_time ?? '-' }} - {{ $attendance->end_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($attendance->status == 'present')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($attendance->status == 'absent')
                                            <span class="badge bg-danger">Tidak Hadir</span>
                                        @elseif($attendance->status == 'late')
                                            <span class="badge bg-warning">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">Materi Pembelajaran</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $attendance->material ?? 'Tidak ada materi yang dicatat' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($attendance->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">Catatan</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $attendance->notes }}
                                </div>
                            </div>
                        </div>
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
.d-flex.gap-2 {
    display: flex;
    gap: 0.5rem;
}

.d-flex.gap-2 .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.d-flex.gap-2 .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.d-flex.gap-2 .btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #212529;
}

.d-flex.gap-2 .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.d-flex.gap-2 .btn:hover {
    opacity: 0.9;
}

.d-flex.gap-2 .btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.d-flex.gap-2 .btn i {
    font-size: 0.875rem;
}
</style>
@endpush
 
 