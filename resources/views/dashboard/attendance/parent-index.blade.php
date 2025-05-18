@extends('layouts.dashboard')

@section('title', 'Presensi Anak - Sistem Informasi Bimbel Alfarizqi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Presensi Anak</h5>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pertemuan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_meetings'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Hadir</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['present_count'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Terlambat</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['late_count'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Tidak Hadir</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['absent_count'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Chart -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header bg-white">
                                    <h6 class="m-0 font-weight-bold text-primary">Statistik Kehadiran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="attendanceChart" 
                                                data-labels="{{ json_encode($chartData['labels']) }}"
                                                data-values="{{ json_encode($chartData['data']) }}">
                                        </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-white">
                            <h6 class="m-0 font-weight-bold text-primary">Riwayat Presensi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Anak</th>
                                            <th>Jam</th>
                                            <th>Status</th>
                                            <th>Guru</th>
                                            <th>Materi</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->date->format('d/m/Y') }}</td>
                                            <td>{{ $attendance->student->name }}</td>
                                            <td>
                                                {{ $attendance->start_time ? $attendance->start_time->format('H:i') : '-' }} - 
                                                {{ $attendance->end_time ? $attendance->end_time->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }}">
                                                    {{ $attendance->status === 'present' ? 'Hadir' : ($attendance->status === 'late' ? 'Terlambat' : 'Tidak Hadir') }}
                                                </span>
                                            </td>
                                            <td>{{ $attendance->teacher->name }}</td>
                                            <td>{{ $attendance->material ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('parent.attendance.show', $attendance->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                                    <p class="mb-0">Belum ada data presensi</p>
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
                                        Menampilkan {{ $attendances->firstItem() ?? 0 }}-{{ $attendances->lastItem() ?? 0 }} dari {{ $attendances->total() ?? 0 }} data
                                    </small>
                                </div>
                                <div>
                                    @if ($attendances->onFirstPage())
                                        <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                                    @else
                                        <a href="{{ $attendances->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                                    @endif

                                    @if ($attendances->hasMorePages())
                                        <a href="{{ $attendances->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
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
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get chart data from canvas element
    var canvas = document.getElementById('attendanceChart');
    var labels = JSON.parse(canvas.dataset.labels);
    var data = JSON.parse(canvas.dataset.values);
    
    // Initialize attendance chart
    var ctx = canvas.getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',  // Success
                    'rgba(220, 53, 69, 0.8)',  // Danger
                    'rgba(255, 193, 7, 0.8)'   // Warning
                ],
                borderColor: [
                    'rgb(40, 167, 69)',
                    'rgb(220, 53, 69)',
                    'rgb(255, 193, 7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@push('styles')
<style>
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
@endsection 