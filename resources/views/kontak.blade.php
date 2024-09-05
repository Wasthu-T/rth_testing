@extends('layout.main')

@section('container')

<style>
    #mapkontak {
        height: 50vh;
    }
</style>
<div class="content"></div>
<div class="container">
    <div class="shadow card border-success mb-3">
        <div class="card-header bg-transparent border-success">
            <h3>Kontak</h3>
        </div>
        <div class="card-body ">
            <div id="mapkontak"></div>
        </div>
        <div class="card-body ">
            <div class="d-flex">
                <div class="p-2 flex-shrink-1">

                    <i class="icon bi bi-geo-alt"></i>
                </div>
                <div class="p-2 w-100">

                    <h5 class="card-title">Alamat</h5>
                    <p class="card-text">Dinas Lingkungan Hidup Kabupaten Bantul</br>
                        Komplek II Kantor Pemerintah Kabupaten Bantul</br>
                        Jl Lingkar Timur, Manding, Bantul, Daerah Istimewa Yogyakarta
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="d-flex">
                <div class="p-2 flex-shrink-1">

                    <i class="icon bi bi-envelope"></i>
                </div>
                <div class="p-2 w-100">
                    <h5 class="card-title">Email</h5>
                    <p class="card-text">dlh@bantulkab.go.id</p>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="d-flex">
                <div class="p-2 flex-shrink-1">
                    <i class="icon bi bi-telephone"></i>
                </div>
                <div class="p-2 w-100">
                    <h5 class="card-title">Phone</h5>
                    <p class="card-text">0274-6460181</p>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="d-flex">
                <div class="p-2 flex-shrink-1">
                    <a href="https://wa.me/+62895364399009"><i class="icon bi bi-whatsapp"></i></a>
                </div>

                <div class="p-2 w-100">

                    <h5 class="card-title">Whatsapp</h5>
                    <p class="card-text">+62 895-3643-99009</p>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="d-flex">
                <div class="p-2 flex-shrink-1">
                    <a href="https://www.instagram.com/dinaslhbantul/"><i class="icon bi bi-instagram"></i></a>
                </div>

                <div class="p-2 w-100">

                    <h5 class="card-title">Instagram</h5>
                    <p class="card-text">dinaslhbantul</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    var officeicon = L.icon({
        iconUrl: '/img/office.png',
        iconSize: [30, 30], // size of the icon
        iconAnchor: [24, 28], // point of the icon which will correspond to marker's location
    });

    function updateIconSizeAndAnchor(zoom, icon) {
        let iconSize1, iconAnchor1;


        if (zoom >= 15) {
            iconSize1 = [30, 30];
            iconAnchor1 = [24, 28];
        } else if ((zoom >= 12) && (zoom < 15)) {
            iconSize1 = [20, 22];
            iconAnchor1 = [15, 24];
        } else {
            iconSize1 = [15, 18];
            iconAnchor1 = [10, 18];
        }
        console.log(zoom);
        icon.options.iconSize = iconSize1;
        icon.options.iconAnchor = iconAnchor1;

    }

    var map = L.map('mapkontak').setView([-7.9049566101842075, 110.34789976507143], 15);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var popup = L.popup()
        .setLatLng([-7.9049566101842075, 110.34789976507143])
        .setContent('<p>Dinas Lingkungan Hidup</p><a href="https://maps.app.goo.gl/1WfyRTZRPEte1CY77">Lihat Google Maps</a>');

    kantor = L.marker([-7.9049566101842075, 110.34789976507143], {
        icon: officeicon
    }).addTo(map).bindPopup(popup);
    map.on('zoomend', function() {
        updateIconSizeAndAnchor(map.getZoom(), officeicon);
        kantor.setIcon(officeicon);
    });
</script>
@endsection