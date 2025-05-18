@extends('layouts.dashboard')

@section('title', 'Detail Laporan Perkembangan - Sistem Informasi Bimbel Alfarizqi')

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
    height: 500px; /* chart benar-benar tinggi */
    min-height: unset;
    max-height: none;
    width: 100%;
    margin: 2rem auto;
    background: white;
    border-radius: 12px;
    padding: 20px 30px 30px 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.chart-container canvas {
    width: 100% !important;
    height: 100% !important;
    margin: 0;
    display: block;
}

.chart-summary {
    margin-top: 30px;
    padding: 0 0 10px 0;
    background: none;
    border-radius: 12px;
    box-shadow: none;
}

.chart-summary .row {
    margin-left: 0;
    margin-right: 0;
}

.chart-summary h6 {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.chart-summary h4 {
    color: #2c3e50;
    font-weight: bold;
    margin: 0;
    font-size: 1.5rem;
}

.avatar-circle {
    width: 40px;
    height: 4   0px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
}

.card-body {
    padding: 1.5rem;
}

.col-md-8 {
    margin-bottom: 2rem;
}

.bg-summary-1 {
    background: linear-gradient(135deg, #36d1c4 0%, #00b09b 100%);
}
.bg-summary-2 {
    background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
}
.bg-summary-3 {
    background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%);
}
.bg-summary-4 {
    background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
}
.text-summary-1, .text-summary-2, .text-summary-3, .text-summary-4 {
    color: #fff !important;
}
.summary-card {
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.10);
    padding: 30px 18px 22px 18px;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
    min-height: 150px;
    border: 2px solid rgba(255,255,255,0.18);
    cursor: pointer;
}
.summary-card:hover {
    transform: translateY(-4px) scale(1.04);
    box-shadow: 0 8px 32px rgba(0,0,0,0.16);
    border-color: #fff;
}
.summary-icon {
    font-size: 2.3rem;
    margin-bottom: 10px;
    opacity: 0.90;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.10));
}
.summary-label {
    font-size: 1.08rem;
    font-weight: 500;
    margin-bottom: 7px;
    letter-spacing: 0.5px;
    opacity: 0.97;
}
.summary-value {
    font-size: 2.2rem;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 0;
    line-height: 1.1;
    opacity: 0.99;
    text-shadow: 0 2px 8px rgba(0,0,0,0.10);
    transition: color 0.2s;
}
</style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0">Detail Laporan Perkembangan</h2>
                                <p class="card-text text-muted">Informasi lengkap tentang perkembangan anak didik.</p>
                            </div>
                            <a href="{{ route('progress.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Informasi Anak</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="avatar-circle bg-primary text-white mx-auto mb-3">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <h4>{{ $student->name }}</h4>
                            <p class="text-muted mb-0">{{ $student->grade }}</p>
                        </div>
                        
                        <div class="info-item mb-3 text-center">
                            @if($student->role === 'admin')
                                <i class="fas fa-user-shield fa-3x text-primary mb-2"></i>
                                <div class="fw-bold mt-2">Admin</div>
                            @elseif($student->role === 'teacher')
                                <i class="fas fa-chalkboard-teacher fa-3x text-success mb-2"></i>
                                <div class="fw-bold mt-2">Guru</div>
                            @elseif($student->role === 'parent')
                                <i class="fas fa-user-friends fa-3x text-info mb-2"></i>
                                <div class="fw-bold mt-2">Orang Tua</div>
                            @else
                                <i class="fas fa-user-graduate fa-3x text-secondary mb-2"></i>
                                <div class="fw-bold mt-2">Siswa</div>
                            @endif
                        </div>
                        
                        <div class="info-item mb-3">
                            <h6><i class="fa fa-book me-2 text-primary"></i>Program</h6>
                            <p class="mb-0">{{ $student->program ?? 'Belum diatur' }}</p>
                        </div>
                        
                        <div class="info-item mb-3">
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
                            <a href="{{ route('progress.create', ['student_id' => $student->id]) }}" class="btn btn-success">
                                <i class="fa fa-plus-circle me-2"></i>Tambah Laporan
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($chartData && count($progressRecords) > 0)
                            <div class="chart-container">
                                <canvas id="progressDetailChart"></canvas>
                            </div>
                            @php
                            $summary = [
                                [
                                    'label' => 'Nilai Rata-rata',
                                    'value' => $chartData['averageScore'] ?? 0,
                                    'icon' => 'fa-chart-line',
                                    'bgClass' => 'bg-summary-1',
                                    'textClass' => 'text-summary-1',
                                    'suffix' => '%'
                                ],
                                [
                                    'label' => 'Nilai Tertinggi',
                                    'value' => $chartData['highestScore'] ?? 0,
                                    'icon' => 'fa-arrow-up',
                                    'bgClass' => 'bg-summary-2',
                                    'textClass' => 'text-summary-2',
                                    'suffix' => '%'
                                ],
                                [
                                    'label' => 'Nilai Terendah',
                                    'value' => $chartData['lowestScore'] ?? 0,
                                    'icon' => 'fa-arrow-down',
                                    'bgClass' => 'bg-summary-3',
                                    'textClass' => 'text-summary-3',
                                    'suffix' => '%'
                                ],
                                [
                                    'label' => 'Total Pertemuan',
                                    'value' => $chartData['totalMeetings'] ?? 0,
                                    'icon' => 'fa-users',
                                    'bgClass' => 'bg-summary-4',
                                    'textClass' => 'text-summary-4',
                                    'suffix' => ''
                                ],
                            ];
                            @endphp

                            <div class="chart-summary">
                                <div class="row g-3">
                                    @foreach($summary as $i => $item)
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="summary-card {{ $item['bgClass'] }} {{ $item['textClass'] }}">
                                            <div class="summary-icon mb-2">
                                                <i class="fa {{ $item['icon'] }}"></i>
                                            </div>
                                            <div class="summary-label">{{ $item['label'] }}</div>
                                            <div class="summary-value" id="summary-value-{{ $i }}" data-value="{{ $item['value'] }}" data-suffix="{{ $item['suffix'] }}">0{{ $item['suffix'] }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
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
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        Menampilkan {{ $progressRecords->firstItem() }}-{{ $progressRecords->lastItem() }} dari {{ $progressRecords->total() }} data
                                    </small>
                                </div>
                                <div>
                                    @if ($progressRecords->onFirstPage())
                                        <button class="btn btn-sm btn-outline-secondary" disabled>Previous</button>
                                    @else
                                        <a href="{{ $progressRecords->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">Previous</a>
                                    @endif

                                    @if ($progressRecords->hasMorePages())
                                        <a href="{{ $progressRecords->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">Next</a>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled>Next</button>
                                    @endif
                                </div>
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
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<div id="chart-data" data-chart='{!! $chartData ? json_encode($chartData) : '{}' !!}' style="display: none;"></div>
<script type="text/javascript">
window.onload = function() {
    var chartDataElement = document.getElementById('chart-data');
    var chartData = JSON.parse(chartDataElement.getAttribute('data-chart'));
    var ctx = document.getElementById('progressDetailChart');
    
    if (ctx && chartData.labels && chartData.labels.length > 0) {
        var average = chartData.scores.reduce((a, b) => a + b, 0) / chartData.scores.length;
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Nilai Perkembangan',
                        data: chartData.scores,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(75, 192, 192)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointStyle: 'circle',
                        borderWidth: 3
                    },
                    {
                        label: 'Rata-rata',
                        data: Array(chartData.labels.length).fill(average),
                        borderColor: 'rgba(255, 99, 132, 0.8)',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        pointRadius: 0,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                layout: {
                    padding: {
                        top: 20,
                        right: 25,
                        bottom: 20,
                        left: 25
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            padding: 10,
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Nilai (%)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: {
                                bottom: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            padding: 10,
                            maxRotation: 45,
                            minRotation: 45
                        },
                        title: {
                            display: true,
                            text: 'Tanggal Pertemuan',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 13,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#000',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyColor: '#666',
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return 'Nilai: ' + context.raw + '%';
                                } else {
                                    return 'Rata-rata: ' + context.raw.toFixed(1) + '%';
                                }
                            },
                            title: function(context) {
                                return 'Tanggal: ' + context[0].label;
                            }
                        }
                    },
                    datalabels: {
                        display: function(context) {
                            return context.datasetIndex === 0;
                        },
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        offset: 5,
                        font: {
                            weight: 'bold',
                            size: 11
                        },
                        formatter: function(value) {
                            return value + '%';
                        },
                        backgroundColor: 'rgba(255, 255, 255, 0.8)',
                        borderRadius: 4,
                        padding: 4
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            },
            plugins: [ChartDataLabels]
        });
    }
    // Animate summary values
    var summaryEls = document.querySelectorAll('.summary-value');
    summaryEls.forEach(function(el) {
        var end = parseFloat(el.getAttribute('data-value'));
        var suffix = el.getAttribute('data-suffix') || '';
        var start = 0;
        var duration = 1200;
        var startTime = null;
        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var value = Math.floor(progress * (end - start) + start);
            if (suffix === '%') {
                el.textContent = value + '%';
            } else {
                el.textContent = value;
            }
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                if (suffix === '%') {
                    el.textContent = end.toFixed(1).replace('.0','') + '%';
                } else {
                    el.textContent = end;
                }
            }
        }
        requestAnimationFrame(step);
    });
};
</script>
@endsection
