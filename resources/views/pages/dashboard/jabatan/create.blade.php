@section('title', 'Tambah Jabatan')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <a href="{{ route('jabatan.index') }}" class="d-inline-flex me-2 bg-hover rounded-pill p-1">
      <i class='bx bx-left-arrow-alt fs-3'></i></a>
    <h4 class="mb-0">Tambah Jabatan</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <a href="{{ route('jabatan.index') }}">Jabatan</a> /
      <span class="text-muted">Tambah</span>

    </div>
  </div>
  <div class="p-4 bg-white rounded-3">

    <form action="{{ route('jabatan.store') }}" method="post" class="d-flex flex-column" enctype="multipart/form-data">
      @csrf
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="nama_jabatan" class="form-label fw-medium required">Nama</label>
            <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan"
              name="nama_jabatan" placeholder="Masukkan Nama" value="{{ old('nama_jabatan') }}" required>
            @error('nama_jabatan')
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
