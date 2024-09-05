@extends('users.layout.main')

@section('container-user')
<h4 class="my-4">Ganti Password</h4>
<form action="/dashboard/profil/ubahpassword" method="POST">
    @csrf
    <div class="form-floating mb-3">
        <input required name="current_password" type="password" class="@error('current_password') is-invalid @enderror form-control rounded-3" id="current_password" placeholder="Password Lama">
        <label for="current_password">Password Lama</label>
        @error('current_password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input required name="new_password" type="password" class="@error('new_password') is-invalid @enderror form-control rounded-3" id="new_password" placeholder="Password Baru">
        <label for="new_password">Password Baru</label>
        @error('new_password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input required name="new_password_confirmation" type="password" class="@error('new_password_confirmation') is-invalid @enderror form-control rounded-3" id="new_password_confirmation" placeholder="Konfirmasi Password Baru">
        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
        @error('new_password_confirmation')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-warning" type="submit">Konfirmasi</button>
</form>
<a href="/dashboard/profil">
    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-warning" type="submit">Kembali</button>
</a>
@endsection