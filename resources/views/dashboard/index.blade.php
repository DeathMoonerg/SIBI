@extends('layouts.dashboard')

@section('title', 'Dashboard - Sistem Informasi Bimbel Alfarizqi')

@section('content')
    <!-- Additional CSS for improved responsiveness -->
    <style>
        /* General responsive improvements */
        .dashboard-card {
            height: 100%;
            transition: all 0.3s ease;
        }
        
        /* Improved card spacing on mobile */
        @media (max-width: 767.98px) {
            .card-title {
                font-size: 1.5rem;
            }
            .dashboard-icon {
                min-width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
            .btn-sm {
                padding: 0.25rem 0.5rem;
            }
            /* Better table display on very small screens */
            .table-mobile-stack {
                display: block;
                width: 100%;
            }
            .table-mobile-stack thead {
                display: none;
            }
            .table-mobile-stack tbody {
                display: block;
                width: 100%;
            }
            .table-mobile-stack tr {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
                border: 1px solid rgba(0,0,0,.125);
                border-radius: .25rem;
            }
            .table-mobile-stack td {
                display: flex;
                justify-content: space-between;
                width: 100%;
                text-align: right;
                border-bottom: 1px solid rgba(0,0,0,.125);
                padding: 0.75rem;
            }
            .table-mobile-stack td:before {
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
                margin-right: auto;
            }
            .table-mobile-stack td:last-child {
                border-bottom: none;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Selamat Datang, {{ auth()->user()->name }}</h2>
                        <p class="card-text">{{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'parent')
        <!-- Dashboard Orang Tua - Improved Responsiveness -->
        <div class="row">
            <!-- Summary Card - Full width on small devices -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ringkasan</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="dashboard-icon bg-primary text-white">
                                <i class="fa fa-calendar-check"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Total Pertemuan</h6>
                                <h4 class="mb-0">{{ $totalMeetings ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="dashboard-icon bg-success text-white">
                                <i class="fa fa-book"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Program</h6>
                                <h4 class="mb-0">{{ $children->count() }}</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dashboard-icon bg-info text-white">
                                <i class="fa fa-chart-line"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Laporan</h6>
                                <h4 class="mb-0">{{ count($reports ?? []) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Chart - Full width on small devices -->
            <div class="col-12 col-md-6 col-lg-8 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Kurva Perkembangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="progressChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Reports - Full width on all devices -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0 me-2">Laporan Terbaru</h5>
                        <a href="{{ route('progress.index') }}" class="btn btn-sm btn btn-success mt-2 mt-sm-0">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if(count($latestReports ?? []) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-mobile-stack">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Anak</th>
                                            <th>Program</th>
                                            <th>Nilai</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($latestReports ?? [] as $report)
                                        <tr>
                                            <td data-label="Tanggal">{{ \Carbon\Carbon::parse($report->date)->format('d/m/Y') }}</td>
                                            <td data-label="Anak">{{ $report->student->name }}</td>
                                            <td data-label="Program">{{ $report->student->program }}</td>
                                            <td data-label="Nilai">
                                                <span class="badge bg-{{ $report->score >= 80 ? 'success' : ($report->score >= 60 ? 'warning' : 'danger') }}">
                                                    {{ $report->score }}
                                                </span>
                                            </td>
                                            <td data-label="Status">
                                                <span class="badge bg-{{ $report->score >= 80 ? 'success' : ($report->score >= 60 ? 'warning' : 'danger') }}">
                                                    {{ $report->score >= 80 ? 'Baik' : ($report->score >= 60 ? 'Cukup' : 'Perlu Perhatian') }}
                                                </span>
                                            </td>
                                            <td data-label="Aksi">
                                                <a href="{{ route('progress.show', $report->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
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
                                <p class="text-muted">Laporan perkembangan anak akan ditampilkan di sini.</p>
                            </div>
                        @endif

                        <!-- Pagination Controls for Latest Reports -->
                        @if(count($latestReports ?? []) > 0)
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $latestReports->firstItem() ?? 0 }}-{{ $latestReports->lastItem() ?? 0 }} dari {{ $latestReports->total() ?? 0 }} data
                                </small>
                            </div>
                            <div>
                                @if ($latestReports->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                                @else
                                    <a href="{{ $latestReports->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                                @endif

                                @if ($latestReports->hasMorePages())
                                    <a href="{{ $latestReports->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
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

        <!-- Parent-specific responsive script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize progress chart
                const progressChart = document.getElementById('progressChart');
                if (progressChart) {
                    const ctx = progressChart.getContext('2d');
                    const progressData = JSON.parse('{!! json_encode($reports ?? []) !!}');
                    
                    const labels = progressData.map(function(report) {
                        return new Date(report.date).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short'
                        });
                    }).reverse();
                    
                    const scores = progressData.map(function(report) {
                        return report.score;
                    }).reverse();
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Nilai',
                                data: scores,
                                borderColor: 'rgb(75, 192, 192)',
                                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: 'rgb(75, 192, 192)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 12
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    padding: 10,
                                    titleFont: {
                                        size: 14
                                    },
                                    bodyFont: {
                                        size: 13
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
        @elseif(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        <!-- Dashboard Admin/Guru - Combined Chart Section -->
        <div class="row">
            <!-- Combined Chart -->
            <div class="col-12 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Statistik {{ auth()->user()->role === 'admin' ? 'Admin' : 'Guru' }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:400px; width:100%">
                            <canvas id="combinedChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            @if(auth()->user()->role === 'admin')
            <!-- Admin Statistics Cards -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Siswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                    Total Guru</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTeachers ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Pertemuan Bulan Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyMeetings ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
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
                                    Siswa Baru Bulan Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newStudentsThisMonth ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Teacher Statistics Cards -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Siswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                    Total Pertemuan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMeetings ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Laporan Perkembangan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $progressReportsCount ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
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
                                    Siswa Baru Bulan Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newStudentsThisMonth ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Recent Students Table -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Siswa Terbaru</h6>
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Program</th>
                                        <th>Orang Tua</th>
                                        <th>Tanggal Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentStudents as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->program }}</td>
                                        <td>{{ $student->parent ? $student->parent->name : '-' }}</td>
                                        <td>{{ $student->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($recentStudents instanceof \Illuminate\Pagination\LengthAwarePaginator && $recentStudents->total() > 0)
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $recentStudents->firstItem() }}-{{ $recentStudents->lastItem() }} dari {{ $recentStudents->total() }} data
                                </small>
                            </div>
                            <div>
                                @if ($recentStudents->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                                @else
                                    <a href="{{ $recentStudents->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                                @endif

                                @if ($recentStudents->hasMorePages())
                                    <a href="{{ $recentStudents->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled>Next</button>
                                @endif
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<meta name="user-role" content="{{ auth()->user()->role }}">
<meta name="admin-dashboard-route" content="{{ route('chart.admin-dashboard') }}">
<meta name="parent-stats-route" content="{{ route('chart.parent-stats') }}">
<script src="{{ asset('js/dashboard-charts.js') }}"></script>

<!-- Enhanced responsive behavior script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configure Chart.js for better responsiveness
        if (typeof Chart !== 'undefined') {
            Chart.defaults.maintainAspectRatio = false;
            Chart.defaults.responsive = true;
            
            // Handle resize events better
            const resizeCharts = function() {
                if (window.dashboardCharts) {
                    for (const chartName in window.dashboardCharts) {
                        if (window.dashboardCharts[chartName]) {
                            window.dashboardCharts[chartName].resize();
                        }
                    }
                }
            };
            
            window.addEventListener('resize', function() {
                resizeCharts();
            });
        }
        
        // Mobile-friendly tables
        if (window.innerWidth < 768) {
            const tables = document.querySelectorAll('.table-mobile-stack');
            tables.forEach(function(table) {
                // Optional: Add click handlers or other mobile-specific behavior
                table.querySelectorAll('tr').forEach(function(row) {
                    row.addEventListener('click', function(e) {
                        // Prevent clicking on action buttons from triggering row action
                        if (e.target.tagName !== 'BUTTON' && !e.target.closest('a') && !e.target.closest('button')) {
                            // Optional: add mobile row selection behavior here
                        }
                    });
                });
            });
        }
    });
</script>
@endsection 
 
 