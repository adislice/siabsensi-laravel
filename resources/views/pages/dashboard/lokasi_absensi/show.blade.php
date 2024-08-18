@section('title', 'Detail Lokasi Absensi')

@extends('layouts.admin_layout')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
  #map {
    height: 400px;
  }
</style>
@endpush

@section('content')
<div class="d-flex mt-2 mb-3 align-items-center">
  <a href="{{ route('lokasi_absensi.index') }}" class="d-inline-flex me-2 bg-hover rounded-pill p-1">
    <i class='bx bx-left-arrow-alt fs-3'></i></a>
  <h4 class="mb-0">Detail Lokasi Absensi</h4>
  <div class="ms-auto">
    <a href="{{ route('dashboard') }}">Home</a> /
    <a href="{{ route('lokasi_absensi.index') }}">Lokasi Absensi</a> /
    <span class="text-muted">Detail</span>

  </div>
</div>
<div class="p-4 bg-white rounded-3">

  <div class="row">
    <div class="col-lg-6">
      <div class="mb-3">
        <div id="map"></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="mb-4">
        <div class="fw-semibold">Nama Lokasi</div>
        <div>{{ $lokasi_absensi->nama_lokasi }}</div>
      </div>
      <div class="mb-4">
        <div class="fw-semibold">Latitude</div>
        <div>{{ $lokasi_absensi->latitude }}</div>
      </div>
      <div class="mb-4">
        <div class="fw-semibold">Longitude</div>
        <div>{{ $lokasi_absensi->longitude }}</div>
      </div>
      <div class="mb-4">
        <div class="fw-semibold">Radius</div>
        <div>{{ $lokasi_absensi->radius }}</div>
      </div>

    </div>
  </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var zoom = 17;
  var lat = {{ $lokasi_absensi->latitude }};
  var lng = {{ $lokasi_absensi->longitude }};
  var radius = {{ $lokasi_absensi->radius }};
  // Initialize the map
  var map = L.map('map', {
      center: [lat, lng],
      zoom: zoom
  });

  // Add OpenStreetMap tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Add marker to the map
  var marker = L.marker([lat, lng], {
      draggable: false
  }).addTo(map);

  var circle = L.circle([lat, lng], {
          color: 'blue',
          fillColor: '#3186cc',
          fillOpacity: 0.5,
          radius: radius
      }).addTo(map);

</script>

@endsection