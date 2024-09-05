@extends('users.layout.main')

@section('container-user')
@php
$today = \Carbon\Carbon::now()->format('Y-m-d');
@endphp

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
    <div class="card mt-3 mb-1 d-block d-lg-none">
        <div class="card-body">
            <h5>Filter</h5>
            <button class="btn btn-primary" id="filterJln">Jalan</button>
            <button class="btn btn-success" id="filterRth">RTH</button>
            <button class="btn btn-danger" id="resetFilters">Reset</button>
        </div>
        <div class="card-body" id="info">Klik untuk menampilkan fitur</div>
    </div>
    @if($data->status == 0 || $data->status == 1)
    <button id="addMarkerButton" class="btn btn-success mt-1">Klik untuk mendapatkan koordinat</button>
    @endif

    <form action="/dashboard/{{$data->slug}}/edit" method="POST" enctype="multipart/form-data" id="form">

        @csrf
        <div class="form-floating mt-3">
            <input name="uuid" disabled type="text" class="form-control" id="uuid" placeholder="uuid" value="{{auth()->user()->uuid}}">
            <label for="uuid">Nomor Identitas</label>
        </div>
        @error('uuid')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
        <div class="form-floating mt-3">
            <input name="nik" type="text" class="form-control" id="nik" placeholder="nik" value="{{$data->nik}}" minlength="16" maxlength="16" pattern="\d{16}" title="Harap masukkan tepat 16 digit angka" {{ $data->status === "4.3" ? 'disabled' : '' }} >
            <label for="nik">NIK</label>
        </div>
        @error('nik')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating mt-3">
            <input disabled type="text" class="form-control" id="lat" placeholder="lat" value="{{ $data->lat }}">
            <label for="lat">lat</label>
        </div>
        <input name="lat" type="hidden" id="latvalue" placeholder="lat" value="{{ $data->lat }}">
        @error('lat')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating mt-3">
            <input disabled type="text" class="form-control" id="long" placeholder="long" value="{{ $data->long }}">
            <label for="long">long</label>
        </div>
        <input name="long" type="hidden" id="longvalue" placeholder="long" value="{{ $data->long }}">
        @error('long')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating mt-3">
            <input disabled type="text" class="form-control" id="loc_phnpt" placeholder="loc_phnpt" value="{{ $data->loc_phnpt }}">
            <label for="loc_phnpt">Lokasi pada peta</label>
        </div>
        <input name="loc_phnpt" type="hidden" class="form-control" id="loc_phnptvalue" placeholder="loc_phnpt" value="{{ $data->loc_phnpt }}">
        @error('loc_phnpt')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        @if($data->status == 0 || $data->status == 1)
        <div class="form-floating mt-3">
            <input name="loc_phntts" type="text" class="form-control" id="loc_phntts" placeholder="loc_phntts" value="{{ $data->loc_phntts }}">
            <label for="loc_phntts">Lokasi tertulis</label>
        </div>
        @error('loc_phntts')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
        <div class="overflow-auto mt-3" style="max-height: 400px;">
            <!-- Foto RTH -->
            <div class="fotorth card-body">
                <h5>
                    Foto RTH : <span class="text-secondary fs-6">Klik Foto untuk mengganti</span>
                </h5>
                @error('fotos')
                <div class="text-danger">
                    foto rth : {{ $message }}
                </div>
                @enderror
                <div class="fotoContainer row gap-3 mx-3 justify-content-between" id="fotoContainer">
                    @foreach($fotos as $key => $foto)
                    @php
                    $fileExtension = pathinfo(asset('/' . $foto->ftphn), PATHINFO_EXTENSION);
                    @endphp
                    <div class="card col-12 col-md-4 col-lg-3">
                        <div class="" style="height: 150px; overflow:hidden;">
                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']))
                            <img src="{{ asset('/' . $foto->ftphn) }}" class="img-thumbnail foto" alt="fotorth" style="cursor: pointer;" data-index="{{ $key }}">
                            @elseif($fileExtension === 'pdf')
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf="{{ asset('/' . $foto->ftphn) }}" type="button" data-index="{{ $key }}><i class=" bi bi-file-earmark-pdf-fill"></i>Lihat Pdf</button>
                            @endif
                            <input accept="image/*,application/pdf" name="fotos[]" type="file" class="selectedPhotos image-field" style="display: none;" data-index="{{ $key }}">
                        </div>
                        <div class="card-text my-2">
                            <button class="btn btn-danger btn-delete btn-delete1 w-100" type="button" data-index-del="{{ $key }}">Hapus</button>
                            <input type="hidden" name="deleted_photos[]" class="deletedPhotoIndex" value="{{ $key }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <h5 class="mt-3">Tambah foto rth</h5>
                @error('addfotos.*')
                <div class="text-danger">
                    addfotos : {{ $message }}
                </div>
                @enderror
                <input accept="image/*,application/pdf" type="file" id="addfotos" name="addfotos[]" class="form-control my-2 image-field" multiple>
                <p class="fw-light">*jpeg, png, pdf 2mb</p>

            </div>

            <!-- Lampiran Rekomendasi Kapanewon -->
            <div class="fotorth card-body">
                <h5>
                    Lampiran Rekomendasi Kapanewon : <span class="text-secondary fs-6">Klik Foto untuk mengganti</span>
                </h5>
                @error('lmrecs')
                <div class="text-danger">
                    foto rth : {{ $message }}
                </div>
                @enderror
                <div class="fotoContainer row gap-3 mx-3 justify-content-between" id="fotoContainer1">
                    @foreach($lmrecs as $key1 => $lmrec)
                    @php
                    $fileExtension = pathinfo(asset('/' . $lmrec->lmrec), PATHINFO_EXTENSION);
                    @endphp
                    <div class="card col-12 col-md-4 col-lg-3">
                        <div class="" style="height: 150px; overflow:hidden;">
                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']))
                            <img src="{{ asset('/' . $lmrec->lmrec) }}" class="img-thumbnail lmrec" alt="lmrec" style="cursor: pointer;" data-index1="{{ $key1 }}">
                            @elseif($fileExtension === 'pdf')
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf="{{ asset('/' . $lmrec->lmrec) }}" type="button" data-index1="{{ $key1 }}"><i class="bi bi-file-earmark-pdf-fill"></i>Lihat Pdf</button>
                            @endif
                            <input name="lmrecs[]" type="file" class="selectedlmrecs image-field" style="display: none;" data-index1="{{ $key1 }}">
                        </div>
                        <div class="card-text my-2">
                            <button class="btn btn-danger btn-delete btn-delete2 w-100" type="button" data-index-del1="{{ $key1 }}">Hapus</button>
                            <input type="hidden" name="deleted_lmrecs[]" class="deletedlmrecsIndex" value="{{ $key1 }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <h5 class="mt-3">Tambah Lampiran Rekomendasi Kapanewon</h5>
                @error('addlmrec.*')
                <div class="text-danger">
                    addfotos : {{ $message }}
                </div>
                @enderror
                <input type="file" id="addlmrec" name="addlmrec[]" class="form-control my-2 image-field" multiple>
                <p class="fw-light">*jpeg, png, pdf 2mb</p>

            </div>

            <!-- Foto KTP -->
            <div class="card-body">
                <h5 class="mt-3">
                    Foto KTP : <span class="text-secondary fs-6">Klik Foto untuk mengganti. </span>
                </h5>
                <p class="fw-light">*jpeg, png, pdf 2mb</p>
                @error('ftktp')
                <div class="text-danger">
                    fotoktp : {{ $message }}
                </div>
                @enderror
                @php
                $fileExtension = pathinfo(asset('/' . $data->ftktp), PATHINFO_EXTENSION);
                @endphp
                <input type="file" id="selectedPhotoktp" class="image-field" name="ftktp" value="{{$fotoktp}}" style="display: none;">
                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']))
                <img id="fotoktp" style="cursor: pointer; display: block;" src="{{asset('/'.$fotoktp) }}" class="img-thumbnail d-inline-flex" alt="fotoktp" width="30%">
                <div id="pdfContainer" class="card col-12 col-md-4 col-lg-3" style="display: none;">
                    <div class="" style="height: 150px; overflow:hidden;">
                        <button id="showpdf" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf="{{ asset('/' . $data->ftktp) }}" type="button"><i class="bi bi-file-earmark-pdf-fill"></i>Lihat Pdf</button>
                        <button type="button" id="editPdfBtn" class="btn btn-warning w-100 mt-2">Edit</button>
                    </div>
                </div>
                @elseif($fileExtension === 'pdf')
                <div id="pdfContainer" class="card col-12 col-md-4 col-lg-3">
                    <div class="" style="height: 150px; overflow:hidden;">
                        <button id="showpdf" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf="{{ asset('/' . $data->ftktp) }}" type="button"><i class="bi bi-file-earmark-pdf-fill"></i>Lihat Pdf</button>
                        <button type="button" id="editPdfBtn" class="btn btn-warning w-100 mt-2">Edit</button>
                    </div>
                </div>
                <img id="fotoktp" style="display: none; cursor: pointer;" class="img-thumbnail" alt="fotoktp" width="30%" />
                @endif
            </div>

        </div>

        <div class="form-floating mt-3">
            <textarea name="alasan" class="form-control" placeholder="Alasan Perizinan" id="alasan" style="height: 100px">{{ $data->alasan }}</textarea>
            <label for="alasan">Keterangan</label>
        </div>
        @error('alasan')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        @elseif($data->status == 4.3)
        <div class="form-floating mt-3">
            <input type="date" class="form-control" max="{{$today}}" min="{{$data->created_at->format('Y-m-d')}}" id="tgl_pelaksanaan" placeholder="yyyy-mm-dd" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan') }}">
            <label for="tgl_pelaksanaan">Pelaksanaan</label>
        </div>

        @error('tgl_pelaksanaan')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="mt-3">
            <label for="pelaksanaan" class="form-label">Foto Pelaksanaan</label>
            <input name="pelaksanaan[]" class="form-control image-field" type="file" id="pelaksanaan" multiple accept="image/*,application/pdf">
        </div>
        <div id="preview-images" class="mt-3"></div>

        @if ($errors->has('pelaksanaan'))
        @foreach ($errors->get('pelaksanaan') as $message)
        <div class="text-danger">
            {{ $message }}
        </div>
        @endforeach
        @endif
        @endif
        <input type="text" hidden name="stt" id="stt">
        <button type="submit" class="btn btn-success my-3">Submit</button>
    </form>
    <div class="mb-2">
        <a href="{{ $backUrl }}">
            <button type="button" class="btn btn-outline-success">Kembali</button>
        </a>
    </div>

</div>
</div>
<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="400px" />
            </div>
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
<script src="/js/changefotos.js"></script>
<script src="/js/form.js"></script>
@if($data->status == 4.3)
<script src="/js/form3.js"></script>
@else
<script src="/js/form2.js"></script>
@endif

<script src="/js/compressimg.js"></script>
<script src="/js/showimg.js"></script>
@if($data->status != 4.3)
<script src="/js/pdfreader.js"></script>
@endif


@endsection