@section('title', 'Lokasi Absensi')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <h4 class="mb-0">Lokasi Absensi</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <span class="text-muted">Lokasi Absensi</span>
    </div>
  </div>

  <div class="p-3 bg-white rounded-3">

    <div class="d-flex flex-row align-items-start">
      <a href="{{ route('lokasi_absensi.create') }}" class="btn btn-primary btn-icon">
        <i class='bx bx-plus me-1'></i>
        Tambah</a>
      <form action="{{ route('lokasi_absensi.index') }}" method="get" class="ms-auto">
        <div class="input-group" style="max-width: 20rem">

          <input type="text" class="form-control" placeholder="Cari...">
          <button type="submit" class="input-group-text">
            <i class='bx bx-search-alt-2'></i>
          </button>
        </div>

      </form>
    </div>
    <div class="mt-2 text-end">
      Showing {{ $lokasi_absensi->firstItem() }} to {{ $lokasi_absensi->lastItem() }} of {{ $lokasi_absensi->total() }} data
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
          @foreach ($lokasi_absensi as $key => $item)
            <tr>
              <td class="text-center">{{ $lokasi_absensi->firstItem() + $key }}</td>
              <td>{{ $item->nama_lokasi }}</td>
              <td>{{ $item->created_at }}</td>
              <td>{{ $item->updated_at }}</td>
              <td class="text-nowrap">
                <a href="{{ route('lokasi_absensi.show', $item->id_lokasi_absensi) }}" class="btn btn-primary btn-icon"
                    data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Lihat Data">
                    <i class="bx bx-show fs-5"></i>
                  </a>
                <a href="{{ route('lokasi_absensi.edit', $item->id_lokasi_absensi) }}" class="btn btn-warning btn-icon"
                  data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Edit Data">
                  <i class="bx bx-edit fs-5"></i>
                </a>
                <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  onclick="setHapusModal('{{ route('lokasi_absensi.delete', $item->id_lokasi_absensi) }}')"
                  title="Hapus Data #{{ $item->id_lokasi_absensi }}" data-bs-tooltip="tooltip" data-bs-placement="top"
                  data-bs-title="Hapus Data">
                  <i class="bx bx-trash fs-5"></i>
                </button>
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
    <div>
      
      {{ $lokasi_absensi->links() }}
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
            
            <i class='bx bxs-error fs-1 text-warning mb-2'></i>
            <div class="text-center mb-2">Apakah Anda yakin akan menghapus data ini?</div>
            <div class="alert alert-danger" role="alert">
              <strong>Peringatan</strong>
              <ul class="mb-0">
                <li>Data yang dihapus tidak dapat dikembalikan</li>
                <li>Data pegawai yang memiliki lokasi absensi ini akan menjadi null/tidak diketahui</li>
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
