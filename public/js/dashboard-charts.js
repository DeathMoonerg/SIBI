/**
 * Dashboard Charts - Main chart functionality for the dashboard
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get user role and determine which chart data to fetch
    const userRole = document.querySelector('meta[name="user-role"]')?.getAttribute('content');
    
    if (userRole === 'parent') {
        fetchParentChartData();
    } else if (userRole === 'admin') {
        fetchAdminChartData();
    } else if (userRole === 'teacher') {
        fetchTeacherChartData();
    }

    /**
     * Fetch chart data for parent dashboard
     */
    function fetchParentChartData() {
        const parentStatsRoute = document.querySelector('meta[name="parent-stats-route"]')?.getAttribute('content');
        if (!parentStatsRoute) return;

        fetch(parentStatsRoute)
            .then(response => response.json())
            .then(data => {
                renderParentCharts(data);
            })
            .catch(error => {
                console.error('Error fetching parent chart data:', error);
                // Use fallback data if API call fails
                renderParentCharts({
                    progressLabels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
                    progressData: [75, 80, 78, 85, 88, 90]
                });
            });
    }

    /**
     * Fetch chart data for admin dashboard
     */
    function fetchAdminChartData() {
        fetch('/chart/admin-dashboard')
            .then(response => response.json())
            .then(data => {
                renderCombinedChart(data, 'admin');
            })
            .catch(error => {
                console.error('Error fetching admin chart data:', error);
            });
    }

    /**
     * Fetch chart data for teacher dashboard
     */
    function fetchTeacherChartData() {
        fetch('/chart/teacher-dashboard')
            .then(response => response.json())
            .then(data => {
                renderCombinedChart(data, 'teacher');
            })
            .catch(error => {
                console.error('Error fetching teacher chart data:', error);
            });
    }

    /**
     * Render combined chart for both admin and teacher dashboards
     */
    function renderCombinedChart(data, role) {
        const combinedChartCtx = document.getElementById('combinedChart');
        if (combinedChartCtx) {
            new Chart(combinedChartCtx, {
                type: 'line',
                data: {
                    labels: data.statsLabels,
                    datasets: [
                        {
                            label: 'Total Siswa',
                            data: data.totalStudentsData,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: 'rgb(75, 192, 192)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Total Pertemuan',
                            data: data.monthlyMeetingsData,
                            borderColor: 'rgba(255, 99, 132, 0.8)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: 'rgba(255, 99, 132, 0.8)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    layout: {
                        padding: {
                            top: 20,
                            right: 40,
                            bottom: 20,
                            left: 20
                        },
                        maintainAspectRatio: false
                    },
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: role === 'admin' ? 'Statistik Admin' : 'Statistik Guru',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
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
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y;
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Total Siswa',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Total Pertemuan',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Bulan',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            radius: 5,
                            hoverRadius: 7,
                            hitRadius: 10
                        },
                        line: {
                            borderWidth: 2
                        }
                    }
                }
            });
        }
    }

    /**
     * Render charts for parent dashboard
     */
    function renderParentCharts(data) {
        const progressCtx = document.getElementById('progressChart');
        if (progressCtx) {
            new Chart(progressCtx, {
                type: 'line',
                data: {
                    labels: data.progressLabels,
                    datasets: [{
                        label: 'Nilai Rata-rata',
                        data: data.progressData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    elements: {
                        point: {
                            radius: 5,
                            hoverRadius: 7,
                            hitRadius: 10
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: false
                    }
                }
            });
        }
    }

    /**
     * Render charts for admin dashboard
     */
    function renderAdminCharts(data) {
        // Total Students Chart
        const totalStudentsCtx = document.getElementById('totalStudentsChart');
        if (totalStudentsCtx) {
            new Chart(totalStudentsCtx, {
                type: 'line',
                data: {
                    labels: data.statsLabels,
                    datasets: [{
                        label: 'Total Siswa',
                        data: data.totalStudentsData,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Perkembangan Total Siswa'
                        }
                    }
                }
            });
        }

        // Monthly Meetings Chart
        const monthlyMeetingsCtx = document.getElementById('monthlyMeetingsChart');
        if (monthlyMeetingsCtx) {
            new Chart(monthlyMeetingsCtx, {
                type: 'bar',
                data: {
                    labels: data.statsLabels,
                    datasets: [{
                        label: 'Total Pertemuan',
                        data: data.monthlyMeetingsData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Total Pertemuan per Bulan'
                        }
                    }
                }
            });
        }
    }

    /**
     * Render charts for teacher dashboard
     */
    function renderTeacherCharts(data) {
        // Total Students Chart
        const totalStudentsCtx = document.getElementById('totalStudentsChart');
        if (totalStudentsCtx) {
            new Chart(totalStudentsCtx, {
                type: 'line',
                data: {
                    labels: data.statsLabels,
                    datasets: [{
                        label: 'Total Siswa',
                        data: data.totalStudentsData,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Perkembangan Total Siswa'
                        }
                    }
                }
            });
        }

        // Monthly Meetings Chart
        const monthlyMeetingsCtx = document.getElementById('monthlyMeetingsChart');
        if (monthlyMeetingsCtx) {
            new Chart(monthlyMeetingsCtx, {
                type: 'bar',
                data: {
                    labels: data.statsLabels,
                    datasets: [{
                        label: 'Total Pertemuan',
                        data: data.monthlyMeetingsData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Total Pertemuan per Bulan'
                        }
                    }
                }
            });
        }
    }
}); 