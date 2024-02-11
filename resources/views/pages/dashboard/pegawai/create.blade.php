@section('title', 'Tambah Pegawai')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <a href="{{ route('pegawai.index') }}">
      <i data-lucide="chevron-left" class="me-2" lucide-size="26"></i></a>
    <h4 class="mb-0">Tambah Pegawai</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <a href="{{ route('pegawai.index') }}">Pegawai</a> /
      <span class="text-muted">Tambah</span>

    </div>
  </div>
  <div class="p-4 bg-white rounded-3">

    {{-- alert error --}}
    @if (session('alert-error'))
      <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
        <i class='bx bxs-error flex-shrink-0 me-2'></i>
        <div>
          <strong>Error! </strong>
          {{ session('alert-error') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form action="{{ route('pegawai.store') }}" method="post" class="d-flex flex-column" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-lg-6">
          <div class="mb-3">
            <label for="nama_pegawai" class="form-label fw-medium required">Nama</label>
            <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai"
              name="nama_pegawai" placeholder="Masukkan Nama" value="{{ old('nama_pegawai') }}" required>
            @error('nama_pegawai')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="nip" class="form-label fw-medium required">Nomor Induk Pegawai</label>
            <input type="number" step="any" class="form-control @error('nip') is-invalid @enderror" id="nip"
              name="nip" placeholder="Masukkan NIP" value="{{ old('nip') }}" required>
            @error('nip')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="jenis_kelamin" class="form-label fw-medium required">Jenis Kelamin</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkLk" value="laki-laki"
                {{ old('jenis_kelamin') == 'laki-laki' ? 'checked' : '' }} required
                {{ old('jenis_kelamin') == 'laki-laki' ? 'checked' : '' }}>
              <label class="form-check-label" for="jkLk">
                Laki-laki
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkP" value="perempuan"
                {{ old('jenis_kelamin') == 'perempuan' ? 'checked' : '' }} required
                {{ old('jenis_kelamin') == 'perempuan' ? 'checked' : '' }}>
              <label class="form-check-label" for="jkP">
                Perempuan
              </label>
            </div>

            @error('jenis_kelamin')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="tempat_lahir" class="form-label fw-medium required">Tempat Lahir</label>
            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir"
              name="tempat_lahir" placeholder="Masukkan Tempat Lahir" required value="{{ old('tempat_lahir') }}">
            @error('tempat_lahir')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="tanggal_lahir" class="form-label fw-medium required">Tanggal Lahir</label>
            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir"
              name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir" required value="{{ old('tanggal_lahir') }}">
            @error('tanggal_lahir')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="id_jabatan" class="form-label fw-medium required">Jabatan</label>
            <select class="form-select @error('id_jabatan') is-invalid @enderror" id="id_jabatan" name="id_jabatan"
              required>
              <option disabled selected>Pilih Jabatan</option>
              @foreach ($data_jabatan as $item)
                <option value="{{ $item->id_jabatan }}" {{ old('id_jabatan') == $item->id_jabatan ? 'selected' : '' }}>
                  {{ $item->nama_jabatan }}</option>
              @endforeach
            </select>
            @error('id_jabatan')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label fw-medium required">Alamat</label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
              placeholder="Masukkan Alamat" required>{{ old('alamat') }}</textarea>
            @error('alamat')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="col-lg-6">

          <div class="mb-3">
            <label for="no_telp" class="form-label fw-medium required">Nomor Telepon</label>
            <input type="number" step="any" class="form-control @error('no_telp') is-invalid @enderror"
              id="no_telp" name="no_telp" placeholder="Masukkan Nomor Telepon" required
              value="{{ old('no_telp') }}">
            @error('no_telp')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="form-foto" class="form-label fw-medium">Foto</label>
            <input type="file" class="form-control mb-1 @error('foto') is-invalid @enderror" id="form-foto"
              name="foto">
            @error('foto')
              <div class="text-danger">
                <small>{{ $message }}</small>
              </div>
            @enderror

            <div class="row">
              <div class="col-8">
                <img id="foto-preview"
                  src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt="Foto Karyawan"
                  class="object-fit-cover img-fluid rounded-pill" style="width: 12rem; height: 12rem">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label fw-medium required">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
              <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="mb-3">
            <label for="form-password" class="form-label fw-medium required">Password</label>
            <div class="d-flex position-relative">
              <input type="password" class="form-control" id="form-password" name="password"
                placeholder="Masukkan password" value="{{ old('password') }}" required>
              <i class='bx bx-show fs-5 password-toggle'></i>
            </div>
            @error('password')
              <div class="text-danger">
                <small>{{ $message }}</small>
              </div>
            @enderror
            <small class="text-muted">Password harus berisi kombinasi huruf dan angka, tanpa spasi, dan minimal 6
              karakter.</small>
          </div>
        </div>

      </div>
      <button type="submit" class="btn btn-primary align-self-center btn-icon">
        <i class='bx bxs-save me-1'></i>
        Submit</button>
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
