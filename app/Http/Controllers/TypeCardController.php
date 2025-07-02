<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\TypeCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TypeCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = TypeCard::all();

            return response()->json([
                'success' => true,
                'message' => 'Liste des types de carte récupérées avec succès',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des types de carte : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des types de carte',
                'error' => 'Une erreur inattendue est survenue'
            ], 500);
        }
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
    public function show(TypeCard $typeCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeCard $typeCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeCard $typeCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeCard $typeCard)
    {
        //
    }
}
