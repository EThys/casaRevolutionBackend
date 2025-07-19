<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Commissionnaire;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CommissionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Commissionnaire::with('user', 'type_card')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des commissionnaires récupérées avec succès',
                'data' => $data
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des commissionnaires : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des commissionnaires',
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
        $data['sys']   = "";

        $validator = Validator::make(
            $request->all(),
            [
                'first_name'    => 'required|string|max:255',
                'last_name'     => 'required|string|max:255',
                'phone'         => 'string|unique:TBailleurs,phone',
                'email'         => 'string|unique:TBailleurs,email',
                'address'       => 'string',
                'images'        => 'nullable|string',
                'card_front'    => 'nullable|string',
                'card_back'     => 'nullable|string',
                'UserId'        => 'int',
                'number_card'   => 'string|unique:TBailleurs,number_card',
                'note'          => 'string',
                'TypeCardId'    => 'int',
                'fullname'      => 'nullable|string|unique:TBailleurs,fullname'
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            $msg = implode(' ', $errors->all()) ?? "";
            if ($sideEffect) {
                $data['error'] = $msg;
                return $data;
            }
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $msg
            ], 422);
        }

        $path_image = "";
        $path_card_front = "";
        $path_card_back = "";

        // Image principale
        if ($request->filled('images')) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->images));
            if ($image === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image principale invalide (base64)'
                ], 422);
            }
            $imageName = 'commissionnaire_' . uniqid() . '.jpg';
            Storage::disk('public')->put("commissionnaire/{$imageName}", $image);
            $path_image = "commissionnaire/{$imageName}";
        }

        // Carte recto
        if ($request->filled('card_front')) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->card_front));
            if ($image === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image carte frontale invalide (base64)'
                ], 422);
            }
            $imageName = 'card_front_' . uniqid() . '.jpg';
            Storage::disk('public')->put("commissionnaire/card/{$imageName}", $image);
            $path_card_front = "commissionnaire/card/{$imageName}";
        }

        // Carte verso
        if ($request->filled('card_back')) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->card_back));
            if ($image === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image carte arrière invalide (base64)'
                ], 422);
            }
            $imageName = 'card_back_' . uniqid() . '.jpg';
            Storage::disk('public')->put("commissionnaire/card/{$imageName}", $image);
            $path_card_back = "commissionnaire/card/{$imageName}";
        }

        // Création du fullname
        $request['fullname'] = $request->first_name . ' ' . $request->last_name;

        try {
            $message = "Ce commissionnaire est déjà enregistré.";

            if (Commissionnaire::where("fullname", $request['fullname'])->count() == 0) {
                $commissionnaire = Commissionnaire::create($request->except(['images', 'card_front', 'card_back']));
                $commissionnaire->update([
                    'images'     => $path_image,
                    'card_front' => $path_card_front,
                    'card_back'  => $path_card_back
                ]);

                if ($sideEffect) {
                    $data['error'] = "";
                    $data['sys'] = $commissionnaire;
                    return $data;
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Commissionnaire enregistré avec succès',
                    'data'    => $commissionnaire
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
            Log::error('Erreur d\'enregistrement : ' . $e->getMessage());

            if ($sideEffect) {
                $data['error'] = 'Erreur d\'enregistrement';
                return $data;
            }

            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur'
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Commissionnaire $commissionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commissionnaire $commissionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commissionnaire $commissionnaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commissionnaire $commissionnaire)
    {
        //
    }
}
