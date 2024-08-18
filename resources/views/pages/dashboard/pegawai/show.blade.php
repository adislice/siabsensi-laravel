@section('title', 'Detail Pegawai')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <a href="{{ route('pegawai.index') }}" class="d-inline-flex me-2 bg-hover rounded-pill p-1">
      <i class='bx bx-left-arrow-alt fs-3'></i></a>
    <h4 class="mb-0">Detail Pegawai</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <a href="{{ route('pegawai.index') }}">Pegawai</a> /
      <span class="text-muted">Detail</span>

    </div>
  </div>
  <div class="p-5 bg-white rounded-3">
  
    <div class="row">
        <div class="col-lg-6">
          <div class="mb-4">
            <img src="{{ $pegawai->foto ? url($pegawai->foto) : '/user-avatar.jpg' }}" class="object-fit-cover " style="width:12rem;height:12rem;">
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Nama</div>
            <div>{{ $pegawai->nama_pegawai }}</div>
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Nomor Induk Pegawai</div>
            <div>{{ $pegawai->nip }}</div>
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Jenis Kelamin</div>
            <div>{{ $pegawai->jenis_kelamin }}</div>
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Tempat Lahir</div>
            <div>{{ $pegawai->tempat_lahir }}</div>
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Tanggal Lahir</div>
            <div>{{ $pegawai->tanggal_lahir }}</div>
          </div>
          
          
        </div>
        <div class="col-lg-6">
          <div class="mb-4">
            <div class="fw-semibold">Jabatan</div>
            <div>{{ $pegawai->jabatan->nama_jabatan }}</div>
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Alamat</div>
            <div>{{ $pegawai->alamat }}</div>
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Nomor Telepon</div>
            <div>{{ $pegawai->no_telp }}</div>
          </div>
          <div class="mb-4">
            <div class="fw-semibold">Status</div>
            <div>
              @if ($pegawai->status == 'aktif')
              <span class="d-inline-flex p-1 bg-success border border-light rounded-circle">
              </span>
              <span class="text-success">{{ ucfirst($pegawai->status) }}</span>
              @elseif($pegawai->status == 'nonaktif')

              <span class="d-inline-flex p-1 bg-danger border border-light rounded-circle">
              </span>
              <span class="text-danger">{{ ucfirst($pegawai->status) }}</span>

              @endif
              
            </div>
          </div>
        </div>
      </div>
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
        // reader.onloadend = function() {
        //   $('#foto-preview').removeClass('d-none');
        // }
      }
    });

    
  </script>

@endsection
