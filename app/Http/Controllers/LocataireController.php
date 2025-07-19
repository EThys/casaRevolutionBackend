<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Locataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LocataireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Locataire::with('user', 'type_card')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des locataires récupérées avec succès',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des locataires : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des locataires',
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
    public function store(Request $request, bool $sideEffect = false){

        $data['error'] = null;
        $data['sys'] = "";

        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'phone'         => 'string|unique:TLocataires,phone',
            'email'         => 'string|unique:TLocataires,email',
            'address'       => 'string',
            'images'        => 'nullable|string', // base64 unique
            'card_front'    => 'nullable|string', // base64 unique
            'card_back'     => 'nullable|string', // base64 unique
            'UserId'        => 'int',
            'number_card'   => 'unique:TLocataires,number_card',
            'note'          => 'string',
            'TypeCardId'    => 'int',
            'fullname'      => 'nullable|string|unique:TLocataires,fullname'
        ]);

        if ($validator->fails()) {
            $msg = implode(' ', $validator->errors()->all());
            if ($sideEffect) {
                $data['error'] = $msg;
                return $data;
            }
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors'  => $msg
            ], 422);
        }

        $path_image = null;
        $path_card_front = null;
        $path_card_back = null;

        // Image principale
        if ($request->filled('images')) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->images));
            if ($image === false) {
                return response()->json(['success' => false, 'message' => 'Image principale invalide'], 422);
            }
            $imageName = 'locataire_' . uniqid() . '.jpg';
            Storage::disk('public')->put("locataire/{$imageName}", $image);
            $path_image = "locataire/{$imageName}";
        }

        // Carte frontale
        if ($request->filled('card_front')) {
            $front = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->card_front));
            if ($front === false) {
                return response()->json(['success' => false, 'message' => 'Image carte frontale invalide'], 422);
            }
            $frontName = 'card_front_' . uniqid() . '.jpg';
            Storage::disk('public')->put("locataire/card/{$frontName}", $front);
            $path_card_front = "locataire/card/{$frontName}";
        }

        // Carte arrière
        if ($request->filled('card_back')) {
            $back = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->card_back));
            if ($back === false) {
                return response()->json(['success' => false, 'message' => 'Image carte arrière invalide'], 422);
            }
            $backName = 'card_back_' . uniqid() . '.jpg';
            Storage::disk('public')->put("locataire/card/{$backName}", $back);
            $path_card_back = "locataire/card/{$backName}";
        }

        // Générer le fullname
        $request['fullname'] = $request->first_name . ' ' . $request->last_name;

        try {
            $message = "Ce locataire existe déjà dans la plateforme";

            if (Locataire::where("fullname", $request['fullname'])->count() == 0) {
                $locataire = Locataire::create($request->except(['images', 'card_front', 'card_back']));
                $locataire->update([
                    'images'     => $path_image,
                    'card_front' => $path_card_front,
                    'card_back'  => $path_card_back
                ]);

                if ($sideEffect) {
                    $data['sys'] = $locataire;
                    return $data;
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Locataire créé avec succès',
                    'data'    => $locataire
                ], 201);
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
            Log::error('Erreur Locataire : ' . $e->getMessage());
            if ($sideEffect) {
                $data['error'] = 'Erreur interne lors de l\'enregistrement';
                return $data;
            }

            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur interne'
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Locataire $locataire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Locataire $locataire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Locataire $locataire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Locataire $locataire)
    {
        //
    }
}
