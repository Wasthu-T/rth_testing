@extends('users.layout.main')

@section('container-user')


@if(session()->has('status'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('status') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session()->has('berhasil'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('berhasil') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session()->has('gagal'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('gagal') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($datas != null)


<h4 class="my-2 text-center">Daftar Permohonan</h4>
<form class="my-3" role="search" method="get" action="/dashboard">
    <div class="row g-3 align-items-center">
        <div class="col-6">
            <input value="{{ $filter[0] }}" name="query" class="form-control" type="search" placeholder="Cari kode permohonan" aria-label="Cari kode permohonan">
        </div>
        <div class="col-6">
            <select name="status" class="form-select" aria-label="Default select example">
                <option value="">Filter status</option>
                <option value="0" {{ $filter[1] == '0' ? 'selected' : '' }}>Data kurang lengkap/salah</option>
                <option value="1" {{ $filter[1] == '1' ? 'selected' : '' }}>Menunggu diproses</option>
                <option value="2" {{ $filter[1] == '2' ? 'selected' : '' }}>Sedang ditinjau</option>
                <option value="3" {{ $filter[1] == '3' ? 'selected' : '' }}>Menunggu surat rekomendasi</option>
                <option value="4.1" {{ in_array($filter[1], ['4.1', '4.2']) ? 'selected' : '' }}>Sedang dilaksanakan</option>
                <option value="4.3" {{ $filter[1] == '4.3' ? 'selected' : '' }}>Sedang dilaksanakan mandiri</option>
                <option value="5" {{ $filter[1] == '5' ? 'selected' : '' }}>Selesai</option>
                <option value="6" {{ $filter[1] == '6' ? 'selected' : '' }}>Status jalan nasional/provinsi</option>
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
    </div>
</form>

@include('users.user.tabledatastatus', ['datas' => $datas])

@else
<div class="alert alert-danger mt-3" role="alert">
    <h5 class="alert-heading">Kamu belum pernah menambahkan permohonan</h5>
    <p><a href="/dashboard/permohonan" class="alert-link">Tambah permohonan</a></p>

</div>
@endif



@endsection