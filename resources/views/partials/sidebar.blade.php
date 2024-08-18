
<div class="d-flex sidebar-mobile overflow-x-hidden flex-shrink-0" id="sidebar-container" data-sidebar-state="expanded" style="widths: 18rem;">
    <!-- <button class="btn d-none rounded-pill fs-3" id="close_sidebar_mobile" onclick="toggleSidebar()"><i class="fas fa-fw fa-times-circle"></i></button> -->
  
    <aside class="sidebar position-relative w-100">
      <button class="position-absolute btn btn-sm" id="close_sidebar_mobile" onclick="toggleSidebar()">
        <i class="fas fa-fw fa-times"></i>
      </button>
  
      <div class="d-flex flex-column pt-4 px-3 align-items-center text-decoration-none">
        {{-- <img src="/logo.png" alt="Logo" style="width: 80px; height: 80px;"> --}}
        <h5 class="text-center fw-bold">Si<span class="text-primary">Absensi</span></h5>
      </div>
  
      <ul class="nav flex-column mb-auto h-100 flex-nowrap p-2 gap-1" style="min-width: 16rem">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard') ? 'active text-primary' : '' }}">
            <i class='bx bx-home-alt fs-4'></i>
            <span class="nav-item-text">Dashboard</span>
          </a>
        </li>

        @php
            $master_expanded = (Request::is('dashboard/pegawai*') || Request::is('dashboard/jabatan*')) || Request::is('dashboard/lokasi-absensi*');
        @endphp
        <li class="nav-item">
          <a class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 nav-expand {{ $master_expanded ? 'show' : ' collapsed' }}" data-bs-toggle="collapse" href="#master-data">
            <i class='bx bx-data fs-4' ></i>
            <span class="nav-item-text">Master Data</span>
            
            <i class='bx bx-chevron-down expand-icon ms-auto'></i>
          </a>
        </li>
        
  
        <div class="collapse {{ $master_expanded ? 'show' : '' }}" id="master-data">
          <div class="d-flex flex-column gap-1 py-1 border-top border-bottom">
            <li class="nav-item">
              <a href="{{ route('pegawai.index') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard/pegawai*') ? 'active text-primary' : '' }}">
                <i class='bx bx-group fs-4'></i>
                <span class="nav-item-text">Pegawai</span>
              </a>
            </li>
  
            <li class="nav-item">
              <a href="{{ route('jabatan.index') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard/jabatan*') ? 'active text-primary' : '' }}">
                <i class='bx bx-shield fs-4'></i>
                <span class="nav-item-text">Jabatan</span>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('lokasi_absensi.index') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard/lokasi-absensi*') ? 'active text-primary' : '' }}">
                <i class='bx bx-map fs-4'></i>
                <span class="nav-item-text">Lokasi Absensi</span>
              </a>
            </li>
          </div>
        </div>
        <li>
          <a href="{{ route('absensi.index') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard/absensi*') ? 'active text-primary' : '' }}">
            {{-- <i data-lucide="calendar-check" lucide-size="20"></i> --}}
            <i class='bx bx-calendar-check fs-4'></i>
            <span class="nav-item-text">Absensi</span>
          </a>
        </li>
        <li>
          <a href="{{ route('izin.index') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard/izin*') ? 'active text-primary' : '' }}">
            <i class='bx bx-file fs-4'></i>
            <span class="nav-item-text">Pengajuan Izin</span>
          </a>
        </li>
        <li>
          <a href="{{ route('cuti.index') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard/cuti*') ? 'active text-primary' : '' }}">
            <i class='bx bx-calendar-star fs-4'></i>
            <span class="nav-item-text">Pengajuan Cuti</span>
          </a>
        </li>
        <hr>
        <li>
          <a href="{{ route('konfigurasi.index') }}" class="nav-link py-2.5 px-4 gap-3 d-flex align-items-center rounded-2 {{ Request::is('dashboard/konfigurasi*') ? 'active text-primary' : '' }}">
            <i class='bx bx-cog fs-4'></i>
            <span class="nav-item-text">Konfigurasi</span>
          </a>
        </li>
  
      </ul>
  
  
    </aside>
  
    {{-- <script>
      var currentSidebarState = localStorage.getItem('sidebarState');
      var sidebar = document.getElementById('sidebar-container');
  
      if (currentSidebarState === 'collapsed') {
        // change width of sidebar to 16rem
        sidebar.style.width = '4.3rem';
        $('.nav-item-text').css('opacity', '0');
        $('#sidebar-container').data('sidebar-state', 'collapsed')
      } else {
        // change width of sidebar to 0
      
        sidebar.style.width = '16rem';
        $('.nav-item-text').css('opacity', '1');
        $('#sidebar-container').data('sidebar-state', 'expanded')
      }
    </script> --}}
  
  
  </div>
  
  <div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteModalLabel">Keluar?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column align-items-center">
            <i class="fas fa-exclamation-triangle fs-1 text-warning mb-3"></i>
            <div class="text-center">Apakah Anda yakin ingin keluar?</div>
          </div>
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <a href="#"  class="btn btn-danger">Keluar</a>
        </div>
      </div>
    </div>
  </div>