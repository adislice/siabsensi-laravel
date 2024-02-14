@section('title', 'Edit Jabatan')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <a href="{{ route('jabatan.index') }}" class="d-inline-flex me-2 bg-hover rounded-pill p-1">
      <i class='bx bx-left-arrow-alt fs-3'></i></a>
    <h4 class="mb-0">Edit Jabatan</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <a href="{{ route('jabatan.index') }}">Jabatan</a> /
      <span class="text-muted">Edit</span>

    </div>
  </div>
  <div class="p-4 bg-white rounded-3">

    <form action="{{ route('jabatan.update', $data_jabatan->id_jabatan) }}" method="post" class="d-flex flex-column" enctype="multipart/form-data">
      @csrf
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="nama_jabatan" class="form-label fw-medium required">Nama</label>
            <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan"
              name="nama_jabatan" placeholder="Masukkan Nama" value="{{ old('nama_jabatan', $data_jabatan->nama_jabatan) }}" required>
            @error('nama_jabatan')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          
        </div>

      </div>
      <button type="submit" class="btn btn-primary align-self-center btn-icon">
        <i class='bx bxs-save me-1'></i>
        Update</button>
    </form>
  </div>

  

@endsection
