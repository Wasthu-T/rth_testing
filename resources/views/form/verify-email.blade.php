@extends('form.layout.main')

@section('container')
<div class="container">
    @if (session('resent'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{ __('Sebelum melanjutkan, harap periksa email Anda untuk tautan verifikasi.') }}
    {{ __('Jika Anda tidak menerima email tersebut') }},
    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk mengirim ulang') }}</button>.
    </form>
</div>
@endsection