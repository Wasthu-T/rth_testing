@extends('users.layout.main')

@section('container-user')
<!-- berhasil -->
@if(session()->has('berhasil'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('berhasil') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<h2 class="my-3 text-center">Arsip Status Permohonan</h2>
<form class="" role="search" method="get" action="/dashboard/admin/arsip">
    <div class="row g-3 align-items-center">
        <div class="col-6">
            <input value="{{ $filter[0] }}" name="query" class="form-control" type="search" placeholder="Cari NIK atau kode permohonan" aria-label="Cari NIK atau kode permohonan">
        </div>
        <div class="col-6">
            <select name="status" class="form-select" aria-label="Default select example">
                <option value="">Filter status</option>
                @if(auth()->user()->akses_lvl == 2)
                <option value="0" {{ $filter[1] == '0' ? 'selected' : '' }}>Data kurang lengkap/salah</option>
                <option value="1" {{ $filter[1] == '1' ? 'selected' : '' }}>Menunggu diproses</option>
                <option value="2" {{ $filter[1] == '2' ? 'selected' : '' }}>Sedang ditinjau</option>
                <option value="3" {{ $filter[1] == '3' ? 'selected' : '' }}>Menunggu surat rekomendasi</option>
                <option value="4.1" {{ in_array($filter[1], ['4.1', '4.2']) ? 'selected' : '' }}>Sedang dilaksanakan</option>
                <option value="4.3" {{ $filter[1] == '4.3' ? 'selected' : '' }}>Sedang dilaksanakan masyarakat</option>
                <option value="5" {{ $filter[1] == '5' ? 'selected' : '' }}>Selesai</option>
                <option value="6" {{ $filter[1] == '6' ? 'selected' : '' }}>Status jalan nasional/provinsi</option>
                @else
                <option value="4.2" {{ $filter[1] == '4.2' ? 'selected' : '' }}>Sedang dilaksanakan</option>
                <option value="5" {{ $filter[1] == '5' ? 'selected' : '' }}>Selesai</option>
                @endif

            </select>
        </div>
    </div>
    <div class="mt-3 row g-3 align-items-center">
        <div class="col-auto form-floating">
            <input type="date" name="start_date" class="form-control" id="Awal" value="{{ $filter[2] ?? '' }}">
            <label for="Awal">Awal</label>
        </div>
        <div class="col-auto form-floating">
            <input type="date" name="end_date" class="form-control" id="Akhir" value="{{ $filter[3] ?? '' }}">
            <label for="Akhir">Akhir</label>
        </div>
        <div class="col-auto">
            <select name="order_by" class="form-select">
                <option value="">Filter Terakhir di Ubah</option>
                <option value="asc" {{ $filter[4] == 'asc' ? 'selected' : '' }}>Terlama</option>
                <option value="dsc" {{ $filter[4] == 'dsc' ? 'selected' : '' }}>Terbaru</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Hapus arsip data 1 bulan</button>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade mt-5" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus arsip data yang lebih dari 1 bulan?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="/dashboard/admin/hapus" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="table-responsive">
    <div id="data-container">
        @include('users.admin.tabledatastatus', ['datas' => $datas])
    </div>
</div>

</div>
</div>
@endsection

@section('scripts')
<script src="/js/statusrekap.js"></script>
@endsection