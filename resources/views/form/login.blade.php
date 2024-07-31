@extends('form.layout.main')

@section('container')
<div class="modal modal-sheet position-static d-block " tabindex="-1" role="dialog" id="modalSignin">

  @if(session()->has('status'))
  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('status') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  @if(session()->has('loginError'))
  <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('loginError') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow">
      <div class="border-bottom-0 m-3">
        <h1 class="fw-bold mb-0 fs-2 text-center"><img src="/img/logo/simpel-rth-light-removebg-preview (1).png" alt="rth" width="50px" height="auto"> Masuk</h1>
      </div>

      <div class="container row row-cols-1 row-cols-lg-2 text-center mx-auto my-3 gap-lg-0 gap-2">
        <div class="col">
          <a class="btn btn-outline-success w-100 {{request() -> segment(1) === "masuk" ? 'active' : ''}}" role="button" href="/masuk">Masuk</a>
        </div>
        <div class="col">
          <a class="btn btn-outline-success w-100 {{request() -> segment(1) === "daftar" ? 'active' : ''}}" role="button" href="/daftar">Daftar</a>
        </div>
      </div>

      <div class="modal-body pt-0">

        <form action="/masuk" method="POST">
          @csrf

          <div class="form-floating mb-3">
            <input name="username" type="text" class="form-control rounded-3 @error('username') is-invalid @enderror" id="username" placeholder="xxxxxxxxxxxxxxxx" value="{{old('username')}}" autofocus required>
            <label for="username">Username / No Hp / Email</label>
            @error('username')
            <div class="text-danger">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-floating">
            <input name="password" type="password" class="form-control rounded-3" id="password" placeholder="Password" required>
            <label for="password">Password</label>
            <span id="togglePassword" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
              <i class="bi bi-eye"></i>
            </span>
            @if ($errors->has('g-recaptcha-response'))
            <span class="help-block text-danger">
              <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
            @endif
          </div>
          <div class="mb-3 justify-content-end d-flex mx-3">
            <a href="{{ route('password.request') }}" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" style="font-size: .9em;">Lupa Password?</a>
          </div>
          <div class="form-floating mb-3">
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit"><i class="bi bi-box-arrow-in-right"></i>Masuk</button>

        </form>

      </div>
    </div>
  </div>
  @endsection