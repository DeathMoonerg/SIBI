/**
 * Progress Charts - Handles chart display for student progress pages
 */
document.addEventListener('DOMContentLoaded', function() {
    // Filter progress records by month and year
    const filterMonth = document.getElementById('filterMonth');
    const filterYear = document.getElementById('filterYear');
    
    if (filterMonth && filterYear) {
        filterMonth.addEventListener('change', updateProgressRecords);
        filterYear.addEventListener('change', updateProgressRecords);
    }
    
    function updateProgressRecords() {
        const month = filterMonth.value;
        const year = filterYear.value;
        const studentId = document.querySelector('meta[name="student-id"]')?.getAttribute('content');
        const progressIndexRoute = document.querySelector('meta[name="progress-index-route"]')?.getAttribute('content');
        
        if (studentId && progressIndexRoute) {
            window.location.href = `${progressIndexRoute}?student_id=${studentId}&month=${month}&year=${year}`;
        }
    }
    
    // Initialize progress chart
    const ctx = document.getElementById('progressDetailChart');
    const chartData = JSON.parse(document.getElementById('progress-data')?.textContent || '{}');
                
    if (ctx && chartData && chartData.labels && chartData.scores) {
        new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartData.labels,
                datasets: [{
                                    label: 'Nilai Perkembangan',
                    data: chartData.scores,
                                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                                    fill: false
                }]
                        },
                        options: {
                            responsive: true,
                maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    title: {
                                        display: true,
                            text: 'Nilai (%)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                            text: 'Tanggal'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Grafik Perkembangan Nilai'
                                }
                            }
                        }
                    });
    }
    
    function showNoDataMessage(ctx) {
        if (ctx && ctx.parentElement) {
            ctx.parentElement.innerHTML = '<div class="text-center py-5">' +
                '<div class="mb-3"><i class="fa fa-chart-line fa-4x text-muted"></i></div>' +
                '<h5>Belum ada data perkembangan untuk ditampilkan.</h5>' +
                '<p class="text-muted">Data perkembangan akan ditampilkan setelah ada laporan perkembangan.</p>' +
                '</div>';
        }
    }
}); 