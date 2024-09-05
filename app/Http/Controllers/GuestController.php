<?php

namespace App\Http\Controllers;

use App\Models\klhn;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $request){
        $routeName = $request->path();
        switch ($routeName) {
            case 'profil':
                return view('profil');
                break;
            case 'bantuan/daftar':
                return view('faq.daftar');
                break;
            case 'bantuan/pelaporan':
                return view('faq.izin');
                break;
            case 'kontak':
                return view('kontak');
                break;
            default:
                return redirect('/beranda');
        }
    }
    
    public function beranda(Request $request)
    {
        return view('main');
    }

    public function getlatlong(Request $request)
{
    // Mendapatkan parameter 'no_ruas' dari query string
    $noRuas = $request->query('no_ruas');

    // Menambahkan kondisi untuk memastikan 'no_ruas' ada
    if (!$noRuas) {
        return response()->json(['message' => 'Klik ruas yang tersedia terlebih dahulu.'], 400);
    }

    // Membangun query
    $query = Klhn::selectRaw('no_ruas, lat, `long`')
                //  ->where('status', "5")
                 ->where('no_ruas', $noRuas);

    // Menjalankan query dan mendapatkan hasil
    $data2 = $query->get();

    // Mengecek apakah data ditemukan atau tidak
    if ($data2->isEmpty()) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    // Mengembalikan data sebagai JSON
    return response()->json($data2);
}
    
}
