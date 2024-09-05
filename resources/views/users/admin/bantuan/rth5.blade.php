<div class="card border-success my-3">
    <div class="card-header bg-transparent border-success">
        <h3>Bantuan Hapus Data Permohonan</h3>
        <ul class="nav-pills my-3 d-flex justify-content-evenly " id="pills-tab" role="tablist" style="list-style-type: none;">
            <li class="nav-item" role="presentation">
                <button class="nav-link py-2 px-3 bg-a active" id="pills-hapus-tab" data-bs-toggle="pill" data-bs-target="#pills-hapus" type="button" role="tab" aria-controls="pills-hapus" aria-selected="true">Hapus Data</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-2 px-3" id="pills-arsip-tab" data-bs-toggle="pill" data-bs-target="#pills-arsip" type="button" role="tab" aria-controls="pills-arsip" aria-selected="false">Arsip</button>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <!-- Hapus -->
        <div class="tab-pane fade show active" id="pills-hapus" role="tabpanel" aria-labelledby="pills-hapus-tab" tabindex="0">
            <h5 class="mx-3">1. Hapus Permohonan</h5>
            <div class="card-body">
                <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/tambahan/hapus1.png" alt="">
                <p class="card-text" style="text-align: justify;">Pada tampilan “Status Permohonan” terdapat dua tombol: “Tinjau” dan “Hapus”. Jika ada data yang sudah lama tidak dilaksanakan, disarankan untuk menghapusnya guna melonggarkan penyimpanan. Data yang dihapus tidak akan langsung terhapus permanen, tetapi akan beralih ke arsip.</p>
            </div>
            <h5 class="mx-3">2. Konfirmasi Hapus Permohonan</h5>
            <div class="card-body">
                <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/tambahan/hapus2.png" alt="">
                <p class="card-text" style="text-align: justify;">Pastikan untuk mengonfirmasi sebelum menghapus data permohonan untuk meminimalisir kesalahan penghapusan data.</p>
            </div>

            <h5 class="mx-3">3. Arsip</h5>
            <div class="card-body">
                <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/tambahan/hapus3.png" alt="">
                <p class="card-text" style="text-align: justify;">Data berhasil dihapus dan dialihkan ke tampilan “Arsip”.</p>
            </div>
        </div>

        <!-- Arsip -->
        <div class="tab-pane fade" id="pills-arsip" role="tabpanel" aria-labelledby="pills-arsip-tab" tabindex="0">
            <div class="card-body">
                <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/tambahan/arsip1.png" alt="">
                <p class="card-text" style="text-align: justify;">Pada halaman arsip, data permohonan yang telah dihapus oleh admin atau pengguna akan tetap ditampilkan. Meskipun data ini dihapus dari “Status Permohonan” atau “Daftar Permohonan”, data tersebut tidak benar-benar dihapus secara permanen. Sebaliknya, data yang dihapus akan dipindahkan ke arsip untuk mencegah kesalahan penghapusan. Untuk menghapus data arsip secara permanen, dapat menekan tombol “Hapus arsip data 1 bulan”. Tombol ini akan menghapus semua data arsip yang telah dihapus selama lebih dari satu bulan dan tidak dapat dipulihkan.</p>
            </div>
            <div class="card-body">
                <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/admin-bantuan/tambahan/arsip2.png" alt="">
                <p class="card-text" style="text-align: justify;">Untuk memulihkan data permohonan yang telah dihapus, Anda harus melakukan filter terlebih dahulu. Ikuti langkah-langkah filter yang sama seperti yang dijelaskan sebelumnya. Setelah menemukan data yang ingin dipulihkan, klik tombol “Pulihkan” untuk mengembalikan data tersebut.</p>
            </div>
        </div>
    </div>
</div>