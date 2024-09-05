@extends('layout.main')

@section('container')
<div class="content"></div>
<div class="container">
    <div class="card border-success mb-3">
        <div class="card-header bg-transparent border-success">
            <h3>Bantuan Buat Akun</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title">1. Klik tombol masuk</h5>
            <img class="mx-auto d-block img-fluid img-tutorial70" src="/img/daftar/daftar1.png" alt="">
            <p class="card-text" style="text-align: justify;">Pada halaman beranda, anda akan melihat sebuah tombol "Masuk" di bagian atas. Klik tombol ini untuk memulai proses login ke sistem. Langkah ini diperlukan agar anda dapat mengakses semua fitur yang tersedia, termasuk melakukan pelaporan atau pemantauan data yang telah anda laporkan sebelumnya. Pastikan anda sudah memiliki akun sebelum mencoba untuk login. Jika belum, lanjutkan ke langkah berikutnya untuk membuat akun baru.</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">2. Klik tombol daftar</h5>
            <img class="mx-auto d-block img-fluid img-tutorial40" src="/img/daftar/daftar2.png" alt="">
            <p class="card-text" style="text-align: justify;">Jika anda belum memiliki akun, klik tombol "Daftar" yang terletak di halaman login. Tombol ini akan mengarahkan anda ke formulir pendaftaran. Di sini, anda akan diminta untuk mengisi beberapa informasi dasar untuk membuat akun baru. Proses ini penting untuk memastikan bahwa setiap pengguna terdaftar dan dapat memanfaatkan semua layanan yang disediakan oleh sistem kami. Jika anda sudah memiliki akun, anda dapat langsung login menggunakan username dan password yang sudah anda buat sebelumnya.</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">3. Isi formulir</h5>
            <img class="mx-auto d-block img-fluid img-tutorial40" src="/img/daftar/daftar3.png" alt="">
            <p class="card-text" style="text-align: justify;">Untuk menyelesaikan proses pendaftaran, anda perlu mengisi formulir pendaftaran dengan informasi yang diperlukan. Formulir ini membutuhkan data seperti username, nama lengkap, alamat, email, nomor telepon, dan password. Pastikan semua informasi yang anda masukkan sesuai. <span class="text-danger"> <b>Ingat password yang anda buat, karena anda akan membutuhkannya untuk login.</span><span class="text-danger"> Jangan sampai lupa atau memberikan informasi ke orang lain.</b></span> Selain itu, jangan lupa untuk mengisi captcha yang disediakan di bagian bawah formulir sebelum mengirimkan data pendaftaran anda.</p>
        </div>
        <div class="card-body">
            <h5 class="card-title">4. Isi form masuk</h5>
            <img class="mx-auto d-block img-fluid img-tutorial40" src="/img/daftar/daftar4.png" alt="">
            <p class="card-text" style="text-align: justify;">Setelah berhasil membuat akun, anda dapat melanjutkan dengan proses login. Pada halaman login, isi form dengan username, nomor telepon, atau email yang anda gunakan saat pendaftaran, beserta password yang telah anda buat. Pastikan anda mengisi semua kolom yang diperlukan dengan benar. Setelah itu, jangan lupa untuk mengisi captcha yang tersedia untuk memastikan bahwa anda bukan robot. Setelah semua kolom terisi dengan benar, klik tombol "Masuk" untuk mengakses akun anda dan mulai menggunakan layanan kami.</p>
        </div>
    </div>
</div>
@endsection