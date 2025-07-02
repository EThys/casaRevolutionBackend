<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Resources\DistrictCollection;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = District::with("city", "commune")->get();
        if ($data->count() != 0) {
            return new DistrictCollection($data);
        }
        return response()->json([
            "message" => "Ressource not found",
        ], 400);
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
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district)
    {
        //
    }
}
