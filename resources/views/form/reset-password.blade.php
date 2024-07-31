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
                <h1 class="fw-bold mb-0 fs-2 text-center"><img src="/img/logo/simpel-rth-light-removebg-preview (1).png" alt="rth" width="50px" height="auto"> Reset Password</h1>
            </div>
            <div class="modal-body pt-0">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-floating mb-3">
                        <input name="email" type="text" class="form-control rounded-3 @error('email') is-invalid @enderror" id="email" placeholder="example@gmail.com" value="{{ $email ?? old('email') }}" autofocus required>
                        <label for="email">Email</label>
                        @error('email')
                        <div class="text-danger">
                            {{$message}}
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
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit">Reset Password</button>
                </form>

            </div>
        </div>
    </div>
    @endsection