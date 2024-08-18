@section('title', 'Pegawai')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <h4 class="mb-0">Pegawai</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <span class="text-muted">Pegawai</span>
    </div>
  </div>

  <div class="p-3 bg-white rounded-3">

    <div class="d-flex flex-row align-items-start">
      <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-icon">
        <i class='bx bx-plus me-1'></i>
        Tambah</a>
      <form action="{{ route('pegawai.index') }}" method="get" class="ms-auto">
        <div class="input-group" style="max-width: 20rem">

          <input type="text" class="form-control" placeholder="Cari...">
          <button type="submit" class="input-group-text">
            <i class='bx bx-search-alt-2'></i>
          </button>
        </div>

      </form>
    </div>
    <div class="mt-2 text-end">
      Showing {{ $all_pegawai->firstItem() }} to {{ $all_pegawai->lastItem() }} of {{ $all_pegawai->total() }} data
    </div>
    <div class="table-responsive-sm">

      <table class="table table-bordered table-hover my-2">
        <thead>
          <tr class="">
            <th scope="col" class="text-center sticky-header">No.</th>
            <th scope="col" class="text-center sticky-header">Foto</th>
            <th scope="col" class="text-center sticky-header" style="min-width: 200px">Nama</th>
            <th scope="col" class="text-center sticky-header">NIP</th>
            <th scope="col" class="text-center sticky-header">Jabatan</th>
            <th scope="col" class="text-center sticky-header">Status</th>
            <th scope="col" class="text-center sticky-header">Aksi</th>
          </tr>
        </thead>
        <tbody class="align-middle">
          @foreach ($all_pegawai as $item)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td class="text-center"><img src="{{ $item->foto ? url($item->foto) : '/user-avatar.jpg' }}"
                  alt="Foto {{ $item->nama_pegawai }}" width="40px" height="40px" class="rounded-pill"></td>
              <td>{{ $item->nama_pegawai }}</td>
              <td>{{ $item->nip }}</td>
              <td>{{ $item->jabatan->nama_jabatan }}</td>
              <td>
                <span
                  class="d-inline-flex p-1 {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }} border border-light rounded-circle">
                </span>
                <span
                  class="{{ $item->status == 'aktif' ? 'text-success' : 'text-danger' }}">{{ ucfirst($item->status) }}</span>
              </td>
              <td class="text-nowrap">
                <a href="{{ route('pegawai.show', $item->id_pegawai) }}" class="btn btn-primary btn-icon">
                  <i class="bx bx-show fs-5"></i>
                </a>
                <a href="{{ route('pegawai.edit', $item->id_pegawai) }}" class="btn btn-warning btn-icon">
                  <i class="bx bx-edit fs-5"></i>
                </a>
                <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  onclick="setHapusModal('{{ route('pegawai.delete', $item->id_pegawai) }}')"
                  title="Hapus Data #{{ $item->id_pegawai }}">
                  <i class="bx bx-trash fs-5"></i>
                </button>
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
    <div class="justify-content-end d-flex">
      {{ $all_pegawai->links() }}
    </div>
  </div>

  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteModalLabel">Hapus Data?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column align-items-center">
            <i class="fas fa-exclamation-triangle fs-1 text-warning mb-3"></i>
            <div class="text-center">Apakah Anda yakin akan menghapus data ini?</div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <form id="formHapusAction" action="/" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Delete Modal
    function setHapusModal(url) {
      $('#formHapusAction').attr('action', url);
    }
  </script>

@endsection
