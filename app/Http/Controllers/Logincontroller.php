<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Logincontroller extends Controller
{
    public function index()
    {
        return view('form.login');
    }

    public function masuk(Request $request)
    {

        $rules = [
            'password' => 'required|string',
            'username' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ];
        $throttles = $request->session()->get('throttle', []);

        if (isset($throttles['login']) && $throttles['login'] >= 5) {
            $seconds = now()->diffInSeconds($throttles['expires_at']);
            return back()->with('throttle', __('auth.throttle', ['seconds' => $seconds]));
        }
        // Validasi input
        $request->validate($rules);

        $credentials = [
            'password' => $request->password,
        ];

        // Cek apakah input adalah username atau nomor HP
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->username;
        } else if (is_numeric($request->username)) {
            $credentials['no_hp'] = $request->username;
        } else {
            $credentials['username'] = $request->username;
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/bantuan/membuatlaporan');
        }
        return back()->with('loginError', 'Login Gagal');
    }

    public function keluar(Request $request)
    {
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/beranda')->with('pesan', 'Berhasil Keluar!');
        } else {
            return redirect('/masuk')->with('pesan', 'Anda belum login!');
        }
    }

    public function forgotpass(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Alamat Email Belum Terdaftar']);
        }

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('form.reset-password')->with([
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function resetpass(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
