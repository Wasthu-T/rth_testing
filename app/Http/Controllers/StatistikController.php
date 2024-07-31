<?php

namespace App\Http\Controllers;

use App\Models\backup;
use App\Models\klhn;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $routeName = $request->path();
        switch ($routeName) {
            case 'api/totalstatus':
                $querystt1 = Klhn::selectRaw('`status`, count(`status`) as total')->groupBy('status')->get();
                $querystt2 = backup::selectRaw('count(`id`) as total')->get();
            
                if ($querystt1->isEmpty() && $querystt2->isEmpty()) {
                    return response()->json(['message' => 'Data tidak ditemukan'], 404);
                }

                $data = [
                    'status_dijalankan' => $querystt1,
                    'status_gagal' => $querystt2
                ];
            
                return response()->json($data);
            default:
                abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
