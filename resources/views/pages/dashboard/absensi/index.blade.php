@section('title', 'Absensi')

@extends('layouts.admin_layout')

@section('content')
  <div class="d-flex mt-2 mb-3 align-items-center">
    <h4 class="mb-0">Absensi</h4>
    <div class="ms-auto">
      <a href="{{ route('dashboard') }}">Home</a> /
      <span class="text-muted">Absensi</span>
    </div>
  </div>

  <div class="p-3 bg-white rounded-3">
    <div class="d-flex flex-row align-items-start gap-1 mb-3">
        <div class="align-self-center fw-medium fs-5">
          Data Absensi Tanggal {{ \Carbon\Carbon::parse($tanggal_dipilih)->translatedFormat('d F Y') }}
        </div>
      <form action="{{ route('absensi.index') }}" method="get" class="ms-auto">
        <div class="input-group" style="max-width: 20rem">
          <input type="date" class="form-control" name="tanggal" value="{{ $tanggal_dipilih }}">
          <button type="submit" class="input-group-text">
            <i class='bx bx-search'></i>
          </button>
        </div>

      </form>
    </div>
    <div class="mt-2">
      Showing {{ $data_absensi->firstItem() }} to {{ $data_absensi->lastItem() }} of {{ $data_absensi->total() }} data
    </div>
    <div class="table-responsive">

      <table class="table table-bordered table-hover my-2">
        <thead>
          <tr class="">
            <th scope="col" class="text-center">No.</th>
            <th scope="col" class="text-center" style="min-width: 200px">Nama Pegawai</th>
            <th scope="col" class="text-center">Tanggal</th>
            <th scope="col" class="text-center">Jam Masuk</th>
            <th scope="col" class="text-center">Jam Pulang</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="align-middle">
          @foreach ($data_absensi as $key => $item)
            <tr>
              <td class="text-center">{{ $data_absensi->firstItem() + $key }}</td>
              <td>{{ $item->nama_pegawai }}</td>
              <td>{{ $tanggal_dipilih }}</td>
              <td>{{ $item->jam_masuk ?? '-' }}</td>
              <td>{{ $item->jam_pulang ?? '-' }}</td>
              <td class="text-center">
                @if ($item->status == 'hadir')
                  <span class="badge bg-success rounded-pill">Hadir</span>
                @elseif($item->status == 'izin')
                  <span class="badge bg-warning rounded-pill">Izin</span>
                @elseif($item->status == 'cuti') 
                  <span class="badge bg-warning rounded-pill">Cuti</span>
                @elseif ($item->status == 'alfa')
                  <span class="badge bg-danger rounded-pill">Alfa</span>
                @elseif($item->status == null)
                  <span class="badge bg-secondary rounded-pill">Belum Absensi</span>
                @elseif($item->jam_pulang == null)
                  <span class="badge bg-secondary rounded-pill">Belum Absensi Pulang</span>
                @else
                  <span class="badge bg-secondary rounded-pill">Tidak Diketahui</span>
                @endif
              </td>
              <td class="text-nowrap">

                @if ($item->status)
                  {{-- <a href="{{ route('absensi.edit', $item->id_absensi ?? '') }}" class="btn btn-warning btn-icon"
                    data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Edit Data">
                    <i class="bx bx-edit fs-5"></i>
                  </a> --}}
                  <div class="dropdown" title="Ubah Absensi">
                    <button class="btn btn-warning dropdown-toggle btn-icon hide-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-edit fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><div class="dropdown-header">Ubah Status Absensi : </div></li>
                      <form action="{{ route('absensi.update', $item->id_absensi ?? '') }}" method="post">
                        <input type="hidden" name="tanggal" value="{{ $tanggal_dipilih }}">
                        @csrf
                      <li><button type="submit" name="status" value="hadir" class="dropdown-item">Hadir</button></li>
                      <li><button type="submit" name="status" value="alfa" class="dropdown-item">Alfa</button></li>
                      <li><button type="submit" name="status" value="izin" class="dropdown-item">Izin</button></li>
                      <li><button type="submit" name="status" value="cuti" class="dropdown-item">Cuti</button></li>
                    </form>
                    </ul>
                  </div>
                @elseif ($item->status == null)
                {{-- <a href="{{ route('absensi.create') }}?id_pegawai={{ $item->id_pegawai }}&tanggal={{ $tanggal_dipilih }}" class="btn btn-success btn-icon"
                  data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Tambah Data">
                  <i class="bx bx-plus fs-5"></i>
                </a> --}}
                <div class="dropdown d-inline" data-bs-tooltip="tooltip" data-bs-placement="top"
                data-bs-title="Tambah Absensi">
                  <button class="btn btn-primary dropdown-toggle btn-icon hide-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                  >
                    <i class="bx bx-plus fs-5"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><div class="dropdown-header">Tambah Absensi : </div></li>
                    <form action="{{ route('absensi.store') }}?id_pegawai={{ $item->id_pegawai }}&tanggal={{ $tanggal_dipilih }}" method="post">
                      @csrf
                    <li><button type="submit" name="status" value="hadir" class="dropdown-item">Hadir</button></li>
                    <li><button type="submit" name="status" value="alfa" class="dropdown-item">Alfa</button></li>
                    <li><button type="submit" name="status" value="izin" class="dropdown-item">Izin</button></li>
                    <li><button type="submit" name="status" value="cuti" class="dropdown-item">Cuti</button></li>
                  </form>
                  </ul>
                </div>

                @endif

                
                <!-- <button type="button" class="btn btn-danger btn-icon" data-bs-toggle="modal"
                  data-bs-target="#deleteModal"
                  onclick="setHapusModal('{{ route('absensi.delete', $item->id_absensi ?? '') }}')"
                  title="Hapus Data #{{ $item->id_absensi }}" data-bs-tooltip="tooltip" data-bs-placement="top"
                  data-bs-title="Hapus Data">
                  <i class="bx bx-trash fs-5"></i>
                </button> -->
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
    <div>

      {{ $data_absensi->withQueryString()->links() }}
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
                <li>Data pegawai yang memiliki absensi ini akan menjadi null/tidak diketahui</li>
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
