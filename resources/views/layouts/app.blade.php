<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Presensi')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .navbar-brand {
            font-weight: bold;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .table {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            @if (auth()->check() || auth()->guard('dosen')->check() || auth()->guard('mahasiswa')->check())
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <div class="text-center mb-4">
                            <h4 class="text-white">
                                <i class="fas fa-graduation-cap"></i>
                                Sistem Presensi
                            </h4>
                        </div>

                        @if (auth()->check())
                            <!-- Admin Menu -->
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                        href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}"
                                        href="{{ route('admin.dosen.index') }}">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>
                                        Dosen
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}"
                                        href="{{ route('admin.mahasiswa.index') }}">
                                        <i class="fas fa-user-graduate me-2"></i>
                                        Mahasiswa
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.matakuliah.*') ? 'active' : '' }}"
                                        href="{{ route('admin.matakuliah.index') }}">
                                        <i class="fas fa-book me-2"></i>
                                        Mata Kuliah
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}"
                                        href="{{ route('admin.jadwal.index') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Jadwal
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}"
                                        href="{{ route('admin.kelas.index') }}">
                                        <i class="fas fa-school me-2"></i>
                                        Kelas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (request()->routeIs('admin.presensi.*')) active @endif"
                                        href="{{ route('admin.presensi.index') }}">
                                        <i class="fas fa-clipboard-check me-2"></i>
                                        Laporan Presensi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (request()->routeIs('admin.settings.*')) active @endif"
                                        href="{{ route('admin.settings.index') }}">
                                        <i class="fas fa-cog me-2"></i>
                                        Pengaturan
                                    </a>
                                </li>
                            </ul>
                        @elseif(auth()->guard('dosen')->check())
                            <!-- Dosen Menu -->
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link @if (request()->routeIs('dosen.dashboard')) active @endif"
                                        href="{{ route('dosen.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (request()->routeIs('dosen.jadwal.semester')) active @endif"
                                        href="{{ route('dosen.jadwal.semester') }}">
                                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Semester
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (request()->routeIs('dosen.presensi.index')) active @endif"
                                        href="{{ route('dosen.presensi.index') }}">
                                        <i class="fas fa-clipboard-check me-2"></i> Riwayat Presensi
                                    </a>
                                </li>
                            </ul>
                        @elseif(auth()->guard('mahasiswa')->check())
                            <!-- Mahasiswa Menu -->
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
                                        href="{{ route('mahasiswa.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('mahasiswa.jadwal.index') ? 'active' : '' }}"
                                        href="{{ route('mahasiswa.jadwal.index') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Jadwal
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('mahasiswa.presensi.*') ? 'active' : '' }}"
                                        href="{{ route('mahasiswa.presensi.index') }}">
                                        <i class="fas fa-clipboard-check me-2"></i>
                                        Presensi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('mahasiswa.jadwal.semester') ? 'active' : '' }}"
                                        href="{{ route('mahasiswa.jadwal.semester') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Jadwal semester
                                    </a>
                                </li>
                            </ul>
                        @endif

                        <hr class="text-white">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </nav>
            @endif

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
