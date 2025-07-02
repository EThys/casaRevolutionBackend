<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Commune;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Resources\CityCollection;
use App\Http\Resources\CommuneCollection;
use App\Http\Resources\DistrictCollection;
use App\Models\Quartier;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = [
            "commune"   => new CommuneCollection(Commune::all()),
            "ville"     => new CityCollection(City::all()),
            "district"  => new DistrictCollection(District::all()),
            "quartier"  => (Quartier::all()),
        ];
        return response()->json($data, 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
