@section('title', 'Detail Cuti')

@extends('layouts.admin_layout')

@section('content')
<div class="d-flex mt-2 mb-3 align-items-center">
  <a href="{{ route('cuti.index') }}" class="d-inline-flex me-2 bg-hover rounded-pill p-1">
    <i class='bx bx-left-arrow-alt fs-3'></i></a>
  <h4 class="mb-0">Detail Cuti</h4>
  <div class="ms-auto">
    <a href="{{ route('dashboard') }}">Home</a> /
    <a href="{{ route('cuti.index') }}">Cuti</a> /
    <span class="text-muted">Detail</span>

  </div>
</div>
<div class="p-5 bg-white rounded-3">

  <div class="row">
    <div class="col-lg-6">
      <div class="mb-4">
        <div class="fw-bold">Pegawai</div>
        <div>{{ $cuti->pegawai->nama_pegawai }}</div>
        <div>{{ $cuti->pegawai->nip }}</div>
      </div>

      <div class="mb-4">
        <div class="fw-bold">Tanggal Mulai</div>
        <div>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d F Y') }}</div>
      </div>
      <div class="mb-4">
        <div class="fw-bold">Tanggal Selesai</div>
        <div>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d F Y') }}</div>
      </div>

      <div class="mb-4">
        <div class="fw-bold">Alasan</div>
        <div>{{ $cuti->alasan }}</div>
      </div>

    </div>

    <div class="col-lg-6">
      <div class="mb-4">
        <div class="fw-bold">Dokumen Terlampir</div>
        <div>
          <div class="card">
            <div class="card-body d-flex align-items-center">
              <i class='bx bxs-file-pdf fs-1'></i>
              <div class="d-flex flex-column ms-2">
                <a href="{{ url($cuti->lampiran) }}" target="_blank">Lihat Dokumen</a>
                <small class="text-muted">{{ \App\Utils\Helper::fileSize($cuti->lampiran) }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <div class="fw-bold">Status</div>
        <div>
          @if ($cuti->status == 'pending')
          <span class="badge bg-warning rounded-pill">Pending</span>
          @elseif ($cuti->status == 'disetujui')
          <span class="badge bg-success rounded-pill">Disetujui</span>
          @elseif ($cuti->status == 'ditolak')
          <span class="badge bg-danger rounded-pill">Ditolak</span>
          @else
          <span class="badge bg-secondary rounded-pill">Tidak Diketahui</span>
          @endif
        </div>
      </div>
    </div>
    <div class="col-lg-4 mx-auto">
      <div class="d-flex gap-2">
        @if ($cuti->status == 'pending')
        <button type="submit" class="btn btn-success btn-icon flex-1" data-bs-toggle="modal"
          data-bs-target="#acceptModal">Setujui</button>
        <button type="submit" class="btn btn-danger btn-icon flex-1" data-bs-toggle="modal"
          data-bs-target="#rejectModal">Tolak</button>
        @endif
        @if ($cuti->status == 'ditolak')
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
    <form action="{{ route('cuti.update_status', $cuti->id_cuti) }}" method="post" enctype="multipart/form-data">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Setujui Cuti</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Silahkan lakukan review pada berkas lampiran pengajuan cuti, lalu tambahkan tanda tangan atau cap instansi yang menandakan pengajuan cuti telah disetujui.</p>
        <div class="fw-bold">Upload Lampiran Yang Telah Disetujui</div>
        <div>
          <input type="file" class="form-control" name="lampiran_disetujui" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" name="status" value="disetujui">Setujui</button>
      </div>
    </div>
    </form>
  </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModal" aria-hidden="true">
 <form action="{{ route('cuti.update_status', $cuti->id_cuti) }}" method="post">
      @csrf
  <div class="modal-dialog modal-dialog-centered">
    
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Setujui Cuti</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column align-items-center">

          <i class='bx bxs-error fs-1 text-warning mb-2'></i>
          <div class="text-center mb-2">Apakah Anda yakin ingin menolak cuti ini?</div>

        </div>
        <div>
          <textarea class="form-control" name="alasan_ditolak" placeholder="Alasan Menolak"  required>{{ old('alasan_ditolak') }}</textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        
          <button type="submit" class="btn btn-primary" name="status" value="ditolak">Tolak</button>
        
      </div>
    </div>
  
  </div>
  </form>
</div>


@endsection