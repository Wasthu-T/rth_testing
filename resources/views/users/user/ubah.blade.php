@extends('users.layout.main')

@section('container-user')
<h3 class="my-4">Data Diri</h3>
<form action="/dashboard/profil/ubah" method="POST">
    @csrf
    <div class="form-floating mb-3">
        <input disabled name="username" type="text" class="form-control rounded-3 @error('username') is-invalid @enderror" id="username" placeholder="username" value="{{auth()->user()->username}}">
        <label for="username">Username</label>
        @error('username')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input required name="nm_lengkap" type="text" class="@error('nm_lengkap') is-invalid @enderror form-control rounded-3" id="nm_lengkap" placeholder="nm_lengkap" value="{{auth()->user()->nm_lengkap}}">
        <label for="nm_lengkap">Nama Lengkap</label>
        @error('nm_lengkap')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input required name="alamat" type="text" class="@error('alamat') is-invalid @enderror form-control rounded-3" id="alamat" placeholder="alamat" value="{{auth()->user()->alamat}}">
        <label for="alamat">Alamat</label>
        @error('alamat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input disabled required name="email" type="email" class="@error('email') is-invalid @enderror form-control rounded-3" id="email" placeholder="name@example.com" value="{{auth()->user()->email}}">
        <label for="email">Email</label>
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input required name="no_hp" type="text" class="@error('no_hp') is-invalid @enderror form-control rounded-3" id="no_hp" placeholder="08123456789" value="{{auth()->user()->no_hp}}">
        <label for="no_hp">No_hp</label>
        @error('no_hp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-warning" type="submit">Konfirmasi</button>
</form>
<a href="/dashboard/profil/ubahpassword">
    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-warning" type="submit">Ubah password</button>
</a>
<a href="/dashboard/profil">
    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-warning" type="submit">Kembali</button>
</a>

@endsection