@extends('users.layout.main')

<!-- perhatikan lagi jika login dan tidak -->
@section('container-user')
@if(session()->has('berhasil'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('berhasil') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session()->has('status'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('status') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session()->has('gagal'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('gagal') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="mt-5">
    @if (session('resent'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <h4>Data Diri</h4>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Nomor Identitas</th>
                <td>: {{auth()->user()->uuid}}</td>
            </tr>
            <tr>
                <th scope="row">Username</th>
                <td>: {{auth()->user()->username}}</td>
            </tr>
            <tr>
                <th scope="row" class="col-4">Nama</th>
                <td class="col-8">: {{auth()->user()->nm_lengkap}}</td>
            </tr>
            <tr>
                <th scope="row">Alamat</th>
                <td>: {{auth()->user()->alamat}}</td>

            </tr>
            <tr>
                <th scope="row">Whatsapp</th>
                <td>: {{auth()->user()->no_hp}}</td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td>: {{auth()->user()->email}}</td>
            </tr>
        </tbody>
    </table>
</div>
@if(auth()->user()->email_verified_at == null)
<p style="text-align: justify;">Sebelum melanjutkan, harap periksa email anda untuk tautan verifikasi.</p>
<p style="text-align: justify;">Jika anda tidak menerima email tersebut klik <b class="text-danger">Kirim Ulang Verifikasi Email.</b></p>
<p style="text-align: justify;">Jika email salah klik <b class="text-danger">Ubah.</b></p>
@endif
<div class="justify-content-between d-sm-flex flex-row ">
    @if(auth()->user()->email_verified_at == null)
    <a class="text-decoration-none" href="/email/change">
        <button type="button" class="btn btn-outline-warning w-100 my-1">Ubah Email</button>
    </a>

    <form class="d-inline" method="POST" action="{{ route('verification.send.otp') }}">
        @csrf
        <button type="submit" class="btn btn-outline-success w-100 my-1">Verifikasi Email</button>
    </form>
    @else
    <a class="text-decoration-none" href="/dashboard/profil/ubah">
        <button type="button" class="btn btn-outline-warning w-100 my-1">Ubah</button>
    </a>
    @endif
</div>

@endsection