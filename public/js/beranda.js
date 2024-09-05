function getDataFromCacheOrServer(route) {
    var cacheKey = 'geojson_' + route;
    var url = '/api/geojson/data/' + route; // Ubah URL sesuai kebutuhan

    // Mengambil sumber daya dari cache
    return caches.open('geojson-cache').then(function (cache) {
        return cache.match(cacheKey).then(function (response) {
            // Jika sumber daya ada di cache, kembalikan respons dari cache
            if (response) {
                return response.json();
            }

            // Jika sumber daya tidak ada di cache, ambil dari server
            return fetch(url).then(function (networkResponse) {
                // Simpan sumber daya di cache untuk penggunaan selanjutnya
                cache.put(cacheKey, networkResponse.clone());
                return networkResponse.json();
            });
        });
    });
}

$.when(
    getDataFromCacheOrServer('kabupaten'),
    getDataFromCacheOrServer('rth'),
    getDataFromCacheOrServer('jln')
).done(function (geojsonKabupaten, geojsonRth, geojsonJln) {
    // Menyimpan layer GeoJSON untuk referensi
    var kabupatenLayer, rthLayer, jlnLayer, lastClickedLayer, previousMarker;
    var markerGroup = L.layerGroup().addTo(map);
    var smallIcon = L.icon({
        iconUrl: '/img/tree-icon.png', // URL gambar ikon
        iconSize: [18, 20], // size of the icon
        iconAnchor: [5, 10], // point of the icon which will correspond to marker's location
    });
    // Fungsi untuk menambahkan layer GeoJSON ke peta dengan filter dan style
    function addGeoJSONLayer(data, style, existingLayer) {
        if (existingLayer) {
            map.removeLayer(existingLayer);
        }
        return L.geoJSON(data, {
            style: style,
            onEachFeature: function (feature, layer) {
                layer.on('click', function (e) {
                    if (lastClickedLayer) {
                        lastClickedLayer.setStyle({
                            color: lastClickedLayer.feature.originalColor,
                        });
                    }

                    if (previousMarker) {
                        map.removeLayer(previousMarker);
                    }
                    if (feature.properties.Latitude && feature.properties.Longitude) {
                        var newMarker = L.marker([feature.properties.Latitude, feature.properties.Longitude], {
                            icon: smallIcon
                        }).addTo(map);
                        previousMarker = newMarker;
                    }
                    var noRuas = feature.properties.No_Ruas;
                    fetch('/api/klhn/getlatlong?no_ruas=' + noRuas)
                        .then(response => response.json())
                        .then(data => {
                            markerGroup.clearLayers();
                            // Hapus semua marker sebelumnya dari peta
                            if(data.message != null){
                                return;
                            }
                            data.forEach(item => {
                                if (item.lat && item.long) {
                                    L.marker([item.lat, item.long], {
                                        icon: smallIcon
                                    }).addTo(markerGroup);
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching data:', error));



                    layer.setStyle({
                        color: 'green'
                    });

                    lastClickedLayer = layer;
                    updateInfoAndPopup(feature, e.latlng);

                });
            }
        }).addTo(map);
    }

    function styleJln(feature) {
        var color, weight;
        color = 'blue'
        weight = 3;
        if (feature.properties.LC == "Median Jalan") {
            color = 'rgb(255,41,80)';
        }
        if (feature.properties.LC == "Sempadan Sungai") {
            color = 'rgb(0,117,102)';
        }
        if (feature.properties.LC == "Taman Kota") {
            color = 'rgb(41,255,62)';
        }
        if (feature.properties.LC == "Taman Rekreasi") {
            color = 'rgb(0,172,235)';
        }
        if (feature.properties.Status == "Jalan Provinsi") {
            color = 'red'
        }
        if (feature.properties.Status == "Jalan Nasional") {
            color = 'red'
            weight = 7;
        }
        feature.originalColor = color;
        feature.originalWeight = weight;
        return {
            fillOpacity: 0.5,
            color: color, // Warna awal fitur
            weight: weight
        };
    }

    // Fungsi style untuk ruang terbuka hijau
    function styleRth(feature) {
        var color, weight;
        color = 'blue'
        weight = 4;
        if (feature.properties.LC == "Median Jalan") {
            color = 'rgb(255,41,80)';
        }
        if (feature.properties.LC == "Sempadan Sungai") {
            color = 'rgb(0,117,102)';
        }
        if (feature.properties.LC == "Taman Kota") {
            color = 'rgb(41,255,62)';
        }
        if (feature.properties.LC == "Taman Rekreasi") {
            color = 'rgb(0,172,235)';
        }
        feature.originalColor = color;
        feature.originalWeight = weight;
        return {
            fillOpacity: 0.5,
            color: color, // Warna awal fitur
            weight: weight
        };
    }

    // Menambahkan kontrol kustom untuk tombol
    var buttonsControl = L.control({
        position: 'topright'
    });

    buttonsControl.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'leaflet-control-buttons info d-none d-lg-block');
        div.innerHTML = `
            <button class="btn btn-primary filterJln" id="filterJln">Jalan</button>
            <button class="btn btn-success filterRth" id="filterRth">RTH</button>
            <button class="btn btn-danger resetFilters" id="resetFilters">Reset</button>
        `;
        return div;
    };

    buttonsControl.addTo(map);

    // Event listener untuk tombol filter
    document.querySelectorAll('.filterJln').forEach(function (element) {
        element.addEventListener('click', function () {
            if (rthLayer) {
                map.removeLayer(rthLayer);
            }
            jlnLayer = addGeoJSONLayer(geojsonJln, styleJln, jlnLayer);
            kabupatenLayer = addGeoJSONLayer(geojsonKabupaten, styleJln, kabupatenLayer);
        });
    });

    document.querySelectorAll('.filterRth').forEach(function (element) {
        element.addEventListener('click', function () {

            if (kabupatenLayer) {
                map.removeLayer(kabupatenLayer);
            }
            if (jlnLayer) {
                map.removeLayer(jlnLayer);
            }
            rthLayer = addGeoJSONLayer(geojsonRth, styleRth, rthLayer);
        });
    });

    document.querySelectorAll('.resetFilters').forEach(function (element) {
        element.addEventListener('click', function () {

            if (kabupatenLayer) {
                map.removeLayer(kabupatenLayer);
            }
            if (jlnLayer) {
                map.removeLayer(jlnLayer);
            }
            if (rthLayer) {
                map.removeLayer(rthLayer);
            }
            jlnLayer = addGeoJSONLayer(geojsonJln, styleJln, jlnLayer);
            rthLayer = addGeoJSONLayer(geojsonRth, styleRth, rthLayer);
            kabupatenLayer = addGeoJSONLayer(geojsonKabupaten, styleJln, kabupatenLayer);
        });
    });

    // Inisialisasi layer pertama kali tanpa filter
    jlnLayer = addGeoJSONLayer(geojsonJln, styleJln, jlnLayer);
    rthLayer = addGeoJSONLayer(geojsonRth, styleRth, rthLayer);
    kabupatenLayer = addGeoJSONLayer(geojsonKabupaten, styleJln, kabupatenLayer);

    // Menambahkan kontrol legenda
    var legend = L.control({
        position: 'bottomleft'
    });

    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'legend');
        div.innerHTML = '<h6>Legenda</h6>';
        div.innerHTML += '<i style="background: red; height:5px;"></i><span> Jalan Nasional</span><br>';
        div.innerHTML += '<i style="background: red;"></i><span> Jalan Provinsi</span><br>';
        div.innerHTML += '<i style="background: blue;"></i><span> Jalan Kabupaten</span><br>';
        div.innerHTML += '<i style="background: rgb(0,117,102); height:10px; margin-top:3px;"></i><span> RTH</span><br>';

        return div;
    };

    legend.addTo(map);

    function updateInfoAndPopup(feature, clickLatLng) {
        var properties = feature.properties;
        var html = '<h6>Informasi RTH</h6>';
        if (properties.Status) {
            html += '<b>Status:</b> ' + properties.Status + '<br />';
        }
        if (properties.Status == "Jalan Provinsi") {
            html += '<b>Silakan menghubungi: Dinas PUPESDM DIY</b> <br />';
            html += '<b>Alamat: </b>' + "Jl. Bumijo No. 5 Jetis Yogyakarta" + '<br />';
            html += '<b>Telp:</b> ' + "0274-589091" + '<br />';
            html += '<b>WA:</b> ' + "085200330000" + '<br />';
        }
        if (properties.Status == "Jalan Nasional") {
            html += '<b>Silakan menghubungi: Satker PJN DIY</b> <br />';
            html += '<b>Alamat: </b> ' + "Jl. Ringroad Utara No. 70 Maguwoharjo Depok Sleman" + '<br />';
            html += '<b>Telp:</b> ' + "0274-2800847" + '<br />';
            html += '<b>WA:</b> ' + "" + '<br />';
        }
        if (properties.Keterangan) {
            html += '<b>Nama Ruas:</b> ' + properties.Keterangan + '<br />';
        }
        if (properties.Nm_Ruas) {
            html += '<b>Nama Ruas:</b> ' + properties.Nm_Ruas + '<br />';
        }
        if (properties.Nama) {
            html += '<b>Nama Sungai:</b> ' + properties.Nama + '<br />';
        }
        if (properties.LC) {
            html += '<b>Penutup lahan:</b> ' + properties.LC + '<br />';
        }
        if (properties.Nama_Desa) {
            html += '<b>Nama Kalurahan:</b> ' + properties.Nama_Desa + '<br />';
        }
        if (properties.No_Ruas) {
            html += '<b>No Ruas:</b> ' + properties.No_Ruas + '<br />';
        }
        if (properties.description) {
            html += '<b>Deskripsi:</b> ' + properties.description + '<br />';
        }

        // Update the div with the info
        document.getElementById("info").innerHTML = html;
        // Also update the popup content
        var popup = L.popup()
            .setLatLng(clickLatLng)
            .setContent(html)
            .openOn(map);
        var popupElement = popup.getElement();
        if (popupElement) {
            popupElement.classList.add('d-lg-block'); // Add your custom class here
            popupElement.classList.add('d-none'); // Add your custom class here
        }
    }

    map.on('zoomend', function () {
        var currentZoom = map.getZoom();
        var weightadd;
        updateIconSizeAndAnchor(map.getZoom(), smallIcon);

        if (currentZoom >= 17) {
            weightadd = 2;
        } else if (currentZoom >= 15 && currentZoom <= 16) {
            weightadd = 0;
        } else {
            weightadd = -2;
        }
        kabupatenLayer.eachLayer(function (layer) {
            var originalWeight = layer.feature.originalWeight;
            layer.setStyle({
                weight: originalWeight + (weightadd)
            });
        });
        rthLayer.eachLayer(function (layer) {
            var originalWeight = layer.feature.originalWeight;
            layer.setStyle({
                weight: originalWeight + (weightadd)
            });
        });
        jlnLayer.eachLayer(function (layer) {
            var originalWeight = layer.feature.originalWeight;
            layer.setStyle({
                weight: originalWeight + (weightadd)
            });
        });
    });
});