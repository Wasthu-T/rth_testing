$(document).ready(function () {
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "/dashboard/admin/rekapitulasi?page=" + page,
            success: function (data) {
                $('#data-container').html(data);
            }
        });
    }
});
const bulanMap = {
    "01": "Januari",
    "02": "Februari",
    "03": "Maret",
    "04": "April",
    "05": "Mei",
    "06": "Juni",
    "07": "Juli",
    "08": "Agustus",
    "09": "September",
    "10": "Oktober",
    "11": "November",
    "12": "Desember"
};
const statusMap = {
    "0": "Data Kurang",
    "1": "Diproses",
    "2": "Ditinjau",
    "3": "Surat Rekomendasi",
    "4.1": "Pelaksanaan DLH",
    "4.2": "Pelaksanaan UPTDKPP",
    "4.3": "Pelaksanaan Masyarakat",
    "5": "Selesai",
    "6": "Nasional & Provinsi",
    "7": "Gagal"
};

document.addEventListener('DOMContentLoaded', function () {
    // Fetch data for the column chart based on filter
    const tglselect = document.getElementById('tgl');
    const tahunselect = document.getElementById('tahun');
    // Fetch data for the pie chart initially
    function fetchDataInstansi() {
        const tahun = tahunselect.value;
        fetch(`/api/instansi?tahun=${tahun}`)
            .then(response => {
                if (response.status == 404){
                    var data = document.getElementById('instansichartContainer');
                    data.innerText = 'Data tidak ditemukan'
                }
                if (!response.ok) {
                    // Tangani status bukan 200-299 (misalnya 400, 404, 500, dll)
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Hitung total nilai dari semua item
                const totalSum = data.reduce((sum, item) => sum + item.total, 0);

                // Hitung data points dengan persentase
                var dataPoints = data.map(item => ({
                    y: item.total, // Persentase
                    label: item.instansi,
                    indexLabel: `${item.instansi}: ${item.total} (${(item.total / totalSum * 100).toFixed(2)}%)`
                }));

                var instansichartContainer = new CanvasJS.Chart("instansichartContainer", {
                    animationEnabled: true,
                    title: {
                        text: "Instansi Data"
                    },
                    data: [{
                        type: "pie",
                        startAngle: 240,
                        indexLabel: "{indexLabel}", // Gunakan indexLabel yang telah diatur
                        dataPoints: dataPoints
                    }]
                });
                instansichartContainer.render();
            })
            .catch(error => console.error('Error fetching data:', error));

    }

    function fetchDataStatus() {
        const tahun = tahunselect.value;
        fetch(`/api/totalstatus?tahun=${tahun}`)
            .then(response => {
                if (response.status == 404){
                    var data = document.getElementById('failedchartContainer');
                    data.innerText = 'Data tidak ditemukan'
                }
                if (!response.ok) {
                    // Tangani status bukan 200-299 (misalnya 400, 404, 500, dll)
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Data dari API
                var berhasil = data.status_dijalankan;
                var gagal = data.status_gagal;

                // Gabungkan kedua kategori
                var combinedData = [...berhasil, ...gagal.map(item => ({ status: '7', total: item.total }))];
                // Hitung total nilai dari semua item
                const totalSum = combinedData.reduce((sum, item) => sum + item.total, 0);

                // Hitung data points dengan persentase
                var dataPoints = combinedData.map(item => ({
                    y: item.total, // Persentase
                    label: `${statusMap[item.status]}`,
                    indexLabel: `${statusMap[item.status]}: ${item.total} (${(item.total / totalSum * 100).toFixed(2)}%)`
                }));

                var failedchartContainer = new CanvasJS.Chart("failedchartContainer", {
                    animationEnabled: true,
                    title: {
                        text: "Persebaran Data"
                    },
                    data: [{
                        type: "pie",
                        startAngle: 240,
                        indexLabel: "{indexLabel}", // Gunakan indexLabel yang telah diatur
                        dataPoints: dataPoints
                    }]
                });
                failedchartContainer.render();
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function fetchDatalaporan() {
        const tgl = tglselect.value;
        const tahun = tahunselect.value;

        fetch(`/api/tgl-laporan?tgl=${tgl}&tahun=${tahun}`)
            .then(response => {
                if (response.status == 404){
                    var data = document.getElementById('columnchartContainer');
                    data.innerText = 'Data tidak ditemukan'
                }
                if (!response.ok) {
                    // Tangani status bukan 200-299 (misalnya 400, 404, 500, dll)
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                var dataPoints = data.map(item => ({
                    y: item.total,
                    label: `${bulanMap[item.bulan]}`
                }));

                if (tgl == "tgl_survei") {
                    var nama = "survei";
                } else if (tgl == "tgl_pelaksanaan") {
                    var nama = "pelaksanaan";
                } else {
                    var nama = "awal pelaporan"
                }
                var chart = new CanvasJS.Chart("columnchartContainer", {
                    animationEnabled: true,
                    title: {
                        text: `Jumlah laporan bedasarkan ${nama}`
                    },
                    axisY: {
                        title: "Jumlah Laporan"
                    },
                    data: [{
                        type: "column",
                        indexLabel: "{y}",
                        dataPoints: dataPoints
                    }]
                });
                chart.render();
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Event listeners untuk perubahan pada select elements
    tglselect.addEventListener('change', fetchDatalaporan);
    tahunselect.addEventListener('change', fetchDatalaporan);
    tahunselect.addEventListener('change', fetchDataStatus);
    tahunselect.addEventListener('change', fetchDataInstansi);

    // Muat data awal untuk grafik kolom jika diperlukan
    fetchDataStatus();
    fetchDataInstansi();
    fetchDatalaporan();
});