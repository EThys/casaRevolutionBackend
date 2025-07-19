<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyVisit;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class PropertyVisitController extends Controller
{
    /**
     * Récupère toutes les visites avec pagination
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $visits = PropertyVisit::with(['property', 'user'])
                ->orderBy('visitDate', 'desc')
                ->orderBy('visitHour', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Liste des visites récupérée avec succès',
                'data' => $visits
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des visites : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des visites'
            ], 500);
        }
    }

        /**
     * Récupère toutes les visites pour un utilisateur spécifique
     *
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVisitsByUser(Request $request, $userId)
    {
        try {
            // if (!is_numeric($userId)) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'L\'ID utilisateur doit être un nombre'
            //     ], 400);
            // }

            $perPage = $request->input('per_page', 10);

            $visits = PropertyVisit::with(['property', 'user'])
                ->where('UserId', $userId)
                ->orderBy('visitDate', 'desc')
                ->orderBy('visitHour', 'desc')
                ->paginate($perPage);


            if ($visits->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Aucune visite trouvée pour cet utilisateur',
                    'data' => []
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Liste des visites de l\'utilisateur récupérée avec succès',
                'data' => $visits->load(['property.images', 'user'])
            ]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des visites utilisateur : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des visites de l\'utilisateur'
            ], 500);
        }
    }


    /**
     * Crée une nouvelle visite
     */
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'PropertyId' => 'required|exists:TProperties,PropertyId',
                'UserId' => 'nullable|exists:TUsers,UserId',
                'name' => 'required|string|max:255',
                'secondName' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'message' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'visitDate' => 'required|date|after_or_equal:today',
                'visitHour' => 'required|date_format:H:i',
                'ipAddress' => 'required|string|max:45'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $property = Property::findOrFail($request->PropertyId);
            if (!$property->isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette propriété n\'est pas disponible pour des visites'
                ], 400);
            }

            $visitDate = $request->visitDate;
            $visitHour = $request->visitHour;
            $visitDateTime = Carbon::createFromFormat('Y-m-d H:i', "$visitDate $visitHour");

            // Définir la plage ±25 minutes autour de visitDateTime
            $startWindow = $visitDateTime->copy()->subMinutes(25);
            $endWindow = $visitDateTime->copy()->addMinutes(25);

            // Vérification 1: Réservation existante dans la plage horaire
            $existingVisits = PropertyVisit::where('PropertyId', $request->PropertyId)
                ->where('visitDate', $visitDate)
                ->get()
                ->filter(function ($visit) use ($startWindow, $endWindow) {
                    $visitDateTime = Carbon::createFromFormat('Y-m-d H:i', "{$visit->visitDate} {$visit->visitHour}");
                    return $visitDateTime->between($startWindow, $endWindow);
                });

            // Vérification 2: Même personne avec visite en pending pour la même propriété
            $userPendingVisits = PropertyVisit::where('PropertyId', $request->PropertyId)
                ->where('UserId', $request->UserId)
                ->where('status', 'pending')
                ->exists();

            if ($userPendingVisits) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous avez déjà une visite en attente pour cette propriété'
                ], 409);
            }

            // Vérification 3: Conflit horaire avec d'autres visiteurs
            if ($existingVisits->isNotEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La plage horaire demandée est déjà réservée pour cette propriété'
                ], 409);
            }

            $visit = PropertyVisit::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Visite planifiée avec succès',
                'data' => $visit->load(['property', 'user'])
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Propriété non trouvée'
            ], 404);
        } catch (Exception $e) {
            Log::error('Erreur lors de la création de la visite : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la planification de la visite'
            ], 500);
        }
    }


    /**
     * Affiche une visite spécifique
     */
    public function show($id)
    {
        try {
            $visit = PropertyVisit::with(['property', 'user'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Visite récupérée avec succès',
                'data' => $visit
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Visite non trouvée'
            ], 404);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération de la visite : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération de la visite'
            ], 500);
        }
    }

    /**
     * Met à jour une visite existante
     */
    public function update(Request $request, $id)
    {
        try {
            $visit = PropertyVisit::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'PropertyId' => 'sometimes|exists:TProperties,PropertyId',
                'UserId' => 'nullable|exists:TUsers,UserId',
                'name' => 'sometimes|string|max:255',
                'secondName' => 'nullable|string|max:255',
                'email' => 'sometimes|email|max:255',
                'phone' => 'sometimes|string|max:20',
                'message' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'visitDate' => 'sometimes|date|after_or_equal:today',
                'visitHour' => 'sometimes|date_format:H:i',
                'ipAddress' => 'sometimes|string|max:45'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->has('PropertyId') && $request->PropertyId != $visit->PropertyId) {
                $property = Property::findOrFail($request->PropertyId);
                if (!$property->isAvailable) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cette propriété n\'est pas disponible pour des visites'
                    ], 400);
                }
            }

            $visit->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Visite mise à jour avec succès',
                'data' => $visit->load(['property', 'user'])
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Visite non trouvée'
            ], 404);
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour de la visite : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la mise à jour de la visite'
            ], 500);
        }
    }

        /**
     * Récupère les visites selon leur statut
     */
    public function getByStatus(Request $request, $status)
    {
        try {
            // Valider le statut
            if (!in_array($status, ['pending', 'validated', 'cancelled'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Statut non valide. Les statuts possibles sont: pending, validated, cancelled'
                ], 400);
            }

            $perPage = $request->input('per_page', 10);

            $visits = PropertyVisit::with(['property', 'user'])
                ->where('status', $status)
                ->orderBy('visitDate', 'desc')
                ->orderBy('visitHour', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => "Liste des visites avec statut $status récupérée avec succès",
                'data' => $visits
            ]);

        } catch (Exception $e) {
            Log::error("Erreur lors de la récupération des visites avec statut $status : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Échec de la récupération des visites avec statut $status"
            ], 500);
        }
    }

    /**
     * Change le statut d'une visite (validation ou annulation)
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $visit = PropertyVisit::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:validated,cancelled',
                'cancellation_reason' => 'required_if:status,cancelled|string|max:255|nullable'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Vérifier si le changement de statut est valide
            if ($visit->status === 'cancelled' && $request->status !== 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Une visite annulée ne peut pas être modifiée'
                ], 400);
            }

            // Mettre à jour le statut
            $visit->status = $request->status;

            // Si annulation, enregistrer la raison
            if ($request->status === 'cancelled' && $request->has('cancellation_reason')) {
                $visit->message = $visit->message
                    ? $visit->message . "\n\n[ANNULATION]: " . $request->cancellation_reason
                    : "[ANNULATION]: " . $request->cancellation_reason;
            }

            $visit->save();

            return response()->json([
                'success' => true,
                'message' => "Statut de la visite mis à jour avec succès",
                'data' =>   $visit->load(['property.images', 'user'])

            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Visite non trouvée'
            ], 404);
        } catch (Exception $e) {
            Log::error('Erreur lors du changement de statut de la visite : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la mise à jour du statut de la visite'
            ], 500);
        }
    }

    /**
     * Supprime une visite
     */
    public function destroy($id)
    {
        try {
            $visit = PropertyVisit::findOrFail($id);
            $visit->delete();

            return response()->json([
                'success' => true,
                'message' => 'Visite supprimée avec succès'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Visite non trouvée'
            ], 404);
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression de la visite : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la suppression de la visite'
            ], 500);
        }
    }

    /**
     * Récupère les visites à venir
     */
    public function upcoming()
    {
        try {
            $now = Carbon::now();
            $visits = PropertyVisit::with(['property', 'user'])
                ->whereDate('visitDate', '>=', $now->toDateString())
                ->orderBy('visitDate')
                ->orderBy('visitHour')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Visites à venir récupérées avec succès',
                'data' => $visits
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des visites à venir : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des visites à venir'
            ], 500);
        }
    }

    /**
     * Récupère les visites passées
     */
    public function past()
    {
        try {
            $now = Carbon::now();
            $visits = PropertyVisit::with(['property', 'user'])
                ->whereDate('visitDate', '<', $now->toDateString())
                ->orderBy('visitDate', 'desc')
                ->orderBy('visitHour', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Visites passées récupérées avec succès',
                'data' => $visits
            ]);

        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des visites passées : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération des visites passées'
            ], 500);
        }
    }
}
