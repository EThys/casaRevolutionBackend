<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Log;
use Exception;

class PropertyController extends Controller
{
    public function index()
    {
        try {
            $properties = Property::with(['propertyType', 'features', 'images', 'user'])->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des propriétés récupérée avec succès',
                'data' => $properties
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des propriétés : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des propriétés',
                'error' => 'Une erreur inattendue est survenue'
            ], 500);
        }
    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'surface' => 'required|numeric|min:0',
                'rooms' => 'required|integer|min:0',
                'bedrooms' => 'required|integer|min:0',
                'kitchen' => 'required|integer|min:0',
                'living_room'  => 'required|integer|min:0',
                'bathroom'  => 'required|integer|min:0',
                'floor' => 'nullable|integer',
                'address' => 'required|string',
                'city' => 'required|string',
                'postalCode' => 'required|string',
                'district' => 'required|string|max:255',
                'commune' => 'required|string|max:255',
                'quartier' => 'required|string|max:255',
                'sold' => 'boolean',
                'transactionType' => 'required|in:vente,location',
                'PropertyTypeId' => 'required|exists:TPropertyTypes,PropertyTypeId',
                'UserId' => 'required|exists:TUsers,UserId',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'isAvailable' => 'boolean',
                'features' => 'nullable|array',
                'features.*' => 'exists:TPropertyFeatures,PropertyFeatureId',
                'images' => 'nullable|array',
                'images.*.base64' => 'required_with:images|string',
                'images.*.isMain' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Création de la propriété
            $property = Property::create($request->except(['features', 'images']));

            if (!$property) {
                throw new Exception('Échec de la création de la propriété');
            }

            // Association des fonctionnalités
            if ($request->has('features')) {
                $property->features()->attach($request->features);
            }

            // Traitement des images
            if ($request->has('images')) {
                foreach ($request->images as $imageData) {
                    if (!isset($imageData['base64'])) {
                        continue;
                    }

                    $decodedImage = base64_decode($imageData['base64']);
                    if ($decodedImage === false) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Erreur lors du décodage de l\'image base64.'
                        ], 422);
                    }

                    // Déterminer le type MIME
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_buffer($finfo, $decodedImage);
                    finfo_close($finfo);

                    $extension = match ($mimeType) {
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/gif' => 'gif',
                        'image/webp' => 'webp',
                        default => null,
                    };

                    if (!$extension) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Format d\'image non supporté : ' . $mimeType
                        ], 422);
                    }

                    $imageName = 'property_' . $property->PropertyId . '_' . uniqid() . '.' . $extension;
                    $storagePath = 'properties/' . $imageName;

                    try {
                        Storage::disk('public')->put($storagePath, $decodedImage);
                    } catch (Exception $e) {
                        Log::error("Erreur de stockage d'image : " . $e->getMessage());
                        continue;
                    }

                    PropertyImage::create([
                        'PropertyId' => $property->PropertyId,
                        'path' => $storagePath,
                        'isMain' => $imageData['isMain'] ?? false
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Propriété créée avec succès',
                'data' => $property->load(['propertyType', 'features', 'images'])
            ], 201);

        } catch (Exception $e) {
            Log::error('Erreur de création de propriété : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la création de la propriété',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $property = Property::with(['propertyType', 'features', 'images', 'user'])->find($id);

            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Propriété non trouvée'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Propriété récupérée avec succès',
                'data' => $property
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération de la propriété : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération de la propriété',
                'error' => 'Une erreur inattendue est survenue'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $property = Property::find($id);

            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Propriété non trouvée'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric|min:0',
                'surface' => 'sometimes|numeric|min:0',
                'rooms' => 'sometimes|integer|min:0',
                'bedrooms' => 'sometimes|integer|min:0',
                'kitchen' => 'required|integer|min:0',
                'living_room'  => 'required|integer|min:0',
                'bathroom'  => 'required|integer|min:0',
                'floor' => 'nullable|integer',
                'address' => 'sometimes|string',
                'city' => 'sometimes|string',
                'postalCode' => 'sometimes|string',
                'district' => 'sometimes|string|max:255',
                'commune' => 'sometimes|string|max:255',
                'quartier' => 'sometimes|string|max:255',
                'sold' => 'boolean',
                'transactionType' => 'sometimes|in:avendre,location',
                'PropertyTypeId' => 'sometimes|exists:TPropertyTypes,PropertyTypeId',
                'UserId' => 'sometimes|exists:TUsers,UserId',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'isAvailable' => 'boolean',
                'features' => 'nullable|array',
                'features.*' => 'exists:TPropertyFeatures,PropertyFeatureId',
                'images' => 'nullable|array',
                'images.*.base64' => 'required_with:images|string',
                'images.*.isMain' => 'boolean',
                'deleted_images' => 'nullable|array',
                'deleted_images.*' => 'exists:TPropertyImages,PropertyImageId'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $errors
                ], 422);
            }

            $property->update($request->except(['features', 'images', 'deleted_images']));

            if ($request->has('features')) {
                $property->features()->sync($request->features);
            }

            if ($request->has('deleted_images')) {
                $imagesToDelete = PropertyImage::whereIn('PropertyImageId', $request->deleted_images)
                    ->where('PropertyId', $property->PropertyId)
                    ->get();

                foreach ($imagesToDelete as $image) {
                    try {
                        Storage::disk('public')->delete($image->path);
                        $image->delete();
                    } catch (Exception $e) {
                        Log::error('Erreur de suppression d\'image : ' . $e->getMessage());
                    }
                }
            }

            if ($request->has('images')) {
                foreach ($request->images as $imageData) {
                    $image = base64_decode($imageData['base64']);

                    if ($image === false) {
                        continue;
                    }

                    $imageName = 'property_' . $property->PropertyId . '_' . uniqid() . '.jpg';

                    try {
                        Storage::disk('public')->put('properties/' . $imageName, $image);
                    } catch (Exception $e) {
                        Log::error('Erreur de stockage d\'image : ' . $e->getMessage());
                        continue;
                    }

                    PropertyImage::create([
                        'PropertyId' => $property->PropertyId,
                        'path' => 'properties/' . $imageName,
                        'isMain' => $imageData['isMain'] ?? false
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Propriété mise à jour avec succès',
                'data' => $property->load(['propertyType', 'features', 'images'])
            ]);

        } catch (Exception $e) {
            Log::error('Erreur de mise à jour de propriété : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la mise à jour de la propriété',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $property = Property::find($id);

            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Propriété non trouvée'
                ], 404);
            }

            foreach ($property->images as $image) {
                try {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                } catch (Exception $e) {
                    Log::error('Erreur de suppression d\'image : ' . $e->getMessage());
                }
            }

            $property->features()->detach();
            $property->delete();

            return response()->json([
                'success' => true,
                'message' => 'Propriété supprimée avec succès'
            ]);

        } catch (Exception $e) {
            Log::error('Erreur de suppression de propriété : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la suppression de la propriété',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}