@extends('users.layout.main')

@section('container-user')
@if(session()->has('gagal'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('gagal') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="container-fluid">
    <h2 class="text-center my-4">Form Permohonan</h2>
    <!-- Map -->
    <div id="mapkontak"></div>
    <div class="desc" id="desc"></div>
    <div class="desc1" id="desc1"></div>

    <div class="card mt-3 mb-1 d-block d-lg-none">
        <div class="card-body">
            <h5>Filter</h5>
            <button class="btn btn-primary" id="filterJln">Jalan</button>
            <button class="btn btn-success" id="filterRth">RTH</button>
            <button class="btn btn-danger" id="resetFilters">Reset</button>
        </div>
        <div class="card-body" id="info">Klik untuk menampilkan fitur</div>
    </div>
    <button id="addMarkerButton" class="btn btn-success mt-1">Klik untuk mendapatkan koordinat</button>

    <form action="/dashboard/permohonan" method="POST" enctype="multipart/form-data" id="form">
        @csrf

        <div class="form-floating mt-3">
            <input name="uuid" disabled type="text" class="form-control" id="uuid" placeholder="uuid" value="{{auth()->user()->uuid}}">
            <label for="uuid">Nomor Permohonan</label>
        </div>
        @error('uuid')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
        <div class="form-floating mt-3">
            <input name="nik" onkeypress="return /[0-9]/i.test(event.key)" type="text" class="form-control" id="nik" placeholder="nik" value="{{auth()->user()->nik}}" minlength="16" maxlength="16" pattern="\d{16}" title="Harap masukkan tepat 16 digit angka">
            <label for="nik">NIK</label>
        </div>
        @error('nik')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating mt-3">
            <input disabled type="text" class="form-control" id="lat" placeholder="lat" value="{{ old('lat') }}">
            <label for="lat">Lintang</label>
        </div>
        <input name="lat" type="hidden" id="latvalue" placeholder="lat" value="{{ old('lat') }}">
        @error('lat')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating mt-3">
            <input disabled type="text" class="form-control" id="long" placeholder="long" value="{{ old('long') }}">
            <label for="long">Bujur</label>
        </div>
        <input name="long" type="hidden" id="longvalue" placeholder="long" value="{{ old('long') }}">
        @error('long')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating mt-3">
            <input disabled type="text" class="form-control" id="loc_phnpt" placeholder="loc_phnpt" value="{{ old('loc_phnpt') }}">
            <label for="loc_phnpt">Lokasi pada peta</label>
        </div>
        <input name="loc_phnpt" type="hidden" class="form-control" id="loc_phnptvalue" placeholder="loc_phnpt" value="{{ old('loc_phnpt') }}">
        @error('loc_phnpt')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
        <div class="form-content">

            <div class="form-floating mt-3">
                <input disabled name="loc_phntts" type="text" class="check-input form-control" id="loc_phntts" placeholder="loc_phntts" value="{{ old('loc_phntts') }}">
                <label for="loc_phntts">Lokasi tertulis</label>
            </div>
            @error('loc_phntts')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
            <div class="form-floating mt-3">
                <textarea disabled name="alasan" class="check-input form-control" placeholder="Menghalangi rambu lalu lintas" id="alasan" style="height: 100px"></textarea>
                <label for="alasan">Keterangan</label>
            </div>
            <p class="fs5 text-secondary">Contoh : Menghalangi rambu lalu lintas/ Pohon tumbang/ Pemangkasan</p>

            @error('alasan')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror

            <div class="mt-3">
                <label for="ftphn" class="form-label">Foto Pohon</label>
                <input disabled name="ftphn[]" class="check-input form-control image-field" type="file" id="ftphn" accept="image/*,application/pdf" multiple>
                <p class="fw-light">*jpeg, png, pdf, maks. 2 MB</p>
            </div>
            @if ($errors->has('ftphn'))
            @foreach ($errors->get('ftphn') as $message)
            <div class="text-danger">
                {{ $message }}
            </div>
            @endforeach
            @endif

            @error('ftphn.*')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
            <div class="mt-3">
                <label for="lmrec" class="form-label">Template Lampiran Surat</label>
                <a class="text-decoration-none" href="/template/1. Surat Permohonan Pemangkasan.docx" download><br>1. Surat Permohonan Pemangkasan <i class="bi bi-download"></i></a>
                <a class="text-decoration-none" href="/template/2. Surat Permohonan Penebangan.docx" download><br>2. Surat Permohonan Penebangan <i class="bi bi-download"></i></a>
                <a class="text-decoration-none" href="/template/3. Surat Permohonan Pemanfaatan Kayu Hasil Penebangan.docx" download><br>3. Surat Permohonan Pemanfaatan Kayu Hasil Penebangan <i class="bi bi-download"></i></a>
                <a class="text-decoration-none" href="/template/5. Surat Pernyataan Kesanggupan Menanam Pohon Pengganti.docx" download><br>4. Surat Pernyataan Kesanggupan Menanam Pohon Pengganti (Khusus untuk permohonan penebangan) <i class="bi bi-download"></i></a>
                <input disabled name="lmrec[]" class="check-input form-control image-field" type="file" id="lmrec" accept="image/*,application/pdf" multiple>
                <p class="fw-light">*jpeg, png, pdf, maks. 2 MB</p>
            </div>
            @if ($errors->has('lmrec'))
            @foreach ($errors->get('lmrec') as $message)
            <div class="text-danger">
                {{ $message }}
            </div>
            @endforeach
            @endif

            @error('lmrec.*')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
            <div class="mt-3">
                <label for="ftktp" class="form-label">Foto FC KTP</label>
                <input disabled name="ftktp" class="check-input form-control image-field" type="file" accept="image/*,application/pdf" id="ftktp">
                <p class="fw-light">*jpeg, png, pdf, maks. 2 MB</p>
            </div>
            @error('ftktp')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <input type="text" hidden name="stt" id="stt" value="">
        <input type="text" hidden name="jln" id="jln" value="">
        @if ($errors->has('g-recaptcha-response'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
        @endif
        <div class="form-floating mb-3">
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
        </div>
        <button type="submit" id="Submit" class="btn btn-success my-3">Submit</button>
    </form>

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
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@1.0.15/dist/browser-image-compression.min.js"></script>
<script src="/js/geojson.js"></script>
<script src="/js/form.js"></script>
<script src="/js/form2.js"></script>
<script src="/js/compressimg.js"></script>
@endsection