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
                'first_name'   => 'required|string|max:255',
                'last_name'    => 'required|string|max:255',
                'phone'        => 'string|unique:TBailleurs,phone',
                'email'        => 'string|unique:TBailleurs,email',
                'address'      => 'string',
                'images'       => 'nullable|string',
                'card_front'   => 'nullable|string',
                'card_back'    => 'nullable|string',
                'ParrainId'    => 'int',
                'UserId'       => 'int',
                'number_card'  => 'string|unique:TBailleurs,number_card',
                'note'         => 'string',
                'TypeCardId'   => 'int',
                'fullname'     => 'nullable|string|unique:TBailleurs,fullname'
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($sideEffect) {
                $data['error'] = implode(' ', $errors->all());
                return $data;
            }
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors'  => implode(' ', $errors->all())
            ], 422);
        }

        $path_image = "";
        $path_back_card = "";
        $path_front_card = "";

        if ($request->filled('images')) {
            $decoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->images));
            if ($decoded === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'image principale est invalide'
                ], 422);
            }

            $imageName = 'bailleur_' . uniqid() . '.jpg';
            Storage::disk('public')->put('bailleur/' . $imageName, $decoded);
            $path_image = 'bailleur/' . $imageName;
        }

        // Carte frontale (unique)
        if ($request->filled('card_front')) {
            $decoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->card_front));
            if ($decoded === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'image de la carte frontale est invalide'
                ], 422);
            }

            $imageName = 'card_front_' . uniqid() . '.jpg';
            Storage::disk('public')->put('bailleur/card/' . $imageName, $decoded);
            $path_front_card = 'bailleur/card/' . $imageName;
        }

        // Carte arrière (unique)
        if ($request->filled('card_back')) {
            $decoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->card_back));
            if ($decoded === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'image de la carte arrière est invalide'
                ], 422);
            }

            $imageName = 'card_back_' . uniqid() . '.jpg';
            Storage::disk('public')->put('bailleur/card/' . $imageName, $decoded);
            $path_back_card = 'bailleur/card/' . $imageName;
        }


        $request['fullname'] = "$request->first_name $request->last_name";

        try {
            $message = "Ce bailleur est déjà parrainé dans la plateforme";

            if (Bailleur::where("fullname", $request['fullname'])->count() == 0) {
                $bailleur = Bailleur::create($request->except(['images', 'card_front', 'card_back']));
                $bailleur->update([
                    'images'     => $path_image,
                    'card_front' => $path_front_card,
                    'card_back'  => $path_back_card
                ]);

                if ($sideEffect) {
                    $data['error'] = "";
                    $data['sys'] = "";
                    $data['bailleur'] = $bailleur;
                    return $data;
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Bailleur parrainé avec succès',
                    'data'    => $bailleur
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
