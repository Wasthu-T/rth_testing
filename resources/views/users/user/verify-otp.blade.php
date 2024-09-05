@extends('users.layout.main')

@section('container-user')

@if(session()->has('status'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>{{ session('status') }} </strong>
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
    <h5 class="card-header">Verifikasi OTP</h5>
    <div class="card-body">
        <form method="POST" action="{{ route('verification.verify.otp') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="111111" maxlength="6" id="otp" name="otp" onkeypress="return /[0-9]/i.test(event.key)" required>
                <label for="floatingInput">Kode OTP:</label>
            </div>
            <button type="submit" class="btn btn-outline-success w-100">Verifikasi</button>
        </form>

        <form action="/email/verify" method="post">
            @csrf
            <button id="resendButton" type="submit" class="btn btn-outline-secondary my-1 w-100" disabled>
                Kirim ulang kode otp
            </button>
        </form>
        <p id="timer" class="text-center mt-2">Anda dapat meminta ulang dalam <span id="countdown">60</span> detik.</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resendButton = document.getElementById('resendButton');
        const countdownElement = document.getElementById('countdown');
        const timerElement = document.getElementById('timer');

        // Ambil waktu expired_otp dari Blade (sesuaikan dengan data Anda)
        const expiredOtp = `{{ $expiredOtp }}`;
        console.log(expiredOtp);
        // Hitung waktu tersisa
        const now = new Date();
        const expiredDate = new Date(expiredOtp);
        let remainingTime = Math.max(0, Math.ceil((expiredDate - now) / 1000));

        function updateCountdown() {
            countdownElement.textContent = remainingTime;
            if (remainingTime <= 0) {
                resendButton.disabled = false;
                timerElement.style.display = 'none'; // Menyembunyikan timer setelah tombol aktif kembali
            } else {
                remainingTime -= 1;
                setTimeout(updateCountdown, 1000);
            }
        }

        // Menampilkan timer dan mengatur tombol
        if (remainingTime > 0) {
            resendButton.disabled = true;
            timerElement.style.display = 'block';
            updateCountdown();
        } else {
            resendButton.disabled = false;
            timerElement.style.display = 'none';
        }
    });
</script>
@endsection