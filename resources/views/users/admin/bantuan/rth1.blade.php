<div class="card border-success my-3">
    <div class="card-header bg-transparent border-success">
        <h3>Bantuan Melakukan Filter</h3>
    </div>
    <div class="card-body">
        <h5 class="card-title">1. Jenis Filter</h5>
        <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/filter/filter2.png" alt="">
        <p class="card-text" style="text-align: justify;">Pada menu status permohonan terdapat 3 jenis filter yang bisa dikombinasikan.</p>
        <ul class="list-unstyled">
            <li style="text-align: justify;">1. Warna merah : filter bedasarkan NIK pada kolom Nik. Dan kode permohonan tidak terlihat pada tabel tersebut namun setiap permohonan memiliki nilai unik.</li>
            <li style="text-align: justify;">2. Warna hijau : filter status permohonan pada kolom status.</li>
            <li style="text-align: justify;">3. Warna kuning : filter tanggal dibuat permohonan pada kolom Tgl buat.</li>
        </ul>
    </div>

    <div class="card-body">
        <h5 class="card-title">2. Contoh Penerapan Filter</h5>
        @if(auth()->user()->akses_lvl == "1")
        <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/filter/filter4.2.png" alt="">
        @elseif(auth()->user()->akses_lvl == "2")
        <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/filter/filter4.png" alt="">
        @endif
        <p class="card-text" style="text-align: justify;">Berikut adalah contoh penerapan filter, di mana hanya dilakukan filter berdasarkan status saja. Anda dapat menggunakan berbagai filter seperti NIK, status, atau tanggal. Setelah semua filter yang akan digunakan dipilih, klik tombol "Search" untuk menampilkan hasil yang sesuai.</p>
    </div>
</div>