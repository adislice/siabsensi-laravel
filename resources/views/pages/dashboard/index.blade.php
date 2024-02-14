@section('navigasi', 'Dashboard')
@section('title', 'Dashboard')

@extends('layouts.admin_layout')

@section('content')
  <div class="p-4 bg-white rounded-3">
    {{-- <div class="d-flex flex-column align-items-center mb-2">
      <img src="/muhammadiyah_logo.png" alt="Logo" style="width: 10rem; height: 10rem;">
      <h2 class="mb-4 fs-1">SD Muhammadiyah 01 Kencong</h2>
    </div> --}}

    <h6>Overview</h6>
    <div class="row gap-3 mx-0">
      <div class="col-12 col-md rounded-1 d-flex px-4 py-3 flex-row" style="background-color: #DCFCE7;">
        <div>
          <div class="fw-bold mb-2">Pegawai</div>
          <h4 class="mb-0 lh-1 fw-bold">{{ $jml_pegawai }}</h4>
          <small>Pegawai terdaftar</small>
        </div>
        <div class="ms-auto text-success">
          <i data-lucide="users" class="fs-1" style="height: 1.6rem; width: auto"></i>
        </div>
      </div>

      <div class="col-12 col-md rounded-1 d-flex px-4 py-3 flex-row" style="background-color: #DBEAFE;">
        <div>
          <div class="fw-bold mb-2">Absensi</div>
          <h4 class="mb-0 lh-1 fw-bold">{{ $persentase_hadir }}%</h4>
          <small>Absensi hadir</small>
        </div>
        <div class="ms-auto text-primary">
          <i data-lucide="calendar-check" class="fs-1" style="height: 1.6rem; width: auto"></i>
        </div>
      </div>

      <div class="col-12 col-md rounded-1 d-flex px-4 py-3 flex-row" style="background-color: #FEF9C3;">
        <div>
          <div class="fw-bold mb-2">Cuti</div>
          <h4 class="mb-0 lh-1 fw-bold">100</h4>
          <small>Cuti diajukan</small>
        </div>
        <div class="ms-auto text-warning">
          <i data-lucide="calendar-range" class="fs-1" style="height: 1.6rem; width: auto"></i>
        </div>
      </div>

      <div class="col-12 col-md rounded-1 d-flex px-4 py-3 flex-row" style="background-color: #FEE2E2;">
        <div>
          <div class="fw-bold mb-2">Izin</div>
          <h4 class="mb-0 lh-1 fw-bold">100</h4>
          <small>Izin diajukan</small>
        </div>
        <div class="ms-auto text-danger">
          <i data-lucide="file-text" class="fs-1" style="height: 1.6rem; width: auto"></i>
        </div>
      </div>
    </div>
  </div>

@endsection
