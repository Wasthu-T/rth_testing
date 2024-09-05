var map = L.map('mapkontak');
var isAdmin = document.getElementById('admin-status').getAttribute('data-is-admin');
let latitudeElement = document.getElementById('admin-lat');

function success(position) {
    let latitude = position.coords.latitude;
    let longitude = position.coords.longitude;
    return {
        latitude,
        longitude
    }
}

function Handlingerror(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            errorMessage = "Anda telah menolak untuk memberikan izin akses lokasi.";
            return errorMessage
        case error.POSITION_UNAVAILABLE:
            errorMessage = "Informasi lokasi tidak tersedia.";
            return errorMessage
        case error.TIMEOUT:
            errorMessage = "Waktu permintaan habis saat mencoba mendapatkan lokasi.";
            return errorMessage
        case error.UNKNOWN_ERROR:
            errorMessage = "Terjadi kesalahan yang tidak diketahui saat mencoba mendapatkan lokasi.";
            return errorMessage
        default:
            errorMessage = "Terjadi kesalahan saat mencoba mendapatkan lokasi.";
            return errorMessage
    }
}

if (isAdmin == "1") {
    if (latitudeElement !== null) {
        let latitude = document.getElementById('admin-lat').getAttribute('data-lat');
        let longitude = document.getElementById('admin-long').getAttribute('data-long');
        map.setView([latitude, longitude], 15);
    }else {
        map.setView([-7.9047546993039886, 110.34757789999962], 15);
    }
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
} else {
    if (!navigator.geolocation) {
        status.textContent = "Geolocation tidak disupport oleh browser anda.";

    } else {
        const getLocation = new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject);
        });


        getLocation.then(position => {
            let coor = success(position);
            let latitude = coor.latitude;
            let longitude = coor.longitude;

            map.setView([latitude, longitude], 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

        }).catch(error => {
            let err = Handlingerror(error)
            alert(err + " Menyesuaikan koordinat di pusat RTH.");
            map.setView([-7.9047546993039886, 110.34757789999962], 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        });
    }
}


var officeicon = L.icon({
    iconUrl: '/img/office.png',
    iconSize: [18, 20], // size of the icon
    iconAnchor: [5, 10], // point of the icon which will correspond to marker's location
});
function updateIconSizeAndAnchor(zoom, icon) {
    let iconSize1, iconAnchor1;

    if (zoom > 15) {
        iconSize1= [18, 20];
        iconAnchor1= [5, 12]; 
    } else if (zoom === 15){
        iconSize1= [18, 20];
        iconAnchor1 = [4,16]
    }else if ((zoom >= 12) && (zoom < 15)) {
        iconSize1 = [10, 12]; // ukuran ikon sedang
        iconAnchor1 = [6, 12]; // anchor ikon sedang
    } else if(zoom <= 12){
        iconSize1 = [4, 7]; // ukuran ikon kecil
        iconAnchor1 = [1,2]; // anchor ikon kecil
    } 
    icon.options.iconSize = iconSize1;
    icon.options.iconAnchor = iconAnchor1;

}

kantor = L.marker([-7.9047546993039886, 110.34757789999962], {
    icon: officeicon
}).addTo(map).bindPopup("Ini adalah lokasi kantor.", {
    offset: [0, -20], // Menggeser popup ke atas agar terlihat di atas marker
    autoClose: false, // Menghindari penutupan otomatis popup saat membuka popup lain
    autoPan: true // Mengaktifkan auto-panning (memindahkan peta jika popup di luar tampilan)
});
map.on('zoomend', function() {
    updateIconSizeAndAnchor(map.getZoom(),officeicon);
    kantor.setIcon(officeicon);
});
