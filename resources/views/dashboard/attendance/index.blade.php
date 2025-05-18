@extends('layouts.dashboard')

@section('title', 'Presensi Siswa - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <div class="container-fluid py-4">
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

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">Presensi Siswa</h1>
                    <p class="text-muted">Laporan presensi belajar anak didik</p>
                </div>
                
                @if(auth()->user()->role === 'teacher')
                <div class="d-flex gap-1">
                    <a href="{{ route('attendance.create') }}" class="btn btn-success" title="Tambah Presensi Baru">
                        <i class="fa fa-plus"></i> Tambah Presensi
                    </a>
                </div>
                @endif
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
                                                <img src="{{ asset('img/default-avatar.png') }}" alt="{{ $child->name }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                            </div>
                                            <h5>{{ $child->name }}</h5>
                                            <p class="text-muted">{{ $child->grade }}</p>
                                            <a href="{{ route('attendance.index', ['student_id' => $child->id]) }}" class="btn btn-sm btn-{{ request()->get('student_id') == $child->id ? 'primary' : 'outline-primary' }} w-100">
                                                Lihat Presensi
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
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Informasi Anak</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('img/default-avatar.png') }}" alt="{{ $student->name }}" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                                    <h5>{{ $student->name }}</h5>
                                    <p class="text-muted">{{ $student->grade }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Guru:</strong> {{ $student->teacher ? $student->teacher->name : 'Belum diatur' }}</p>
                                    <p class="mb-1"><strong>Program:</strong> {{ $student->program ?? 'Belum diatur' }}</p>
                                    <p class="mb-1"><strong>Jadwal:</strong> {{ $student->schedule_day ?? 'Belum diatur' }}, {{ $student->schedule_time ?? 'Belum diatur' }}</p>
                                </div>
                                
                                <hr>
                                
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <h3 class="mb-0">{{ $attendanceStats['total'] }}</h3>
                                            <small class="text-muted">Total</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <h3 class="mb-0 text-success">{{ $attendanceStats['present'] }}</h3>
                                            <small class="text-muted">Hadir</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <h3 class="mb-0 text-danger">{{ $attendanceStats['absent'] }}</h3>
                                            <small class="text-muted">Absen</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Grafik Kehadiran</h5>
                                <div>
                                    <select class="form-select form-select-sm">
                                        <option>Bulan Ini</option>
                                        <option>3 Bulan Terakhir</option>
                                        <option>6 Bulan Terakhir</option>
                                        <option>Tahun Ini</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="attendanceChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Riwayat Presensi</h5>
                            </div>
                            <div class="card-body">
                                @if(count($attendanceRecords) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Jam</th>
                                                    <th>Status</th>
                                                    <th>Materi</th>
                                                    <th>Guru</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($attendanceRecords as $record)
                                                <tr>
                                                    <td>{{ $record->date->format('d M Y') }}</td>
                                                    <td>{{ $record->start_time }} - {{ $record->end_time }}</td>
                                                    <td>
                                                        @if($record->status == 'present')
                                                            <span class="badge bg-success">Hadir</span>
                                                        @elseif($record->status == 'absent')
                                                            <span class="badge bg-danger">Tidak Hadir</span>
                                                        @elseif($record->status == 'late')
                                                            <span class="badge bg-warning">Terlambat</span>
                                                        @else
                                                            <span class="badge bg-secondary">Tidak Diketahui</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $record->material ?? '-' }}</td>
                                                    <td>{{ $record->teacher->name }}</td>
                                                    <td>
                                                        @if($record->notes)
                                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#notesModal{{ $record->id }}">
                                                                <i class="fa fa-comment-dots"></i> Lihat
                                                            </button>
                                                            
                                                            <!-- Notes Modal -->
                                                            <div class="modal fade" id="notesModal{{ $record->id }}" tabindex="-1" aria-labelledby="notesModalLabel{{ $record->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="notesModalLabel{{ $record->id }}">Catatan Presensi</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="mb-0">{{ $record->notes }}</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="fa fa-calendar-check fa-4x text-muted"></i>
                                        </div>
                                        <h5>Belum Ada Data Presensi</h5>
                                        <p class="text-muted">Data presensi akan muncul setelah pertemuan dengan guru.</p>
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
                            <h5>Pilih Anak untuk Melihat Presensi</h5>
                            <p class="text-muted">Silakan pilih salah satu anak didik untuk melihat riwayat presensinya.</p>
                        </div>
                    </div>
                </div>
            @endif
        @elseif(auth()->user()->role === 'teacher' || auth()->user()->role === 'admin')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Riwayat Presensi</h5>
                        </div>
                        <div class="card-body">
                            @if(count($attendances) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Anak Didik</th>
                                                <th>Status</th>
                                                <th>Materi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($attendances as $attendance)
                                            <tr>
                                                <td>{{ $attendance->date->format('d M Y') }}</td>
                                                <td>{{ $attendance->start_time ?? '-' }} - {{ $attendance->end_time ?? '-' }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $attendance->student->name }}</h6>
                                                            <small class="text-muted">{{ $attendance->student->grade }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($attendance->status == 'present')
                                                        <span class="badge bg-success">Hadir</span>
                                                    @elseif($attendance->status == 'absent')
                                                        <span class="badge bg-danger">Tidak Hadir</span>
                                                    @elseif($attendance->status == 'late')
                                                        <span class="badge bg-warning">Terlambat</span>
                                                    @endif
                                                </td>
                                                <td>{{ $attendance->material ?? '-' }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if(auth()->user()->role === 'teacher')
                                                        <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus presensi ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data presensi.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            Menampilkan {{ $attendances->firstItem() ?? 0 }}-{{ $attendances->lastItem() ?? 0 }} dari {{ $attendances->total() ?? 0 }} data
                                        </small>
                                    </div>
                                    <div>
                                        {{ $attendances->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fa fa-calendar-check fa-4x text-muted"></i>
                                    </div>
                                    <h5>Belum Ada Data Presensi</h5>
                                    <p class="text-muted">Anda belum membuat catatan presensi untuk anak didik.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->role === 'admin')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Siswa</h5>
                            <div>
                                <input type="text" class="form-control" id="searchStudentAdmin" placeholder="Cari siswa...">
                            </div>
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
                                            <th>Total Presensi</th>
                                            <th>Terakhir Hadir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->grade }}</td>
                                            <td>{{ $student->program }}</td>
                                            <td>{{ $student->teacher ? $student->teacher->name : 'Belum ditentukan' }}</td>
                                            <td>{{ $student->attendances_count ?? 0 }}</td>
                                            <td>
                                                @if(isset($student->lastAttendance) && $student->lastAttendance)
                                                    {{ $student->lastAttendance->date->format('d/m/Y') }}
                                                @else
                                                    Belum pernah hadir
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('attendance.index', ['student_id' => $student->id]) }}" class="btn btn-sm btn-info" title="Lihat Presensi">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('attendance.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-success" title="Tambah Presensi">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Simpan data chart dalam elemen tersembunyi -->
@if(request()->has('student_id') && $student)
<div id="chart-data" 
     data-labels="{{ isset($chartData) ? json_encode($chartData['labels']) : '[]' }}"
     data-values="{{ isset($chartData) ? json_encode($chartData['data']) : '[]' }}"
     style="display: none;">
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Setup chart if data exists
    var chartDataElement = document.getElementById('chart-data');
    if (chartDataElement) {
        // Parse data from data attributes
        var chartLabels = JSON.parse(chartDataElement.dataset.labels);
        var chartData = JSON.parse(chartDataElement.dataset.values);
        
        // Initialize chart
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Kehadiran',
                    data: chartData,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value === 1 ? 'Hadir' : 'Tidak Hadir';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw === 1 ? 'Hadir' : 'Tidak Hadir';
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
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
    min-width: 32px;
    height: 32px;
}

.d-flex.gap-2 .btn-info {
    background-color: #0dcaf0;
    border-color: #0dcaf0;
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
 
 