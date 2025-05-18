<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Preschool Dashboard</title>
    
    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <!-- Dashboard Stylesheet -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <!-- Enhanced Responsive Sidebar Styles -->
    <style>
        /* Base sidebar styles */
        body {
            background-color: #f8f9fc;
        }
        
        .dashboard-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            z-index: 1040;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .main-content {
            flex: 1;
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            transition: all 0.3s ease;
            background-color: #f8f9fc;
        }
        
        /* Content area with a subtle pattern */
        .content {
            background-color: #f8f9fc;
            background-image: url("data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23e9ecef' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 5v1H5V0zm1 5v1H5v-1h1z'/%3E%3C/g%3E%3C/svg%3E");
            min-height: calc(100vh - 160px);
            padding: 1.5rem;
            border-radius: 0.35rem;
        }
        
        /* Sidebar header styling */
        .sidebar-header {
            background-color: rgba(0, 0, 0, 0.1);
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sidebar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.2rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .sidebar-brand:hover {
            color: #fff;
            opacity: 0.9;
        }
        
        /* Sidebar toggle and mobile behavior */
        .sidebar-toggle {
            display: none;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            padding: 0.5rem;
            cursor: pointer;
            color: #fff;
        }
        
        /* Mobile specific styles */
        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: 85%;
                max-width: 300px;
            }
            
            .sidebar.mobile-active {
                transform: translateX(0);
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .sidebar-toggle {
                display: block;
                position: absolute;
                right: 1rem;
                top: 1rem;
                z-index: 1050;
                background: transparent;
                border: none;
                color: #fff;
                font-size: 1.25rem;
                padding: 0.5rem;
                cursor: pointer;
                transition: transform 0.3s ease;
            }
            
            .sidebar-toggle:hover {
                transform: scale(1.1);
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1030;
                opacity: 0;
                transition: opacity 0.3s ease;
                backdrop-filter: blur(2px);
            }
            
            .sidebar-overlay.active {
                display: block;
                opacity: 1;
            }
            
            /* Enhanced mobile sidebar navigation */
            .sidebar-nav {
                padding: 0.5rem;
            }
            
            .sidebar-item .sidebar-link {
                padding: 0.875rem 1rem;
                margin: 0.25rem 0;
                border-radius: 0.5rem;
                font-size: 0.95rem;
            }
            
            .sidebar-item .sidebar-link i {
                width: 1.5rem;
                text-align: center;
                font-size: 1.1rem;
            }
            
            .sidebar-header {
                padding: 0.7rem 1rem 0.7rem 1rem !important;
                min-height: unset;
            }
            
            /* Improved user section on mobile */
            .sidebar-user {
                padding: 0.5rem 1rem !important;
                margin-bottom: 0.25rem !important;
            }
            
            .sidebar-user i {
                font-size: 1.3rem !important;
            }
            
            .sidebar-user-info {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .sidebar-user-brand {
                font-size: 1.05rem;
                font-weight: 700;
                color: #fff;
                margin-bottom: 0.1rem;
                letter-spacing: 0.01em;
                line-height: 1.1;
            }
            
            .sidebar-user-name {
                font-size: 0.95rem !important;
                font-weight: 500;
                color: #fff;
                margin-bottom: 0.05rem;
            }
            
            .sidebar-user-role {
                font-size: 0.8rem !important;
                color: #e0e0e0;
            }
            
            .sidebar-item .sidebar-link span {
                display: inline !important;
                color: #fff !important;
                font-size: 1rem !important;
                font-weight: 500;
                margin-left: 0.5rem;
                letter-spacing: 0.01em;
                white-space: normal;
            }
            
            .sidebar-item .sidebar-link {
                justify-content: flex-start;
                align-items: center;
            }
            
            .sidebar-brand {
                font-size: 1.1rem !important;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.2rem 0 !important;
                min-height: 36px;
            }
            
            .sidebar-brand i {
                font-size: 1.4rem !important;
                margin-right: 0.5rem !important;
                line-height: 1;
                display: flex;
                align-items: center;
            }
            
            .sidebar-brand span {
                display: inline-block !important;
                font-size: 1.1rem !important;
                font-weight: 700;
                letter-spacing: 0.01em;
                color: #fff !important;
                line-height: 1.2;
                vertical-align: middle;
                margin-top: 0.1rem;
            }
        }
        
        /* Enhanced sidebar navigation */
        .sidebar-item .sidebar-link {
            padding: 0.875rem 1rem;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0.5rem;
        }
        
        .sidebar-item .sidebar-link:hover,
        .sidebar-item .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateX(5px);
        }
        
        .sidebar-item .sidebar-link i {
            width: 1.5rem;
            text-align: center;
            margin-right: 0.75rem;
            font-size: 1.1rem;
            transition: transform 0.2s ease;
        }
        
        .sidebar-item .sidebar-link:hover i,
        .sidebar-item .sidebar-link.active i {
            transform: scale(1.1);
        }
        
        /* Top navbar styling */
        .navbar {
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.15);
        }
        
        /* User avatar styling */
        .user-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 1px solid #e3e6f0;
        }
        
        /* Logout modal fixes for mobile */
        @media (max-width: 767.98px) {
            .modal-dialog {
                margin: 0.5rem;
            }
        }
        
        /* Footer styling */
        .footer {
            background-color: #fff;
            border-top: 1px solid #e3e6f0;
            padding: 1.5rem 1.5rem;
        }
        
        /* Fix content area on mobile */
        @media (max-width: 767.98px) {
            .content {
                padding: 0.5rem;
            }
            
            .footer {
                text-align: center;
                padding: 1rem 0.5rem;
            }
            
            .footer .text-md-end {
                text-align: center !important;
                margin-top: 0.5rem;
            }
        }
        
        /* Sidebar user section */
        .sidebar-user {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-user-info {
            margin-left: 0.5rem;
        }
        
        .sidebar-user-name {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: #fff;
        }
        
        .sidebar-user-role {
            display: block;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
    
    @push('styles')
    <style>
    @media (max-width: 67.98px) {
      .card {
        padding: 2.1rem 5.7rem !important;
        margin-bottom: 0.2rem !important;
      }
      .card-title, .stat-title, .statistik-title, .statistik-admin-title {
        font-size: 1.25rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.7rem !important;
      }
      .stat-value, .statistik-value, .total-value, .dashboard-stat-value {
        font-size: 1.5rem !important;
        font-weight: 800 !important;
        margin-bottom: 0.3rem !important;
        margin-top: 0.2rem !important;
        letter-spacing: 0.01em;
      }
      .stat-label, .statistik-label {
        font-size: 1.1rem !important;
        font-weight: 500 !important;
      }
      .card .chart-container, .card canvas, .chartjs-render-monitor {
        min-height: 350px !important;
        height: 160px !important;
        max-height: 520px !important;
      }
      .card .card-body {
        padding: 6rem 0.5rem !important;
      }
      .card .row, .card .d-flex {
        margin-bottom: 0.5rem !important;
      }
    }
    </style>
    @endpush
    
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay"></div>
        
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="sidebar-brand">
                    <i class="fa fa-book-reader me-2"></i>
                    <span>Bimbel SIBI</span>
                </a>
                <button class="sidebar-toggle d-md-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="sidebar-user">
                @if(auth()->user()->role === 'admin')
                    <i class="fas fa-user-shield fa-2x text-white me-2"></i>
                @elseif(auth()->user()->role === 'teacher')
                    <i class="fas fa-chalkboard-teacher fa-2x text-white me-2"></i>
                @else
                    <i class="fas fa-user-friends fa-2x text-white me-2"></i>
                @endif
                <div class="sidebar-user-info">
                    <span class="sidebar-user-name">{{ auth()->user()->name }}</span>
                    <span class="sidebar-user-role">
                        @if(auth()->user()->role === 'admin')
                            <i class="fas fa-crown text-warning me-1"></i>
                        @elseif(auth()->user()->role === 'teacher')
                            <i class="fas fa-graduation-cap text-warning me-1"></i>
                        @else
                            <i class="fas fa-home text-warning me-1"></i>
                        @endif
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>
            
            <ul class="sidebar-nav">
                <li class="sidebar-header">Menu Utama</li>
                
                <li class="sidebar-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        @if(auth()->user()->role === 'admin')
                            <i class="fas fa-laptop-house me-2"></i>
                        @elseif(auth()->user()->role === 'teacher')
                            <i class="fas fa-school me-2"></i>
                        @else
                            <i class="fas fa-home me-2"></i>
                        @endif
                        <span>Dashboard</span>
                    </a>
                </li>
                
                @if(auth()->user()->role === 'teacher')
                <!-- Menu Guru -->
                <li class="sidebar-header">Menu Utama</li>
                
                <li class="sidebar-item">
                    <a href="{{ route('progress.index') }}" class="sidebar-link {{ request()->routeIs('progress.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line me-2"></i>
                        <span>Perkembangan Siswa</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('attendance.index') }}" class="sidebar-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check me-2"></i>
                        <span>Presensi</span>
                    </a>
                </li>
                
                <li class="sidebar-header">Data Siswa</li>
                
                <li class="sidebar-item">
                    <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate me-2"></i>
                        <span>Daftar Siswa</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('parents.index') }}" class="sidebar-link {{ request()->routeIs('parents.*') ? 'active' : '' }}">
                        <i class="fas fa-user-friends me-2"></i>
                        <span>Data Orang Tua</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('teachers.index') }}" class="sidebar-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        <span>Data Guru</span>
                    </a>
                </li>
                
                <li class="sidebar-header">Informasi</li>
                
                <li class="sidebar-item">
                    <a href="{{ route('policies.index') }}" class="sidebar-link {{ request()->routeIs('policies.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-2"></i>
                        <span>Kebijakan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('reviews.index') }}" class="sidebar-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-comment-dots me-2"></i>
                        <span>Ulasan dan Testimoni</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('testimonial') }}" class="sidebar-link {{ request()->routeIs('testimonial') ? 'active' : '' }}" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>
                        <span>Lihat Halaman Ulasan Publik</span>
                    </a>
                </li>

                <li class="sidebar-header">Akun</li>
                <li class="sidebar-item">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle me-2"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span>Keluar</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                @elseif(auth()->user()->role === 'parent')
                <!-- Menu Orang Tua -->
                <li class="sidebar-item">
                    <a href="{{ route('progress.index') }}" class="sidebar-link {{ request()->routeIs('progress.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line me-2"></i>
                        <span>Perkembangan Anak</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('parent.attendance.index') }}" class="sidebar-link {{ request()->routeIs('parent.attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check me-2"></i>
                        <span>Presensi</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('reviews.index') }}" class="sidebar-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-star me-2"></i>
                        <span>Ulasan dan Testimoni</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('testimonial') }}" class="sidebar-link {{ request()->routeIs('testimonial') ? 'active' : '' }}" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>
                        <span>Lihat Halaman Ulasan Publik</span>
                    </a>
                </li>

                <li class="sidebar-header">Akun</li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span>Keluar</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                @elseif(auth()->user()->role === 'admin')
                <!-- Menu Admin -->
                <li class="sidebar-header">Manajemen</li>
                <li class="sidebar-item">
                    <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate me-2"></i>
                        <span>Siswa</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('teachers.index') }}" class="sidebar-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        <span>Guru</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('parents.index') }}" class="sidebar-link {{ request()->routeIs('parents.*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i>
                        <span>Orang Tua</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('policies.index') }}" class="sidebar-link {{ request()->routeIs('policies.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-2"></i>
                        <span>Kebijakan</span>
                    </a>
                </li>
                
                <li class="sidebar-header">Akun</li>
                
                @if(auth()->user()->role === 'admin')
                <li class="sidebar-item">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle me-2"></i>
                        <span>Profil</span>
                    </a>
                </li>
                @elseif(auth()->user()->role === 'teacher')
                <li class="sidebar-item">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle me-2"></i>
                        <span>Profil</span>
                    </a>
                </li>
                @endif
                
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span>Keluar</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                @endif
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-2 text-primary">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Page Title - Only visible on mobile -->
                <h5 class="d-md-none text-truncate mb-0 me-auto text-primary">@yield('title', 'Dashboard')</h5>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-lg-inline text-gray-600 small me-2">{{ auth()->user()->name }}</span>
                            <div class="user-avatar">
                                @if(auth()->user()->role === 'admin')
                                    <i class="fas fa-user-shield text-primary"></i>
                                @elseif(auth()->user()->role === 'teacher')
                                    <i class="fas fa-chalkboard-teacher text-success"></i>
                                @else
                                    <i class="fas fa-user-friends text-info"></i>
                                @endif
                            </div>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            
            <!-- Content -->
            <div class="content shadow-sm">
                @yield('content')
            </div>
            
            <!-- Footer -->
            <footer class="footer mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">
                                &copy; {{ date('Y') }} <a href="{{ route('home') }}" class="text-decoration-none text-primary">Bimbel SIBI</a> - Hak Cipta Dilindungi
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-0">
                                <a href="{{ route('about') }}" class="text-decoration-none text-primary me-3">Tentang Kami</a>
                                <a href="{{ route('contact') }}" class="text-decoration-none text-primary">Kontak</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda yakin ingin keluar?</h5>
                    <button class="close btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pilih "Logout" jika Anda ingin mengakhiri sesi Anda saat ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <a class="btn btn-success" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-modal').submit();">Logout</a>
                    <form id="logout-form-modal" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    
    <!-- Dashboard JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile sidebar functionality
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebarOverlay = document.querySelector('.sidebar-overlay');
        const sidebarToggleTop = document.querySelector('#sidebarToggleTop');
        const mainContent = document.querySelector('.main-content');
        
        // Function to open sidebar on mobile
        function openSidebar() {
            sidebar.classList.add('mobile-active');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Add touch event listeners for swipe
            document.addEventListener('touchstart', handleTouchStart, false);
            document.addEventListener('touchmove', handleTouchMove, false);
        }
        
        // Function to close sidebar on mobile
        function closeSidebar() {
            sidebar.classList.remove('mobile-active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
            
            // Remove touch event listeners
            document.removeEventListener('touchstart', handleTouchStart, false);
            document.removeEventListener('touchmove', handleTouchMove, false);
        }
        
        // Touch handling for swipe gestures
        let xDown = null;
        let yDown = null;
        
        function handleTouchStart(evt) {
            xDown = evt.touches[0].clientX;
            yDown = evt.touches[0].clientY;
        }
        
        function handleTouchMove(evt) {
            if (!xDown || !yDown) {
                return;
            }
            
            const xUp = evt.touches[0].clientX;
            const yUp = evt.touches[0].clientY;
            
            const xDiff = xDown - xUp;
            const yDiff = yDown - yUp;
            
            // Check if the swipe is horizontal and significant
            if (Math.abs(xDiff) > Math.abs(yDiff) && Math.abs(xDiff) > 50) {
                if (xDiff > 0) {
                    // Swipe left - close sidebar
                    closeSidebar();
                }
            }
            
            xDown = null;
            yDown = null;
        }
        
        // Toggle sidebar on mobile icon click
        if (sidebarToggleTop) {
            sidebarToggleTop.addEventListener('click', function(e) {
                e.preventDefault();
                openSidebar();
            });
        }
        
        // Close sidebar when X button is clicked
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                closeSidebar();
            });
        }
        
        // Close sidebar when clicking on overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                closeSidebar();
            });
        }
        
        // Close sidebar when clicking on any sidebar link on mobile
        document.querySelectorAll('.sidebar-link').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    // Add a small delay to allow the click to register
                    setTimeout(function() {
                        closeSidebar();
                    }, 100);
                }
            });
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                closeSidebar();
                mainContent.style.marginLeft = '';
            }
        });
        
        // Highlight active sidebar menu with animation
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar-nav a.sidebar-link').forEach(function(link) {
            const href = link.getAttribute('href');
            if (href === currentPath || (currentPath.includes(href) && href !== '/')) {
                link.classList.add('active');
                link.closest('.sidebar-item').classList.add('active');
                
                // Scroll active item into view on mobile
                if (window.innerWidth < 768) {
                    setTimeout(() => {
                        link.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 300);
                }
            }
        });
        
        // Initialize Bootstrap 5 dropdowns
        const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
        const dropdownList = [...dropdownElementList].map(dropdownToggleEl => {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
        
        // Initialize Bootstrap 5 modal
        const logoutModal = document.getElementById('logoutModal');
        if (logoutModal) {
            const modal = new bootstrap.Modal(logoutModal);
            
            // Handle modal triggers
            document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#logoutModal"]').forEach(trigger => {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    modal.show();
                });
            });
        }
    });
    </script>
    
    @yield('scripts')
</body>
</html> 
 
 