@extends('layouts.dashboard')

@section('title', 'Detail Presensi - Sistem Informasi Bimbel Alfarizqi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Presensi</h5>
                    <a href="{{ route('parent.attendance.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header bg-white">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Presensi</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th width="200">Tanggal</th>
                                            <td>{{ $attendance->date->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Waktu</th>
                                            <td>
                                                {{ $attendance->start_time ? $attendance->start_time->format('H:i') : '-' }} - 
                                                {{ $attendance->end_time ? $attendance->end_time->format('H:i') : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }}">
                                                    {{ $attendance->status === 'present' ? 'Hadir' : ($attendance->status === 'late' ? 'Terlambat' : 'Tidak Hadir') }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Materi</th>
                                            <td>{{ $attendance->material ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Catatan</th>
                                            <td>{{ $attendance->notes ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header bg-white">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Siswa & Guru</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th width="200">Nama Siswa</th>
                                            <td>{{ $attendance->student->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Program</th>
                                            <td>{{ optional($attendance->student->program)->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Guru</th>
                                            <td>{{ $attendance->teacher->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Telepon Guru</th>
                                            <td>{{ $attendance->teacher->phone ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 