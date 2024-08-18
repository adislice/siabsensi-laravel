@section('title', 'Pengajuan Cuti')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <h4 class="mb-0">Pengajuan Cuti</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <span class="text-muted">Pengajuan Cuti</span>
    </div>
  </div>

  <div class="p-3 bg-white rounded-3">

    <div class="d-flex flex-row align-items-start">
      {{-- <a href="{{ route('cuti.create') }}" class="btn btn-primary btn-icon">
        <i class='bx bx-plus me-1'></i>
        Tambah</a> --}}
      <form action="{{ route('cuti.index') }}" method="get" class="ms-auto">
        <div class="input-group" style="max-width: 20rem">

          <input type="text" class="form-control" placeholder="Cari...">
          <button type="submit" class="input-group-text">
            <i class='bx bx-search-alt-2'></i>
          </button>
        </div>

      </form>
    </div>
    <div class="mt-2 text-end">
      Showing {{ $daftar_cuti->firstItem() ?? 0 }} to {{ $daftar_cuti->lastItem() ?? 0 }} of {{ $daftar_cuti->total() }} data
    </div>
    <div class="table-responsive">

      <table class="table table-bordered table-hover my-2">
        <thead>
          <tr class="">
            <th scope="col" class="text-center">No.</th>
            <th scope="col" class="text-center" style="min-width: 150px">Nama</th>
            <th scope="col" class="text-center">Tanggal Mulai</th>
            <th scope="col" class="text-center">Tanggal Selesai</th>
            <th scope="col" class="text-center">Alasan</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="align-middle">
          @foreach ($daftar_cuti as $key => $item)
            <tr>
              <td class="text-center">{{ $daftar_cuti->firstItem() + $key }}</td>
              <td>{{ $item->pegawai->nama_pegawai }}</td>
              <td>{{ \Carbon\Carbon::parse($item->pegawai->tanggal_mulai)->translatedFormat('d F Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($item->pegawai->tanggal_selesai)->translatedFormat('d F Y') }}</td>
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
                <a href="{{ route('cuti.show', $item->id_cuti) }}" class="btn btn-primary btn-icon"
                    data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Lihat Data">
                    <i class="bx bx-show fs-5"></i>
                  </a>
                
                <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  onclick="setHapusUrl('{{ route('cuti.delete', $item->id_cuti) }}')"
                  title="Hapus Data #{{ $item->id_cuti }}" data-bs-tooltip="tooltip" data-bs-placement="top"
                  data-bs-title="Hapus Data">
                  <i class="bx bx-trash fs-5"></i>
                </button>
            </tr>
          @endforeach

          @if ($daftar_cuti->count() == 0)
            <tr>
              <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
          @endif

        </tbody>
      </table>
    </div>
    <div>
      
      {{ $daftar_cuti->links() }}
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
            <div class="text-center">Data yang dihapus tidak dapat dikembalikan.</div>
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
    function setHapusUrl(url) {
      $('#formHapusAction').attr('action', url);
    }
  </script>

@endsection
