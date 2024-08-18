<nav class=" navbar navbar-expand-lg bg-white px-2 shadow-sm position-sticky top-0" style="z-index: 1001">

    <div class="d-flex align-items-center">
      <button class="btn btn-sm d-md-none btn-icon" id="open_sidebar" onclick="toggleSidebar()"><i class='bx bx-menu fs-3'></i></button>
      {{-- <button class="btn btn-sm d-none d-md-block btn-icon" onclick="toggleSidebarDesktop()"><i class='bx bx-menu fs-3'></i></button> --}}
      {{-- <a class="navbar-brand px-2 fs-5 fw-semibold" href="#">Admin Panel</a> --}}
      <div class="px-3 fw-semibold fs-6">@yield('navigasi', '')</div>
  
    </div>
    <div class="dropdown ms-auto">
      <button id="menu" class="btn btn-sm btn-light btn-neutral dropdown-toggle btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="me-2 fs-6"> {{ auth()->user()->nama_admin ?? '' }} </span>
        <i class='bx bxs-user-circle fs-3'></i>
        
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('konfigurasi.index') }}">Pengaturan</a></li>
        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
      </ul>
    </div>
  </nav>
  