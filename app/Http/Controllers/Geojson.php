<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Geojson extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $routeName = $request->path();
        switch ($routeName) {
            case 'api/geojson/data/kabupaten':
                $geojson = file_get_contents(storage_path('app/geojson/Jalan_Kabupaten_Bantul.geojson'));
                $data = json_decode($geojson, true);
                return $data;
            case 'api/geojson/data/rth':
                $geojson = file_get_contents(storage_path('app/geojson/RTH_poly_geo.geojson'));
                $data = json_decode($geojson, true);
                return $data;
            case 'api/geojson/data/jln':
                $geojson = file_get_contents(storage_path('app/geojson/jln_prov.geojson'));
                $data = json_decode($geojson, true);
                return $data;
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
