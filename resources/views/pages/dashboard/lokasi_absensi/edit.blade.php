@section('title', 'Tambah Lokasi Absensi')

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
  <h4 class="mb-0">Tambah Lokasi Absensi</h4>
  <div class="ms-auto">
    <a href="{{ route('dashboard') }}">Home</a> /
    <a href="{{ route('lokasi_absensi.index') }}">Lokasi Absensi</a> /
    <span class="text-muted">Tambah</span>

  </div>
</div>
<div class="p-4 bg-white rounded-3">

  <form action="{{ route('lokasi_absensi.update', $lokasi_absensi->id_lokasi_absensi) }}" method="post" class="d-flex flex-column"
    enctype="application/x-www-form-urlencoded">
    @csrf
    <div class="row">
      <div class="col">
        <div class="mb-3">
          <div id="map"></div>
        </div>
      </div>
      <div class="col-lg-6">

        <div class="mb-3">
          <label for="nama_lokasi" class="form-label fw-medium required">Nama Lokasi</label>
          <input type="text" class="form-control @error('nama_lokasi') is-invalid @enderror" id="nama_lokasi"
            name="nama_lokasi" placeholder="Masukkan Nama" value="{{ old('nama_lokasi', $lokasi_absensi->nama_lokasi) }}" required>
          @error('nama_lokasi')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="mb-3">
          <label for="latitude" class="form-label fw-medium required">Latitude</label>
          <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude"
            placeholder="Masukkan Latitude" value="{{ old('latitude', $lokasi_absensi->latitude) }}" required>
          @error('latitude')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="mb-3">
          <label for="longitude" class="form-label fw-medium required">Longitude</label>
          <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude"
            name="longitude" placeholder="Masukkan Longitude" value="{{ old('longitude', $lokasi_absensi->longitude) }}" required>
          @error('longitude')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="mb-3">
          <label for="radius" class="form-label fw-medium required">Radius</label>
          <input type="" class="form-control @error('radius') is-invalid @enderror" id="radius" name="radius"
            placeholder="Masukkan Radius" value="{{ old('radius', $lokasi_absensi->radius) }}" required>
          @error('radius')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>


    </div>
    <button type="submit" class="btn btn-primary align-self-center btn-icon">
      <i class='bx bxs-save me-1'></i>
      Simpan</button>
  </form>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var zoom = 17;
  var lat = $("#latitude").val();
  var lng = $("#longitude").val();
  var radius = $("#radius").val();
   // Initialize the circle
  var circle = null;

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

  updateCircle([lat, lng], radius);

  // Function to handle map click event
  function onMapClick(e) {
      marker.setLatLng(e.latlng);
      updateLatLngInputs(e.latlng.lat, e.latlng.lng);
      var radius = document.getElementById('radius').value;
      updateCircle(e.latlng, radius);
  }

  // Function to update latitude and longitude inputs
  function updateLatLngInputs(lat, lng) {
      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;
  }

  // Function to update circle around the marker
  function updateCircle(centerLatLng, radius) {
      if (circle) {
          map.removeLayer(circle);
      }
      circle = L.circle(centerLatLng, {
          color: 'blue',
          fillColor: '#3186cc',
          fillOpacity: 0.5,
          radius: radius
      }).addTo(map);
  }

  // Get user's current location using Geolocation API
  function getCurrentLocation() {
    navigator.geolocation.getCurrentPosition(function(position) {
      var initialLatLng = L.latLng(position.coords.latitude, position.coords.longitude);
      map.setView(initialLatLng, zoom); // Set initial view to user's current location
      marker.setLatLng(initialLatLng); // Set marker to user's current location
      updateLatLngInputs(initialLatLng.lat, initialLatLng.lng); // Update input fields
      updateCircle(initialLatLng, 100); // Draw circle around initial location with radius 100 meters
  }, function(error) {
      console.error('Error getting current location:', error);
  });
      
  }

  // Update circle when radius input value changes
  document.getElementById('radius').addEventListener('change', function() {
      var radius = parseInt(this.value);
      if (!isNaN(radius)) {
          updateCircle(marker.getLatLng(), radius);
      }
  });

  $("#latitude, #longitude").on("change", function() {
      var lat = parseFloat($("#latitude").val());
      var lng = parseFloat($("#longitude").val());
      var radius = parseInt($("#radius").val());
      if (!isNaN(lat) && !isNaN(lng)) {
          marker.setLatLng([lat, lng]);
          updateCircle([lat, lng], radius);
          map.setView([lat, lng], zoom);
      }
  })

  map.on('click', onMapClick);

  var oldLocationExist = {{ old('latitude') ? 'true' : 'false' }};
  if (oldLocationExist) {
    var lat = {{ old('latitude', 0) }};
      var lng = {{ old('longitude', 0) }};
      var radius = {{ old('radius', 100) }};
      updateLatLngInputs(lat, lng);
      updateCircle([lat, lng], radius);
      map.setView([lat, lng], zoom);
      marker.setLatLng([lat, lng]);
  } 
</script>

@endsection