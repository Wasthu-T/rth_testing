// form
var clickedLayer = null;
let lathtml = document.getElementById('lat');
let lathtmlvalue = document.getElementById('latvalue');
let longhtml = document.getElementById('long');
let longhtmlvalue = document.getElementById('longvalue');
let lokasihtml = document.getElementById('loc_phnpt');
let lokasihtmlvalue = document.getElementById('loc_phnptvalue');

var addMarkerButton = document.getElementById('addMarkerButton');

var existingMarker = null;
var existingRoad = null;
if (lathtml.value && lathtmlvalue.value && longhtml.value && longhtmlvalue.value) {
    existingMarker = L.marker([lathtml.value, longhtml.value]).addTo(map);
    var string = lokasihtmlvalue.value;
    var parts = string.split(",");
    var kode = parts[0].trim();
    existingRoad = kode;
}

function toggleOtherField() {
    var selectElement = document.getElementById('istansi');
    var otherField = document.getElementById('other-istansi-field');
    if (selectElement && otherField) {
        if (selectElement.value === 'other') {
            otherField.style.display = 'block';
        } else {
            otherField.style.display = 'none';
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    toggleOtherField();
});
document.addEventListener('DOMContentLoaded', (event) => {
    const form = document.getElementById('form');
    const submitButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', (event) => {
        submitButton.disabled = true;
        submitButton.textContent = 'Sedang dikirim...';
    });
});

if (addMarkerButton) {

    addMarkerButton.addEventListener('click', function () {
        if (existingMarker) {
            existingMarker.remove();
        }
        alert('Klik di peta untuk menambahkan marker.');

        map.on('click', function (e) {
            // Dapatkan koordinat klik
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Buat marker baru dan tambahkan ke peta
            var newMarker = L.marker([lat, lng]).addTo(map);

            // Tampilkan popup pada marker dengan koordinat
            var popupContent =
                "<br>Lintang : " + lat +
                "<br>Bujur : " + lng;

            newMarker.bindPopup(popupContent).openPopup();

            lathtml.value = lat;
            lathtmlvalue.value = lat;
            longhtml.value = lng;
            longhtmlvalue.value = lng;
            existingMarker = newMarker;
            // Hapus event listener klik pada peta setelah menambahkan marker
            map.off('click');
        });
    });
};

