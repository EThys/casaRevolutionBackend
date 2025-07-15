<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class BailleurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $data = Bailleur::with('user', 'type_card', 'parrain')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des bailleurs récupérées avec succès',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des bailleurs : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des bailleurs',
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
    public function store(Request $request, bool $sideEffect = false)
    {
        $data['error'] = "";
        $data['sys'] = "";
        $validator = Validator::make(
            $request->all(),
            [
                'first_name'        => 'required|string|max:255',
                'last_name'         => 'required|string|max:255',
                'phone'             => 'string|unique:TBailleurs,phone',
                'email'             => 'string|unique:TBailleurs,email',
                'address'           => 'string',
                'images'            => 'nullable|array',
                'images.*.base64'   => 'required_with:images|nullable|string',
                'images.*.isMain'   => 'boolean',
                'ParrainId'         => 'int',
                'UserId'            => 'int',
                'number_card'       => 'string|unique:TBailleurs,number_card',
                'note'              => 'string',
                'TypeCardId'        => 'int',
                'fullname'          => 'nullable|string|unique:TBailleurs,fullname'
            ]
        );

        $path = "";
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($sideEffect) {
                $data['error'] = implode(' ', $validator->errors()->all()) ?? "";
                return $data;
            }
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => implode(' ', $validator->errors()->all())
            ], 422);
        }

        // Traitement de l'image
        if ($request->images) {
            $image = base64_decode($request->images['base64']);
            if ($image === false) {
                if ($sideEffect) {
                    $data['error'] = 'Données d\'image base64 invalides';
                    return $data;
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Données d\'image base64 invalides'
                ], 422);
            }
            $imageName = 'bailleur_' . uniqid() . '.jpg';
            try {
                Storage::disk('public')->put('bailleur/' . $imageName, $image);
                $path = 'bailleur/' . $imageName;
            } catch (Exception $e) {
                Log::error('Erreur de stockage d\'image : ' . $e->getMessage());
            }
        }

        $request['fullname'] = "$request->first_name $request->last_name";

        try {
            $message = "Ce bailleur est déjà parrainé dans la plateforme";

            // Vérifier si le bailleur existe déjà
            if (count(Bailleur::where("fullname", $request['fullname'])->get()) == 0) {
                // Créer le bailleur
                $bailleur = Bailleur::create($request->except(['images']));

                // Mettre à jour l'image si elle existe
                if ($path) {
                    $bailleur->update(['images' => $path]);
                }

                if ($bailleur) {
                    if ($sideEffect) {
                        $data['error'] = "";
                        $data['sys'] = "";
                        $data['bailleur'] = $bailleur; // Ajouter les données du bailleur
                        return $data;
                    }
                    return response()->json([
                        'success' => true,
                        'message' => 'Bailleur parrainé avec succès',
                        'data' => $bailleur // Retourner les données du bailleur
                    ], 201);
                }
            }

            if ($sideEffect) {
                $data['error'] = $message;
                return $data;
            }
            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);

        } catch (\Throwable $e) {
            Log::error('Erreur de parrainnage : ' . $e->getMessage());

            if ($sideEffect) {
                $data['error'] = 'Erreur lors du parrainage';
                return $data;
            }
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du parrainage'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bailleur $bailleur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bailleur $bailleur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bailleur $bailleur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bailleur $bailleur)
    {
        //
    }
}
