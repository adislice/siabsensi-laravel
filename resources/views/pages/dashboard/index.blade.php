@php
$dates = array_keys($summary_absensi);
$counts = array_values($summary_absensi);
$shortDates = array_map(function($date) {
    return \Carbon\Carbon::parse($date)->format('d');
}, $dates);
@endphp
@section('navigasi', 'Dashboard')
@section('title', 'Dashboard')

@extends('layouts.admin_layout')

@section('content')
  <div class="p-4 bg-white rounded-3">
    {{-- <div class="d-flex flex-column align-items-center mb-2">
      <img src="/muhammadiyah_logo.png" alt="Logo" style="width: 10rem; height: 10rem;">
      <h2 class="mb-4 fs-1">SD Muhammadiyah 01 Kencong</h2>
    </div> --}}

    <h6 class="fw-bold">Overview</h6>
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
          <h4 class="mb-0 lh-1 fw-bold">{{ $jml_cuti }}</h4>
          <small>Cuti diajukan</small>
        </div>
        <div class="ms-auto text-warning">
          <i data-lucide="calendar-range" class="fs-1" style="height: 1.6rem; width: auto"></i>
        </div>
      </div>

      <div class="col-12 col-md rounded-1 d-flex px-4 py-3 flex-row" style="background-color: #FEE2E2;">
        <div>
          <div class="fw-bold mb-2">Izin</div>
          <h4 class="mb-0 lh-1 fw-bold">{{ $jml_izin }}</h4>
          <small>Izin diajukan</small>
        </div>
        <div class="ms-auto text-danger">
          <i data-lucide="file-text" class="fs-1" style="height: 1.6rem; width: auto"></i>
        </div>
      </div>
    </div>
    <h6 class="fw-bold mt-4">Grafik Absensi Bulan Ini ({{ \Carbon\Carbon::now()->format('F Y') }})</h6>
    <div class="overflow-x-auto pb-2">
    <div style="min-width: 900px">
      <canvas id="attendanceChart" height="130" class=" top-0 start-0"></canvas>
    </div>
    </div>
  </div>

  @push('custom-scripts')
    <script>
      const ctx = document.getElementById('attendanceChart').getContext('2d');
      const maxCount = Math.max(...@json($counts));
      const chartData = {
        labels: @json($shortDates),
        datasets: [{
            label: 'Jumlah Hadir',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            data: @json($counts),
        }]
    };

    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
          
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Jumlah Hadir'
                    },
                    beginAtZero: true,
                    max: maxCount < 10 ? 10 : maxCount + 2
                }
            }
        }
    });
    </script>
  @endpush

@endsection
