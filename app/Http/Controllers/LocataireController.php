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
    public function store(Request $request, bool $sideEffect = false)
    {
        $data['error'] = null;
        $data['sys']   = "";
        $validator = Validator::make(
            $request->all(),
            [
                'first_name'            => 'required|string|max:255',
                'last_name'             => 'required|string|max:255',
                'phone'                 => 'string|unique:TBailleurs,phone',
                'email'                 => 'string|unique:TBailleurs,email',
                'address'               => 'string',
                'images'                => 'nullable|array',
                'images.*.base64'       => 'required_with:images|nullable|string',
                'images.*.isMain'       => 'boolean',
                'UserId'                => 'int',
                'number_card'           => 'string|unique:TBailleurs,number_card',
                'card_front'            => 'nullable|array',
                'card_front.*.base64'   => 'required_with:images|nullable|string',
                'card_front.*.isMain'   => 'boolean',
                'card_back'             => 'nullable|array',
                'card_back.*.base64'    => 'required_with:images|nullable|string',
                'card_back.*.isMain'    => 'boolean',
                'note'                  => 'string',
                'TypeCardId'            => 'int',
                'fullname'              => 'nullable|string|unique:TBailleurs,fullname'
            ]
        );

        $path = "";
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($sideEffect) {
                $data['error'] = implode(' ', $validator->errors()->all()) ?? "";
                return;
            }
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => implode(' ', $validator->errors()->all())
            ], 422);
        }
        if ($request->images) {
            $image = base64_decode($request->images['base64']);
            if ($image === false) {
                if ($sideEffect) {
                    $data['error'] = 'Données d\'image base64 invalides';
                    return $data['error'];
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Données d\'image base64 invalides'
                ], 422);
            }
            $imageName = 'locataire_' . uniqid() . '.jpg';
            try {
                Storage::disk('public')->put('locataire/' . $imageName, $image);
                $path = 'properties/' . $imageName;
            } catch (Exception $e) {
                Log::error('Erreur de stockage d\'image : ' . $e->getMessage());
            }
        }

        $request['fullname'] = "$request->first_name $request->last_name";
        try {
            $message = "Ce Locataire existe dans la plateforme";
            if (count(Locataire::where("fullname", $request['fullname'])->get()) == 0) {
                $locataire = (Locataire::create($request->except(['images'])))->update(['images' => $path]);
                if ($locataire) {
                    if ($sideEffect) {
                        $data['error'] = "";
                        $data['sys'] = Locataire::where("fullname", $request['fullname'])->get();
                        return $data;
                    }
                    return response()->json([
                        'success' => true,
                        'message' => 'Locataire créée avec succès'
                    ], 201);
                }
            }
            if ($sideEffect) {
                $data['error'] = $message;
                return $data['error'];
            }
            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Erreur de Locataire  : ' . $e->getMessage());
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
