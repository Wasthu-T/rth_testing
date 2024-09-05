@extends('users.layout.main')

@section('container-user')

@if(session()->has('berhasil'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('berhasil') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session()->has('gagal'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('gagal') }} </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card my-3 mx-3 text-center">
    <h5 class="card-header">Ubah Email</h5>
    <div class="card-body">
        <form method="POST" action="{{ route('email.change') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="example@gmail.com" id="email" name="email" required>
                <label for="floatingInput">Email Baru</label>
            </div>
            <button type="submit" class="btn btn-outline-success w-100">Konfirmasi</button>
        </form>
        <a href="/email/verify">
            <button type="submit" class="btn btn-outline-secondary my-1 w-100">
                Kembali
            </button>
        </a>
    </div>
</div>
@endsection