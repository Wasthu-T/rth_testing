<?php

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\PohonController;
use App\Http\Controllers\Registercontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Auth::routes(['verify' => true]);

Route::get('/', function () {
    return redirect('/beranda');
});
Route::get('/beranda', [GuestController::class, 'beranda']);
Route::get('/profil', [GuestController::class, 'index']);
Route::get('/bantuan/daftar', [GuestController::class, 'index']);
Route::get('/bantuan/pelaporan', [GuestController::class, 'index']);
Route::get('/kontak', [GuestController::class, 'index']);

// login & register start
// login
Route::get('/masuk', [Logincontroller::class, 'index'])->middleware('guest')->name('login');
Route::post('/masuk', [Logincontroller::class, 'masuk'])->middleware('throttle:5,1');
// register
Route::get('/daftar', [Registercontroller::class, 'index']);
Route::post('/daftar', [Registercontroller::class, 'store'])->middleware('throttle:5,1');

// reset password
Route::get('/forgot-password', function () {
    return view('form.forgot-password');
})->middleware(['guest'])->name('password.request');
Route::post('/forgot-password',[Logincontroller::class, 'forgotpass'])->middleware(['guest','throttle:5,1'])->name('password.email');

Route::get('/reset-password/{token}', [Logincontroller::class, 'showResetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password',[Logincontroller::class, 'resetpass'])->middleware('guest')->name('password.update');

// logout
Route::post('/keluar', [Logincontroller::class, 'keluar']);
// login & register end

// Email Verif
Route::prefix('/email')->middleware(['auth', 'checkverif'])->group(function () {
    Route::get('/verify', [UserController::class, 'index'])->name('verification.notice');
    Route::get('/change', [UserController::class, 'index'])->name('email.change');
    Route::post('/change', [UserController::class, 'updateEmail'])->name('email.change');
    Route::post('/verify', [UserController::class, 'sendOtp'])->middleware('throttle:5,1')->name('verification.send.otp');
    Route::get('/verify-otp', [UserController::class, 'index'])->name('verification.otp.form');
    Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->middleware('throttle:5,1')->name('verification.verify.otp');
});

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return redirect('/beranda');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:5,1'])->name('verification.send');

// user & admin
Route::prefix('/dashboard/admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'index']);
    Route::get('/arsip', [AdminController::class, 'index'])->middleware('adminlvl');
    Route::post('/arsip/{klhn:slug}', [PohonController::class, 'backup']);
    Route::post('/pulihkan/{backup:kd_hapus}', [AdminController::class, 'pulihkan'])->middleware('adminlvl');
    Route::post('/hapus', [PohonController::class, 'hapus'])->middleware('adminlvl');
    Route::get('/rekapitulasi', [AdminController::class, 'index']);
    Route::get('/petarekapitulasi', [AdminController::class, 'index']);
    Route::get('/bantuan', [AdminController::class, 'index']);
    Route::get('/bantuan/filter', [AdminController::class, 'index']);
    Route::get('/bantuan/hapuspermohonan', [AdminController::class, 'index']);
    Route::get('/bantuan/tampilanrekapitulasi', [AdminController::class, 'index']);
    Route::get('/bantuan/prosespermohonan', [AdminController::class, 'index']);
    Route::get('/{klhn:slug}', [AdminController::class, 'show']);
    Route::get('/{klhn:slug}/update', [AdminController::class, 'update']);
    Route::post('/{klhn:slug}/update', [PohonController::class, 'storeadmin']);
    Route::get('/api/klhn/getdata', [AdminController::class, 'getdata']);
});
Route::prefix('/dashboard')->middleware(['auth', 'user', 'verified'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/profil', [UserController::class, 'index']);
    Route::post('/arsip/{klhn:slug}', [PohonController::class, 'backup']);
    Route::get('/bantuan/membuatlaporan', [UserController::class, 'index']);
    Route::get('/bantuan/pelaksanaanmasyarakat', [UserController::class, 'index']);
    Route::get('/bantuan/memperbaikikesalahanlaporan', [UserController::class, 'index']);
    Route::get('/profil/ubah', [UserController::class, 'index']);
    Route::post('/profil/ubah', [UserController::class, 'updateuser']);
    Route::get('/profil/ubahpassword', [UserController::class, 'index']);
    Route::post('/profil/ubahpassword', [UserController::class, 'updatepass']);
    Route::get('/permohonan', [PohonController::class, 'index']);
    Route::post('/permohonan', [PohonController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/{klhn:slug}', [UserController::class, 'show']);
    Route::get('/{klhn:slug}/edit', [PohonController::class, 'update']);
    Route::post('/{klhn:slug}/edit', [PohonController::class, 'updatedata'])->middleware('throttle:5,1');
});

// Route::post('/tes',function(){});
// Route::get('/tes',function(){
//     return view('tes');
// });
