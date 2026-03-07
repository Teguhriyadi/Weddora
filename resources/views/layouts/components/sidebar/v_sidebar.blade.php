<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/modules/dashboard') }}">
        <div class="sidebar-brand-text mx-3">
            Weddora
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/kategori') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Kategori</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/guest') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Tamu Undangan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/scan-qr-guest') }}">
            <i class="fas fa-fw fa-camera"></i>
            <span>Scan QR Tamu</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/input-attendance') }}">
            <i class="fas fa-fw fa-edit"></i>
            <span>Input Kehadiran</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/history-guest') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Riwayat Tamu Undangan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/role') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Role</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('/modules/users') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
