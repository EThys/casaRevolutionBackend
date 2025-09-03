<?php

namespace App\Http\Controllers;

use App\Models\PropertyFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyFavoriteController extends Controller
{
    /**
     * Lister tous les favoris
     */
    public function index()
    {
        $favorites = PropertyFavorite::with(['user', 'property'])->get();

        return response()->json([
            'success' => true,
            'data' =>  $favorites->load(['property.images', 'user'])
        ]);
    }

    /**
     * Obtenir tous les favoris d'un utilisateur spécifique
     */
    public function getById($userId)
    {
        $validator = Validator::make(['UserId' => $userId], [
            'UserId' => 'required|integer|exists:TUsers,UserId',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $favorites = PropertyFavorite::with('property')
            ->where('UserId', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $favorites->load(['property.images', 'user']),
        ]);
    }

        /**
     * Ajouter une propriété aux favoris d'un utilisateur
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'UserId' => 'required|integer|exists:TUsers,UserId',
            'PropertyId' => 'required|integer|exists:TProperties,PropertyId',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Vérifier si le favori existe déjà
        $existingFavorite = PropertyFavorite::where('UserId', $request->UserId)
            ->where('PropertyId', $request->PropertyId)
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'success' => false,
                'message' => 'Cette propriété est déjà dans vos favoris',
            ], 409);
        }

        $favorite = PropertyFavorite::create([
            'UserId' => $request->UserId,
            'PropertyId' => $request->PropertyId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Propriété ajoutée aux favoris avec succès',
            'data' =>   $favorite->load(['property.images', 'user'])
        ], 201);
    }

        /**
     * Supprimer une propriété des favoris d'un utilisateur
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'UserId' => 'required|integer|exists:TUsers,UserId',
            'PropertyId' => 'required|integer|exists:TProperties,PropertyId',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $favorite = PropertyFavorite::where('UserId', $request->UserId)
            ->where('PropertyId', $request->PropertyId)
            ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Cette propriété n\'est pas dans vos favoris',
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Propriété retirée des favoris avec succès',
        ]);
    }

}
