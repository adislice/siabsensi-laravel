@section('title', 'Detail Izin')

@extends('layouts.admin_layout')

@section('content')
<div class="d-flex mt-2 mb-3 align-items-center">
  <a href="{{ route('izin.index') }}" class="d-inline-flex me-2 bg-hover rounded-pill p-1">
    <i class='bx bx-left-arrow-alt fs-3'></i></a>
  <h4 class="mb-0">Detail Izin</h4>
  <div class="ms-auto">
    <a href="{{ route('dashboard') }}">Home</a> /
    <a href="{{ route('izin.index') }}">Izin</a> /
    <span class="text-muted">Detail</span>

  </div>
</div>
<div class="p-5 bg-white rounded-3">

  <div class="row">
    <div class="col-lg-6">
      <div class="mb-4">
        <div class="fw-bold">Pegawai</div>
        <div>{{ $izin->pegawai->nama_pegawai }}</div>
        <div>{{ $izin->pegawai->nip }}</div>
      </div>

      <div class="mb-4">
        <div class="fw-bold">Tanggal</div>
        <div>{{ $izin->tanggal }}</div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="mb-4">
        <div class="fw-bold">Alasan</div>
        <div>{{ $izin->alasan }}</div>
      </div>
      <div class="mb-4">
        <div class="fw-bold">Status</div>
        <div>
          @if ($izin->status == 'pending')
          <span class="badge bg-warning rounded-pill">Pending</span>
          @elseif ($izin->status == 'disetujui')
          <span class="badge bg-success rounded-pill">Disetujui</span>
          @elseif ($izin->status == 'ditolak')
          <span class="badge bg-danger rounded-pill">Ditolak</span>
          @else
          <span class="badge bg-secondary rounded-pill">Tidak Diketahui</span>
          @endif
        </div>
      </div>
    </div>
    <div class="col-lg-4 mx-auto">
      <div class="d-flex gap-2">
        @if ($izin->status == 'pending')
        <button type="submit" class="btn btn-success btn-icon flex-1"
        data-bs-toggle="modal" data-bs-target="#acceptModal">Setujui</button>
        <button type="submit" class="btn btn-danger btn-icon flex-1"
        data-bs-toggle="modal" data-bs-target="#rejectModal">Tolak</button>
        @endif
        @if ($izin->status == 'ditolak')
        <button type="submit" class="btn btn-danger btn-icon flex-1">
          <i class='bx bx-trash'></i> Hapus
        </button>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Setujui Izin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column align-items-center">
          
          <i class='bx bxs-error fs-1 text-warning mb-2'></i>
          <div class="text-center mb-2">Apakah Anda yakin ingin menyetujui izin ini?</div>
          
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form action="{{ route('izin.update_status', $izin->id_izin) }}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary" name="status" value="disetujui">Setujui</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Setujui Izin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column align-items-center">
          
          <i class='bx bxs-error fs-1 text-warning mb-2'></i>
          <div class="text-center mb-2">Apakah Anda yakin ingin menolak izin ini?</div>
          
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form action="{{ route('izin.update_status', $izin->id_izin) }}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary" name="status" value="ditolak">Tolak</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection