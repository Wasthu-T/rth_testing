<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Registercontroller extends Controller
{
    public function index()
    {
        return view('form.register');
    }
    private function recommendUsername($username)
    {
        do {
            $randomNumber = random_int(1000, 9999);
            $newUsername = $username . $randomNumber;
        } while (User::where('username', $newUsername)->exists());

        return $newUsername;
    }

    public function store(Request $request)
    {
        if (User::where('username', $request->username)->exists()) {
            $recommendedUsername = $this->recommendUsername($request->username);
            return redirect()->back()->withInput()->withErrors(['unik' => 'Username sudah digunakan. Coba ' . $recommendedUsername]);
        }
        $validated = $request->validate([
            'username' => ['required', 'unique:users'],
            'nm_lengkap' => 'required|max:255',
            'alamat' => 'required',
            'email' => 'required|email:dns|unique:users',
            'no_hp' => 'required|numeric|unique:users',
            'password' => 'required|min:6|confirmed|regex:/^(?=.*\d)+$/',
        ]);
        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);


        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        Auth::login($user); // Login otomatis pengguna
        
        return redirect('/dashboard')->with('status', 'Registrasi Berhasil, Harap lakukan verifikasi terlebih dahulu.');

        
    }
}
