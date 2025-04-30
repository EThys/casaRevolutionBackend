<?php

namespace App\Http\Controllers;

use App\Models\PropertyFeature;
use Illuminate\Http\Request;

class PropertyFeatureController extends Controller
{
    /**
     * Affiche la liste des fonctionnalités
     */
    public function index()
    {
        $features = PropertyFeature::all();
        return response()->json([
            'success' => true,
            'message' => 'Liste des fonctionnalités récupérée avec succès',
            'data' => $features
        ]);
    }

    /**
     * Crée une nouvelle fonctionnalité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $feature = PropertyFeature::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fonctionnalité créée avec succès',
            'data' => $feature
        ], 201);
    }

    /**
     * Affiche une fonctionnalité spécifique
     */
    public function show(PropertyFeature $propertyFeature)
    {
        return response()->json([
            'success' => true,
            'message' => 'Détails de la fonctionnalité récupérés avec succès',
            'data' => $propertyFeature
        ]);
    }

    /**
     * Met à jour une fonctionnalité
     */
    public function update(Request $request, PropertyFeature $propertyFeature)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $propertyFeature->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fonctionnalité mise à jour avec succès',
            'data' => $propertyFeature
        ]);
    }

    /**
     * Supprime une fonctionnalité
     */
    public function destroy(PropertyFeature $propertyFeature)
    {
        $propertyFeature->delete();
        return response()->json([
            'success' => true,
            'message' => 'Fonctionnalité supprimée avec succès'
        ], 204);
    }

    /**
     * Récupère les propriétés associées à une fonctionnalité
     */
    public function properties(PropertyFeature $propertyFeature)
    {
        $properties = $propertyFeature->properties()->with(['propertyType', 'user', 'images'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Propriétés associées à cette fonctionnalité récupérées avec succès',
            'data' => $properties,
            'feature' => [
                'id' => $propertyFeature->PropertyFeatureId,
                'name' => $propertyFeature->name
            ]
        ]);
    }
}
