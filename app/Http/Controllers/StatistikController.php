<?php

namespace App\Http\Controllers;

use App\Models\klhn;
use App\Models\backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    }

    public function tgl_req(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));
        $kolomTanggal = $request->query('tgl', 'created_at');

        $validKolomTanggal = ['created_at', 'tgl_survei', 'tgl_pelaksanaan'];
        if (!in_array($kolomTanggal, $validKolomTanggal)) {
            return response()->json(['message' => 'Kolom tanggal tidak valid'], 400);
        }

        $query = Klhn::selectRaw('
        DATE_FORMAT(' . $kolomTanggal . ', "%m") as bulan,
        count(*) as total
    ')
            ->whereYear($kolomTanggal, $tahun)
            ->groupBy(DB::raw('DATE_FORMAT(' . $kolomTanggal . ', "%m")'))
            ->get();

        if ($query->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($query);
    }


    public function instansi(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));

        $query = Klhn::selectRaw('istansi as instansi, count(*) as total')
            ->whereNotIn('istansi', ['Nasional', 'Provinsi'])
            ->whereNotNull('istansi')
            ->whereYear('updated_at', $tahun)
            ->groupBy('istansi')
            ->get();

        if ($query->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($query);
    }

    public function status(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));

        $querystt1 = Klhn::selectRaw('`status`, count(`status`) as total')
            ->groupBy('status')
            ->whereYear('updated_at', $tahun)
            ->get();
        $querystt2 = backup::selectRaw('count(`id`) as total')
            ->whereYear('waktu_hapus', $tahun)
            ->get();
        if ($querystt1->isEmpty() && $querystt2[0]->total == "0") {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data = [
            'status_dijalankan' => $querystt1,
            'status_gagal' => $querystt2
        ];

        return response()->json($data);
    }
}
