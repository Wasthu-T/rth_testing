@extends('users.layout.main')

@section('container-user')

<div class="card w-100 my-4">

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
    <div id="addMarkerButton"></div>
    <div class="card-body">
        <h5 class="card-title">Kode : {{$data->slug}}</h5>
        <div class="position-relative m-4">
            <div class="container mt-5">
                @php
                $progressWidth = 0;
                $step1Color = 'btn-secondary';
                $step2Color = 'btn-secondary';
                $step3Color = 'btn-secondary';
                $step4Color = 'btn-secondary';
                $step5Color = 'btn-secondary';
                $step6Color = 'btn-secondary';
                $progresscolor = 'bg-danger';

                switch($data->status) {
                case 0:
                $progressWidth = 0;
                $step1Color = 'btn-danger';
                $progresscolor = 'bg-danger';
                break;
                case 1:
                $progressWidth = 20;
                $step1Color = 'btn-danger';
                $step2Color = 'btn-danger';
                $progresscolor = 'bg-danger';
                break;
                case 2:
                $progressWidth = 40;
                $step1Color = 'btn-primary';
                $step2Color = 'btn-primary';
                $step3Color = 'btn-primary';
                $progresscolor = 'bg-primary';
                break;
                case 3:
                $progressWidth = 60;
                $step1Color = 'btn-primary';
                $step2Color = 'btn-primary';
                $step3Color = 'btn-primary';
                $step4Color = 'btn-primary';
                $progresscolor = 'bg-primary';
                break;
                case 4.1:
                case 4.2:
                case 4.3:
                $progressWidth = 80;
                $step1Color = 'btn-primary';
                $step2Color = 'btn-primary';
                $step3Color = 'btn-primary';
                $step4Color = 'btn-primary';
                $step5Color = 'btn-primary';
                $progresscolor = 'bg-primary';
                break;
                case 5:
                $progressWidth = 100;
                $step1Color = 'btn-success';
                $step2Color = 'btn-success';
                $step3Color = 'btn-success';
                $step4Color = 'btn-success';
                $step5Color = 'btn-success';
                $step6Color = 'btn-success';
                $progresscolor = 'bg-success';
                break;
                case 6:
                $progressWidth = 100;
                $step1Color = 'btn-primary';
                $step2Color = 'btn-primary';
                $step3Color = 'btn-primary';
                $step4Color = 'btn-primary';
                $step5Color = 'btn-primary';
                $step6Color = 'btn-primary';
                $progresscolor = 'bg-primary';
                break;
                default:
                $progressWidth = 0;
                break;
                }
                @endphp

                @php
                $today = \Carbon\Carbon::now()->format('Y-m-d');
                @endphp
                <div class="position-relative m-4">
                    <div class="progress" role="progressbar" aria-label="Progress" aria-valuenow="{{ $progressWidth }}" aria-valuemin="0" aria-valuemax="100" style="height: 1px;">
                        <div class="progress-bar {{ $progresscolor }}" id="progress-bar" style="width: {{ $progressWidth }}%;"></div>
                    </div>
                    <button type="button" data-bs-trigger="hover focus" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Data kurang lengkap/salah" class="position-absolute top-0 start-0 translate-middle btn btn-sm rounded-pill {{ $step1Color }}" style="width: 2rem; height:2rem;">1</button>
                    <button type="button" data-bs-trigger="hover focus" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Menunggu diproses" class="position-absolute top-0 start-20 translate-middle btn btn-sm rounded-pill {{ $step2Color }}" style="width: 2rem; height:2rem;">2</button>
                    <button type="button" data-bs-trigger="hover focus" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Sedang ditinjau" class="position-absolute top-0 start-40 translate-middle btn btn-sm rounded-pill {{ $step3Color }}" style="width: 2rem; height:2rem;">3</button>
                    <button type="button" data-bs-trigger="hover focus" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Menunggu surat rekomendasi" class="position-absolute top-0 start-60 translate-middle btn btn-sm rounded-pill {{ $step4Color }}" style="width: 2rem; height:2rem;">4</button>
                    <button type="button" data-bs-trigger="hover focus" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Sedang dilaksanakan" class="position-absolute top-0 start-80 translate-middle btn btn-sm rounded-pill {{ $step5Color }}" style="width: 2rem; height:2rem;">5</button>
                    <button type="button" data-bs-trigger="hover focus" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Selesai" class="position-absolute top-0 start-100 translate-middle btn btn-sm rounded-pill {{ $step6Color }}" style="width: 2rem; height:2rem;">6</button>
                </div>

            </div>
        </div>
        @if($data->status == 0)
        <h5 class="text-danger">Data kurang lengkap/salah</h5>
        @elseif($data->status == 1)
        <h5 class="text-danger">Menunggu diproses</h5>
        @elseif($data->status == 2)
        <h5 class="text-primary">Sedang diditinjau</h5>
        @elseif($data->status == 3)
        <h5 class="text-primary">Menunggu surat rekomendasi</h5>
        @elseif($data->status == 4.1 || $data->status == 4.2 || $data->status == 4.3)
        <h5 class="text-primary">Sedang dilaksanakan</h5>
        @elseif($data->status == 5)
        <h5 class="text-success">Selesai</h5>
        @elseif($data->status == 6)
        <h5 class="text-primary">Status jalan {{$data->istansi}}</h5>
        <p class="text-danger">Tidak dapat dilanjuti dikarenakan jalan {{$data->istansi}}</p>
        @else
        <h5 class="text-danger">Error silahkan menghubungi admin</h5>
        @endif

        <form action="/dashboard/admin/{{$data->slug}}/update" id="form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mt-3">
                <input disabled type="text" class="form-control" id="nik" placeholder="nik" value="{{$data->nik}}">
                <label for="nik">NIK</label>
            </div>
            <input name="nik" type="hidden" id="nikvalue" placeholder="nik" value="{{$data->nik}}">
            <input name="slug" type="hidden" id="slugvalue" placeholder="slug" value="{{$data->slug}}">

            @error('nik')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror

            <div class="form-floating mt-3">
                <input disabled type="text" class="form-control" id="lat" placeholder="lat" value="{{$data->lat}}">
                <label for="lat">Lintang</label>
            </div>
            <input name="lat" type="hidden" id="latvalue" placeholder="lat" value="{{$data->lat}}">
            @error('lat')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror

            <div class="form-floating mt-3">
                <input disabled type="text" class="form-control" id="long" placeholder="long" value="{{$data->long}}">
                <label for="long">Bujur</label>
            </div>
            <input name="long" type="hidden" id="longvalue" placeholder="long" value="{{$data->long}}">
            @error('long')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror

            <div class="form-floating mt-3">
                <input disabled type="text" class="form-control" id="loc_phnpt" placeholder="loc_phnpt" value="{{$data->loc_phnpt}}">
                <label for="loc_phnpt">Lokasi pada peta</label>
            </div>
            <input name="loc_phnpt" type="hidden" class="form-control" id="loc_phnptvalue" placeholder="loc_phnpt" value="{{$data->loc_phnpt}}">
            @error('loc_phnpt')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror

            @if($data->status == 0 || $data->status == 1)
            <select name="status" id="status" class="form-select my-3" aria-label="Default select example">
                <option value="" selected>Apakah data sudah lengkap?</option>
                <option value="1">Survei Lapangan</option>
                <option value="2">Data Tidak Lengkap</option>
            </select>

            <div id="status-1"></div>
            @error('status')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror

            <button type="submit" class="btn btn-success my-3">Submit</button>
            @elseif($data->status == 2)
            <div class="form-floating mt-3">
                <input type="date" class="form-control tanggal" max="{{$today}}" min="{{$today}}" id="tgl_survei" placeholder="mm-dd-yyyy" name="tgl_survei" value="{{$today}}" readonly>
                <label for="tgl_survei">Tanggal survei</label>
            </div>
            @error('tgl_survei')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror

            <div class="form-floating mt-3">
                <input type="text" class="form-control" id="hasil" placeholder="hasil" name="hasil" value="{{ old('hasil') }}">
                <label for="hasil">Hasil survei</label>
            </div>
            @error('hasil')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror



            <div class="mt-3">
                <label for="ftsurvei" class="form-label">Foto survei lapangan</label>
                <input name="ftsurvei[]" class="form-control image-field" type="file" id="ftsurvei" multiple accept="image/*,application/pdf">
            </div>
            <div id="preview-images" class="mt-3"></div>
            @if ($errors->has('ftsurvei'))
            @foreach ($errors->get('ftsurvei') as $message)
            <div class="text-danger">
                {{ $message }}
            </div>
            @endforeach
            @endif

            <button type="submit" class="btn btn-success my-3">Submit</button>
            @elseif($data->status == 3)
            <div class="mt-3">
                <label for="recrth" class="form-label">Rekomendasi</label>
                <input name="recrth[]" class="form-control image-field" type="file" id="recrth" multiple accept="image/*,application/pdf">
            </div>
            <div id="preview-images" class="mt-3"></div>
            @if ($errors->has('recrth'))
            @foreach ($errors->get('recrth') as $message)
            <div class="text-danger">
                {{ $message }}
            </div>
            @endforeach
            @endif

            <div class="form-floating mt-3">
                <select class="form-control" id="istansi" name="istansi" onchange="toggleOtherField()">
                    <option value="UPTDKPP" {{ old('istansi') == 'UPTDKPP' ? 'selected' : '' }}>UPTDKPP</option>
                    <option value="masyarakat" {{ old('istansi') == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                    <option value="other" {{ old('istansi') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <label for="istansi">Pelaksana</label>
            </div>

            <div class="form-floating mt-3" id="other-istansi-field" style="display: none;">
                <input type="text" class="form-control" id="other_istansi" placeholder="Pelaksana Lainnya" name="other_istansi" value="{{ old('other_istansi') }}">
                <label for="other_istansi">Pelaksana Lainnya</label>
            </div>
            @error('istansi')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror


            <button type="submit" class="btn btn-success my-3">Submit</button>
            @elseif($data->status == 4.1 || $data->status == 4.2 || $data->status == 4.3)
            <div class="form-floating mt-3">
                <input type="date" class="form-control tanggal" max="{{$today}}" min="{{$today}}" id="tgl_pelaksanaan" placeholder="dd-MM-yyyy" name="tgl_pelaksanaan" value="{{$today}}" readonly>
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


            <button type="submit" class="btn btn-success my-3">Submit</button>
            @else
            <h5 class="text-success">Status selesai</h5>
            @endif

        </form>

        <div id="admin-status" data-is-admin="{{ auth()->user()->admin }}"></div>
        @if(auth()->user()->admin == 1)
        <div id="admin-lat" data-lat="{{$data->lat}}"></div>
        <div id="admin-long" data-long="{{$data->long}}"></div>
        @endif

    </div>

    <div class="mb-3 justify-content-between d-flex">
        <div class="">
            <a href="/{{ $backUrl }}" class="mx-3 mb-2">
                <button type="button" class="btn btn-outline-success">Kembali</button>
            </a>
        </div>

    </div>

</div>
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
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/geojson.js"></script>
<script src="/js/form.js"></script>
<script src="/js/form3.js"></script>
<script src="/js/cekstt.js"></script>
<script src="/js/compressimg.js"></script>
<script src="/js/showimg.js"></script>
<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
</script>
@endsection