@extends('layout.main')

@section('container')
<style>

</style>
<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 1" class=""></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 2" class=""></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3" aria-label="Slide 3" class=""></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="4" aria-label="Slide 4" class=""></button>
    </div>
    <div class="carousel-inner bg-secondary align-middle">
        <div class="carousel-item active">
            <div class="row h-100 m-0">
                <div class="col-lg-7 p-0">
                    <img src="/img/fotorth/DLH.png" alt="Taman Bermain Anak Manunggal" class="d-block img-fluid mx-auto carousel-image">
                </div>
                <div class="col-lg-5 d-flex align-items-center justify-content-center">
                    <div class="card bg-success bg-gradient bg-opacity-75 w-100">
                        <div class="card-body text-start">
                            <h4 class="text-white">Sistem Pelaporan(SIMPEL) RTH</h4>
                            <p class="text-white fs-5">Hanya melayani wilayah perkotaan di Kabupaten Bantul yang meliputi empat Kapanewon, yaitu: Kapanewon Bantul, Sewon, Kasihan dan Banguntapan.</p>
                            <a href="/profil" class="btn btn-light link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="#">
                                Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="carousel-item">
            <img src="/img/fotorth/Foto1.jpg" alt="Taman Bermain Anak Manunggal" class="d-block img-fluid mx-auto carousel-image">
            <div class="container">
                <div class="carousel-caption text-start carousel-caption-bottom-left">
                    <h3>Taman Bermain Anak Manunggal</h3>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/img/fotorth/Foto2.jpg" alt="RBRA Masjid Agung Bantul" class="d-block img-fluid mx-auto carousel-image">
            <div class="container">
                <div class="carousel-caption text-start carousel-caption-bottom-left">
                    <h3>RBRA Masjid Agung Bantul</h3>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/img/fotorth/Bundaran Srandakan.png" alt="Bundaran Srandakan" class="d-block img-fluid mx-auto carousel-image">
            <div class="container">
                <div class="carousel-caption text-start carousel-caption-bottom-left">
                    <h3>Bundaran Srandakan</h3>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/img/fotorth/Taman Milenial.png" alt="Taman Milenial" class="d-block img-fluid mx-auto carousel-image">
            <div class="container">
                <div class="carousel-caption text-start carousel-caption-bottom-left">
                    <h3>Taman Milenial</h3>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<hr class="featurette-divider">

<div class="mt-3">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-7  ">
                <h2>Selamat Datang di Sistem Pelaporan (SIMPEL) RTH</h2>
                <div style="text-align: justify;">
                    <p>Salah satu jenis RTH di Kabupaten Bantul yang menjadi tanggungjawab
                        ketugasan Dinas Lingkungan Hidup adalah jalur hijau jalan, berupa jalur yang
                        penempatan tanaman serta elemen lansekap lainnya terletak di dalam ruang milik
                        jalan (RUMIJA) maupun di dalam ruang pengawasan jalan (RUWASJA) yang berada di
                        ruas jalan kabupaten.
                    </p>
                    <p>
                        Dalam era teknologi informasi saat ini, kebutuhan akan ketepatan dan kecepatan
                        memperoleh informasi sangatlah penting. Informasi mengenai keberadaan dan kondisi
                        ruang terbuka hijau (RTH) yang akurat sangat diperlukan dalam rangka proses
                        monitoring dan evaluasi, serta percepatan pelayanan kepada masyarakat. Sehingga
                        penyampaian informasi mengenai kondisi ruang terbuka hijau secara mudah, cepat,
                        dan akurat oleh masyarakat sangat diperlukan. Untuk menunjang hal tersebut, perlu
                        disusun aplikasi sistem pelaporan RTH di Kabupaten Bantul.
                    </p>
                </div>
            </div>
            <div class="col-md-auto ">

            </div>
            <div class="col col-lg-3 text-center d-none d-md-block">
                <img src="/img/logo/simpel-rth-light-removebg-preview (1).png" alt="logo_rth" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<hr class="featurette-divider">

<div class="container my-5">
    <h2 class="text-center">INFORMASI RTH</h2>
</div>
<div id="mapkontak"></div>
<div class="desc" id="desc"></div>

<div class="card mt-3 mb-1 d-block d-lg-none">
    <div class="card-body">
        <h5>Filter</h5>
        <button class="btn btn-primary filterJln" id="filterJln">Jalan</button>
        <button class="btn btn-success filterRth" id="filterRth">RTH</button>
        <button class="btn btn-danger resetFilters" id="resetFilters">Reset</button>
    </div>
    <div class="card-body" id="info">Klik untuk menampilkan fitur</div>
</div>


<hr>

@if(auth()->user())
<div id="admin-status" data-is-admin="{{ auth()->user()->admin }}"></div>
@else
<div id="admin-status" data-is-admin=""></div>
@endif

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/geojson.js"></script>
<script src="/js/beranda.js"></script>

@endsection