<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;



class PropertyTypeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $propertyTypes = PropertyType::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Liste des types de propriété récupérée avec succès',
                'data' => $propertyTypes
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la récupération des types de propriété',
                'data' => null
            ], 500);
        }
    }

    /**
     * Crée un nouveau type de propriété
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $propertyType = PropertyType::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Type de propriété créé avec succès',
                'data' => $propertyType
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de validation',
                'data' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la création du type de propriété',
                'data' => null
            ], 500);
        }
    }

    /**
     * Affiche un type de propriété spécifique
     */
    public function show(PropertyType $propertyType): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Type de propriété récupéré avec succès',
                'data' => $propertyType
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la récupération du type de propriété',
                'data' => null
            ], 500);
        }
    }

    /**
     * Met à jour un type de propriété
     */
    public function update(Request $request, PropertyType $propertyType): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $propertyType->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Type de propriété mis à jour avec succès',
                'data' => $propertyType
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de validation',
                'data' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la mise à jour du type de propriété',
                'data' => null
            ], 500);
        }
    }

    /**
     * Supprime un type de propriété
     */
    public function destroy(PropertyType $propertyType): JsonResponse
    {
        try {
            $propertyType->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Type de propriété supprimé avec succès',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la suppression du type de propriété',
                'data' => null
            ], 500);
        }
    }

    public function getPropertiesByType($propertyTypeId): JsonResponse
    {
        try {
            $propertyType = PropertyType::with('properties')->findOrFail($propertyTypeId);

            return response()->json([
                'status' => 'success',
                'message' => 'Propriétés récupérées avec succès pour ce type',
                'data' => [
                    'property_type' => $propertyType,
                    'properties' => $propertyType->properties
                ]
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Type de propriété non trouvé',
                'data' => null
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la récupération des propriétés',
                'data' => null
            ], 500);
        }
    }
}
