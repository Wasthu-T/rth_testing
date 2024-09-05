@extends('users.layout.main')

@section('container-user')
<h2 class="my-3 text-center">Rekapitulasi RTH</h2>
<div class="mt-3 row g-3 align-items-center">
    <div class="col-lg-6 col-12">
        <select name="tgl" id="tgl" class="form-select">
            <option value="">Pilih Jenis</option>
            <option value="created_at">Tanggal buat</option>
            <option value="tgl_survei">Tanggal survei</option>
            <option value="tgl_pelaksanaan">Tanggal pelaksanaan</option>
        </select>
    </div>
    <div class="col-lg-6 col-12">
        <select name="tahun" id="tahun" class="form-select">
            <option value="">Pilih Tahun</option>
            @php
            $currentYear = date('Y');
            $startYear = 2024;
            @endphp
            @for ($year = $startYear; $year <= $currentYear; $year++) <option value="{{ $year }}">{{ $year }}</option>
                @endfor
        </select>
    </div>
</div>


<div id="statistik" class="my-3">
    <div id="columnchartContainer" style="height: 300px; width: 100%;"></div>
    <div class="row">
        <div class="col-md-6" id="instansichartContainer" style="height: 200px;"></div>
        <div class="col-md-6" id="failedchartContainer" style="height: 200px;"></div>
    </div>
</div>
<div class="container my-5">
    <div class="table-responsive">
        <div id="data-container">
            @include('users.admin.tabledata', ['data1' => $data1])
        </div>
    </div>
</div>

</div>
</div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="/js/datarekap.js"></script>
@endsection