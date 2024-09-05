@extends('form.layout.main')

@section('container')

<div class="modal modal-sheet position-static d-block " tabindex="-1" role="dialog" id="modalSignin">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow">
      <div class="border-bottom-0 m-3">
        <h1 class="fw-bold mb-0 fs-2 text-center"><img src="/img/logo/simpel-rth-light-removebg-preview (1).png" alt="rth" width="50px" height="auto"> Buat Akun</h1>
      </div>

      <div class="mx-3 row row-cols-1 row-cols-lg-2 text-center my-3 gap-lg-0 gap-2">
        <div class="col">
          <a class="btn btn-outline-success w-100 {{request() -> segment(1) === "masuk" ? 'active' : ''}}" role="button" href="/masuk">Masuk</a>
        </div>
        <div class="col">
          <a class="btn btn-outline-success w-100 {{request() -> segment(1) === "daftar" ? 'active' : ''}}" role="button" href="/daftar">Daftar</a>
        </div>
      </div>
      <div class="modal-body p-3 pt-0">

        <form action="/daftar" method="POST">
          @csrf
          <div class="form-floating mb-3">
            <input required name="username" type="text" class="form-control rounded-3 @error('username') is-invalid @enderror" id="username" placeholder="username" value="{{old('username')}}">
            <label for="username">Username</label>
            @error('unik')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
            @error('username')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input required name="nm_lengkap" type="text" class="@error('nm_lengkap') is-invalid @enderror form-control rounded-3" id="nm_lengkap" placeholder="nm_lengkap" value="{{old('nm_lengkap')}}">
            <label for="nm_lengkap">Nama Lengkap</label>
            @error('nm_lengkap')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input required name="alamat" type="text" class="@error('alamat') is-invalid @enderror form-control rounded-3" id="alamat" placeholder="alamat" value="{{old('alamat')}}">
            <label for="alamat">Alamat</label>
            @error('alamat')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input required name="email" type="email" class="@error('email') is-invalid @enderror form-control rounded-3" id="email" placeholder="name@example.com" value="{{old('email')}}">
            <label for="email">Email</label>
            @error('email')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input required name="no_hp" type="text" class="@error('no_hp') is-invalid @enderror form-control rounded-3" id="no_hp" placeholder="08123456789" value="{{old('no_hp')}}">
            <label for="no_hp">No Hp</label>
            @error('no_hp')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-floating mb-3">
            <input required name="password" type="password" class="@error('password') is-invalid @enderror form-control rounded-3" id="password" placeholder="Password">
            <label for="password">Password</label>
            <span id="togglePassword" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
              <i class="bi bi-eye"></i>
            </span>
            @error('password')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-floating mb-3">
            <input required name="password_confirmation" type="password" class="form-control rounded-3" id="password_confirmation" placeholder="Password_confirmation">
            <label for="password_confirmation">Konfirmasi Password</label>
            <span id="togglePasswordConfirmation" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
              <i class="bi bi-eye"></i>
            </span>
            @error('password_confirmation')
            <div class="text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          @if ($errors->has('g-recaptcha-response'))
          <span class="help-block text-danger">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
          </span>
          @endif
          <div class="form-floating mb-3">
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
          </div>

          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit">Daftar</button>
        </form>

      </div>
    </div>
  </div>
  @endsection