@php
  $selected_pegawai = request()->get('id_pegawai');
  $selected_tanggal = request()->get('tanggal');
@endphp
@section('title', 'Tambah Absensi')

@extends('layouts.admin_layout')

@section('content')
<div class="d-flex mt-2 mb-3 align-items-center">
  <a href="{{ route('absensi.index') }}" class="d-inline-flex me-2 bg-hover rounded-pill p-1">
    <i class='bx bx-left-arrow-alt fs-3'></i></a>
  <h4 class="mb-0">Tambah Absensi</h4>
  <div class="ms-auto">
    <a href="{{ route('dashboard') }}">Home</a> /
    <a href="{{ route('absensi.index') }}">Absensi</a> /
    <span class="text-muted">Tambah</span>

  </div>
</div>
<div class="p-4 bg-white rounded-3">

  <form action="{{ route('absensi.store') }}" method="post" class="d-flex flex-column" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="mb-3">
          <label for="id_pegawai" class="form-label fw-medium required">Pegawai</label>
          <select class="form-select @error('id_pegawai') is-invalid @enderror" id="id_pegawai" name="id_pegawai"
            required>
            <option value="">Pilih</option>
            @foreach ($daftar_pegawai as $item)
            <option value="{{ $item->id_pegawai }}" {{ old('id_pegawai', $selected_pegawai)==$item->id_pegawai ? 'selected' : '' }}>{{
              $item->nama_pegawai }}</option>
            @endforeach
          </select>
          @error('id_pegawai')
          <small class="text-danger">{{ $message }}</small>
          @enderror

        </div>
        <div class="mb-3">
          <label for="tanggal" class="form-label fw-medium required">Tanggal</label>
          <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal"
            placeholder="Masukkan Nama" value="{{ old('tanggal', ($selected_tanggal ?? date('Y-m-d'))) }}" required>
          @error('tanggal')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label for="status" class="form-label fw-medium required">Status Kehadiran</label>
          <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            <option value="">Pilih</option>
            <option value="hadir">Hadir</option>
            <option value="cuti">Cuti</option>
            <option value="izin">Izin</option>
            <option value="alfa">Alfa</option>
          </select>
          @error('status')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

      </div>

    </div>
    <div class="mb-2 row justify-content-center">
      <div class="col-lg-6"><span class="text-danger">*</span>) Wajib diisi</div>
    </div>
    <button type="submit" class="btn btn-primary align-self-center btn-icon">
      <i class='bx bxs-save me-1'></i>
      Simpan</button>
  </form>
</div>

<script>
  $('#form-foto').change(function() {
      const file = this.files[0];
      console.log(file);
      if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
          console.log(event.target.result);
          $('#foto-preview').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
        reader.onloadend = function() {
          $('#foto-preview').removeClass('d-none');
        }
      }
    });
</script>

@endsection