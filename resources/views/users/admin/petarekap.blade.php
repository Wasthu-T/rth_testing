@extends('users.layout.main')

@section('container-user')

<h2 class="my-3 text-center">Rekapitulasi RTH</h2>
<div id="mapkontak"></div>
<div class="card mt-3 mb-1 d-block d-lg-none">
    <div class="card-body">
        <h5>Filter</h5>
        <button class="btn btn-primary" id="filterJln">Jalan</button>
        <button class="btn btn-success" id="filterRth">RTH</button>
        <button class="btn btn-danger" id="resetFilters">Reset</button>
    </div>
    <div class="card-body" id="info">Klik untuk menampilkan fitur</div>
</div>
<div class="table-responsive mt-3">
    <div id="data-container">
        <table class="table" id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>kd_ruas</th>
                    <th>Lintang</th>
                    <th>Bujur</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Pelaporan</th>
                    <th>Survei</th>
                    <th>Selesai</th>
                    <th>Rekomendasi</th>
                    <th>Pelaksanaan</th>
                    <th>Pelaksana</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col">
        <div id="totaldata" class="text-secondary"></div>
    </div>
    <div class="col">
        <div id="paginate" class="my-3 pagination justify-content-end"></div>
    </div>
</div>
</div>

@if(auth()->user())
<div id="admin-status" data-is-admin="{{ auth()->user()->admin }}"></div>
@else
<div id="admin-status" data-is-admin=""></div>
@endif
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/geojson.js"></script>
<script src="/js/rekapitulasi.js"></script>
@endsection