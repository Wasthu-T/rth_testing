<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Geojson;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\StatistikController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/klhn/getlatlong', [GuestController::class, 'getlatlong']);


Route::prefix('geojson/data')->group(function () {
    Route::get('/{type}', [Geojson::class, 'index'])
        ->where('type', 'kabupaten|rth|jln');
});

Route::get('/totalstatus', [StatistikController::class, 'status']);
Route::get('/tgl-laporan', [StatistikController::class, 'tgl_req']);
Route::get('/instansi', [StatistikController::class, 'instansi']);