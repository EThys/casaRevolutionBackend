<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Http\Resources\CommuneCollection;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Commune::query()->when(false, function ($q) {
            return $q->where('is_active', false);
        })->with("district", "quartier")->orderBy('CommuneId', 'asc')->get();
        if ($data->count() != 0) {
            return new CommuneCollection($data);
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
    public function show(Commune $commune)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commune $commune)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commune $commune)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commune $commune)
    {
        //
    }
}
