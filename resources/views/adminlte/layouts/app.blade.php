<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koperasi WaSerba</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .card {
            position: relative;
        }
        .icon-top-right {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 24px;
        }
        .main-sidebar {
            color: white;
            background-color: rgba(11, 56, 164, 1);
        }
        .navbar-nav {
            list-style: none !important;
            padding-left: 0 !important;
            margin-bottom: 0 !important;
        }
        .navbar-nav > li {
            list-style: none !important;
        }
        .navbar-nav > li::marker {
            display: none !important;
        }
        .navbar-nav .nav-item::before,
        .navbar-nav .nav-item::after {
            display: none !important;
            content: none !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar (kosong, hanya tombol menu) -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-text font-weight-light">Koperasi WaSerba</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p style="color: white;">Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('anggota.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p style="color: white;">Anggota</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('barang.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p style="color: white;">Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kasir.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p style="color: white;">Kasir</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('index.income') }}" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p style="color: white;">Pemasukan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('index.expense') }}" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p style="color: white;">Pengeluaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('index.report') }}" class="nav-link">
                            <i class="nav-icon fas fa-info"></i>
                            <p style="color: white;">Laporan Keuangan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profil.show') }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p style="color: white;">My Profile</p>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link"
                           onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                           style="color:#ff4d4d;">
                            <i class="nav-icon fas fa-sign-out-alt" style="color:#ff4d4d;"></i>
                            <p style="color:#ff4d4d;">Logout</p>
                        </a>
                        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content -->
    @yield('content')

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

    @include('sweetalert::alert')
    @stack('scripts')   
        </div>
    </body>
</html>
