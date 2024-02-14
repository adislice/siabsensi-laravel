@section('title', 'Jabatan')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <h4 class="mb-0">Jabatan</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <span class="text-muted">Jabatan</span>
    </div>
  </div>

  <div class="p-3 bg-white rounded-3">

    <div class="d-flex flex-row align-items-start">
      <a href="{{ route('jabatan.create') }}" class="btn btn-primary btn-icon">
        <i data-lucide="plus" lucide-size="18"></i>
        Tambah</a>
      <form action="{{ route('jabatan.index') }}" method="get" class="ms-auto">
        <div class="input-group" style="max-width: 20rem">

          <input type="text" class="form-control" placeholder="Cari...">
          <button type="submit" class="input-group-text">
            <i data-lucide="search" lucide-size="18"></i>
          </button>
        </div>

      </form>
    </div>
    <div class="mt-2 text-end">
      Showing {{ $data_jabatan->firstItem() }} to {{ $data_jabatan->lastItem() }} of {{ $data_jabatan->total() }} data
    </div>
    <div class="table-responsive">

      <table class="table table-bordered table-hover my-2">
        <thead>
          <tr class="">
            <th scope="col" class="text-center">No.</th>
            <th scope="col" class="text-center" style="min-width: 200px">Nama</th>
            <th scope="col" class="text-center">Tgl. Dibuat</th>
            <th scope="col" class="text-center">Tgl. Diubah</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="align-middle">
          @foreach ($data_jabatan as $key => $item)
            <tr>
              <td class="text-center">{{ $data_jabatan->firstItem() + $key }}</td>
              <td>{{ $item->nama_jabatan }}</td>
              <td>{{ $item->created_at }}</td>
              <td>{{ $item->updated_at }}</td>
              <td class="text-nowrap">

                <a href="{{ route('jabatan.edit', $item->id_jabatan) }}" class="btn btn-secondary btn-icon"
                  data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Edit Data">
                  <i class="bx bx-edit fs-5"></i>
                </a>
                <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  onclick="setHapusModal('{{ route('jabatan.delete', $item->id_jabatan) }}')"
                  title="Hapus Data #{{ $item->id_jabatan }}" data-bs-tooltip="tooltip" data-bs-placement="top"
                  data-bs-title="Hapus Data">
                  <i class="bx bx-trash fs-5"></i>
                </button>
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
    <div>
      
      {{ $data_jabatan->links() }}
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
            <div class="text-center mb-2">Apakah Anda yakin akan menghapus data ini?</div>
            <div class="alert alert-danger" role="alert">
              <strong>Peringatan</strong>
              <ul class="mb-0">
                <li>Data yang dihapus tidak dapat dikembalikan</li>
                <li>Data pegawai yang memiliki jabatan ini akan menjadi null/tidak diketahui</li>
              </ul>
            </div>
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
