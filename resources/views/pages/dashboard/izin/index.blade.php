@section('title', 'Pengajuan Izin')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <h4 class="mb-0">Pengajuan Izin</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <span class="text-muted">Pengajuan Izin</span>
    </div>
  </div>

  <div class="p-3 bg-white rounded-3">

    <div class="d-flex flex-row align-items-start">
      {{-- <a href="{{ route('izin.create') }}" class="btn btn-primary btn-icon">
        <i class='bx bx-plus me-1'></i>
        Tambah</a> --}}
      <form action="{{ route('izin.index') }}" method="get" class="ms-auto">
        <div class="input-group" style="max-width: 20rem">

          <input type="text" class="form-control" placeholder="Cari...">
          <button type="submit" class="input-group-text">
            <i class='bx bx-search-alt-2'></i>
          </button>
        </div>

      </form>
    </div>
    <div class="mt-2 text-end">
      Showing {{ $daftar_izin->firstItem() ?? 0 }} to {{ $daftar_izin->lastItem() ?? 0 }} of {{ $daftar_izin->total() }} data
    </div>
    <div class="table-responsive">

      <table class="table table-bordered table-hover my-2">
        <thead>
          <tr class="">
            <th scope="col" class="text-center">No.</th>
            <th scope="col" class="text-center" style="min-width: 200px">Nama</th>
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">Alasan</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="align-middle">
          @foreach ($daftar_izin as $key => $item)
            <tr>
              <td class="text-center">{{ $daftar_izin->firstItem() + $key }}</td>
              <td>{{ $item->pegawai->nama_pegawai }}</td>
              <td>{{ $item->tanggal }}</td>
              <td>{{ $item->alasan }}</td>
              <td class="text-center">
                @if ($item->status == 'pending')
                  <span class="badge bg-warning rounded-pill">Pending</span>
                @elseif ($item->status == 'disetujui')
                  <span class="badge bg-success rounded-pill">Disetujui</span>
                @elseif ($item->status == 'ditolak')
                  <span class="badge bg-danger rounded-pill">Ditolak</span>
                @else
                  <span class="badge bg-secondary rounded-pill">Tidak Diketahui</span>
                @endif
              </td>
              <td class="text-nowrap">
                <a href="{{ route('izin.show', $item->id_izin) }}" class="btn btn-primary btn-icon"
                    data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Lihat Data">
                    <i class="bx bx-show fs-5"></i>
                  </a>
                <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  onclick="setHapusModal('{{ route('izin.delete', $item->id_izin) }}')"
                  title="Hapus Data #{{ $item->id_izin }}" data-bs-tooltip="tooltip" data-bs-placement="top"
                  data-bs-title="Hapus Data">
                  <i class="bx bx-trash fs-5"></i>
                </button>
            </tr>
          @endforeach

          @if ($daftar_izin->count() == 0)
            <tr>
              <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
          @endif

        </tbody>
      </table>
    </div>
    <div>
      
      {{ $daftar_izin->links() }}
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
                <li>Data pegawai yang memiliki pengajuan izin ini akan menjadi null/tidak diketahui</li>
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
