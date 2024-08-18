@section('title', 'Konfigurasi Sistem')

@extends('layouts.admin_layout')

@section('content')
<div class="d-flex mt-2 mb-3 align-items-center">
  <h4 class="mb-0">Konfigurasi Sistem</h4>
  <div class="ms-auto">
    <a href="{{ route('dashboard') }}">Home</a> /
    <span class="text-muted">Konfigurasi Sistem</span>

  </div>
</div>
<div class="p-4 bg-white rounded-3">
  <p class="fst-italic">Sesuaikan pengaturan sistem sesuai dengan kebutuhan instansi</p>
  <form action="{{ route('konfigurasi.save') }}" method="post" class="d-flex flex-column" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="mb-3">
          <label for="jam_masuk_dari" class="form-label fw-medium required">Jam Masuk Dari</label>
          <input type="time" class="form-control @error('jam_masuk_dari') is-invalid @enderror" id="jam_masuk_dari"
            name="jam_masuk_dari" placeholder="Jam Masuk Dari" value="{{ old('jam_masuk_dari', $konfigurasi->jam_masuk_dari) }}" required>
          @error('jam_masuk_dari')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mb-3">
          <label for="jam_masuk_sampai" class="form-label fw-medium required">Jam Masuk Sampai</label>
          <input type="time" class="form-control @error('jam_masuk_sampai') is-invalid @enderror" id="jam_masuk_sampai"
            name="jam_masuk_sampai" placeholder="Jam Masuk Sampai" value="{{ old('jam_masuk_sampai', $konfigurasi->jam_masuk_sampai) }}" required>
          @error('jam_masuk_sampai')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="mb-3">
          <label for="jam_pulang_dari" class="form-label fw-medium required">Jam Pulang Dari</label>
          <input type="time" class="form-control @error('jam_pulang_dari') is-invalid @enderror" id="jam_pulang_dari"
            name="jam_pulang_dari" placeholder="Jam Pulang Dari" value="{{ old('jam_pulang_dari', $konfigurasi->jam_pulang_dari) }}" required>
          @error('jam_pulang_dari')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mb-3">
          <label for="jam_pulang_sampai" class="form-label fw-medium required">Jam Pulang Sampai</label>
          <input type="time" class="form-control @error('jam_pulang_sampai') is-invalid @enderror" id="jam_pulang_sampai"
            name="jam_pulang_sampai" placeholder="Jam Pulang Sampai" value="{{ old('jam_pulang_sampai', $konfigurasi->jam_pulang_sampai) }}" required>
          @error('jam_pulang_sampai')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <label for="is_absensi_aktif" class="form-label fw-medium required">Aktifkan Absensi</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="is_absensi_aktif" value="1" id="flexRadioDefault1" {{ old('is_absensi_aktif', $konfigurasi->is_absensi_aktif) == 1 ? 'checked' : ''}}>
          <label class="form-check-label" for="flexRadioDefault1">
            Aktif
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="is_absensi_aktif" value="0" id="flexRadioDefault2" {{ old('is_absensi_aktif', $konfigurasi->is_absensi_aktif) == 0 ? 'checked' : ''}}>
          <label class="form-check-label" for="flexRadioDefault2">
            Nonaktif
          </label>
        </div>
        <small class="fst-italic text-muted">Aktifkan absensi pada hari kerja, nonaktifkan absensi pada hari libur</small>
      </div>
    </div>
    <button type="submit" class="btn btn-primary align-self-center btn-icon mt-2">
      <i class='bx bxs-save me-1'></i>
      Simpan</button>
  </form>
</div>


@endsection