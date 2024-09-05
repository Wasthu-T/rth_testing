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

    @error('email')
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ $message }}
    </div>
    @enderror

    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="border-bottom-0 m-3">
                <h1 class="fw-bold mb-0 fs-2 text-center"><img src="/img/logo/simpel-rth-light-removebg-preview (1).png" alt="rth" width="50px" height="auto"> Lupa Password</h1>
            </div>

            <div class="modal-body pt-0">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-floating my-3">
                        <input name="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" id="email" placeholder="example@gmail.com" autofocus required>
                        <label for="email">Email</label>
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
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit"><i class="bi bi-envelope-fill"></i>Kirim Link Reset Password</button>
                    <div class="mb-3 justify-content-start d-flex">
                        <a href="/masuk" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" style="font-size: .9em;"><i class="bi bi-arrow-left"></i>Kembali ke Halaman Login</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection