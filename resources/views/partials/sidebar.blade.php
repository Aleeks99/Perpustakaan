<!-- Sidebar -->
@role('admin')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
            {{-- <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-book-reader"></i>
            </div> --}}
            <img src="{{ asset('img/favicon.png') }}" alt="SMK YPKK 1 Sleman" style="width: 48px">
            <div class="sidebar-brand-text mx-3">E-Library</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ ($title === 'Dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/home">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        <li class="nav-item {{ (Request::is('books') || Request::is('books/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/books">
                <i class="fas fa-fw fa-book"></i>
                <span>Buku</span></a>
        </li>

        <li class="nav-item {{ (Request::is('category') || Request::is('category/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/category">
                <i class="fas fa-fw fa-tags"></i>
                <span>Kategori</span></a>
        </li>

        <li class="nav-item {{ (Request::is('classroom') || Request::is('classroom/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/classroom">
                <i class="fas fa-fw fa-door-open"></i>
                <span>Kelas</span></a>
        </li>

        <li class="nav-item {{ (Request::is('staff') || Request::is('staff/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/staff">
                <i class="fas fa-fw fa-id-badge"></i>
                <span>Petugas</span></a>
        </li>
        
        <li class="nav-item {{ (Request::is('member') || Request::is('member/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/member">
                <i class="fas fa-fw fa-users"></i>
                <span>Anggota</span></a>
        </li>

        <li class="nav-item {{ (Request::is('log')) ? 'active' : '' }}">
            <a class="nav-link" href="/log">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Riwayat Transaksi</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->
@endrole
@role('librarian')
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-book-reader"></i>
            </div>
            <div class="sidebar-brand-text mx-3">E-Library</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ ($title === 'Dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/home">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        <li class="nav-item {{ (Request::is('books') || Request::is('books/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/books">
                <i class="fas fa-fw fa-book"></i>
                <span>Buku</span></a>
        </li>

        <li class="nav-item {{ (Request::is('transaction') || Request::is('transaction/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/transaction">
                <i class="fas fa-fw fa-exchange-alt"></i>
                <span>Transaksi</span></a>
        </li>

        <li class="nav-item {{ (Request::is('return') || Request::is('return/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/return">
                <i class="fas fa-hands"></i>
                <span>Peminjaman</span></a>
        </li>
        
        <li class="nav-item {{ (Request::is('member') || Request::is('member/*')) ? 'active' : '' }}">
            <a class="nav-link" href="/member">
                <i class="fas fa-fw fa-users"></i>
                <span>Anggota</span></a>
        </li>

        <li class="nav-item {{ (Request::is('log')) ? 'active' : '' }}">
            <a class="nav-link" href="/log">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Riwayat Transaksi</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->
@endrole