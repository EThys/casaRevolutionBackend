<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Enregistrement d'un nouvel utilisateur
     */

     public function register(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'email' => 'required|string|email|max:255|unique:TUsers,email',
             'password' => 'required',
             'TypeAccountId' => 'required|integer|in:1,2,3,4',
             'CityId' => 'int',
             'postal_code' => 'nullable|string|max:20',
             'country' => 'nullable|string|max:100',
             'date_of_birth' => 'nullable|date|before_or_equal:today',
             'gender' => 'nullable|in:male,female,other',
             'profile_picture' => 'nullable|string', // Base64 string
             'bio' => 'nullable|string|max:500',
             'is_agent' => 'nullable|boolean',
             'is_admin' => 'nullable|boolean',
         ]);

         if ($validator->fails()) {
             $errors = $validator->errors();

             // Personnalisation des messages d'erreur
             if ($errors->has('email')) {
                 return response()->json([
                     'success' => false,
                     'message' => 'Cet email est déjà utilisé.',
                     'errors' => $errors->get('email')
                 ], 422);
             }

             if ($errors->has('password')) {
                 return response()->json([
                     'success' => false,
                     'message' => 'Le mot de passe est invalide. Il doit contenir au moins 8 caractères et être confirmé.',
                     'errors' => $errors->get('password')
                 ], 422);
             }

             return response()->json([
                 'success' => false,
                 'message' => 'Erreur de validation',
                 'errors' => $errors->all()
             ], 422);
         }

         try {
             $userData = [
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'CityId' => $request->CityId,
                 'username' => $request->first_name . $request->last_name,
                 'postal_code' => $request->postal_code,
                 'TypeAccountId' => $request->TypeAccountId,
                 'country' => $request->country,
                 'date_of_birth' => $request->date_of_birth ? Carbon::parse($request->date_of_birth) : null,
                 'gender' => $request->gender,
                 'bio' => $request->bio,
                 'is_agent' => $request->is_agent ?? false,
                 'is_admin' => $request->is_admin ?? false,
             ];

             // Gestion de l'image de profil en base64 - Version améliorée inspirée du premier code
             if ($request->profile_picture) {
                 $imageData = base64_decode($request->profile_picture);

                 if ($imageData === false) {
                     return response()->json([
                         'success' => false,
                         'message' => 'Erreur lors du décodage de l\'image Base64.'
                     ], 400);
                 }

                 // Déterminer le type MIME et l'extension
                 $finfo = finfo_open(FILEINFO_MIME_TYPE);
                 $mime_type = finfo_buffer($finfo, $imageData);
                 finfo_close($finfo);

                 $extension = 'jpg'; // par défaut
                 switch ($mime_type) {
                     case 'image/jpeg':
                         $extension = 'jpg';
                         break;
                     case 'image/png':
                         $extension = 'png';
                         break;
                     case 'image/gif':
                         $extension = 'gif';
                         break;
                     case 'image/webp':
                         $extension = 'webp';
                         break;
                 }

                 $fileName = time() . '_' . uniqid() . '.' . $extension;
                 $path = 'profile_pictures/' . $fileName;

                 if (!Storage::disk('public')->put($path, $imageData)) {
                     return response()->json([
                         'success' => false,
                         'message' => 'Erreur lors de l\'enregistrement de l\'image.'
                     ], 500);
                 }

                 $userData['profile_picture'] = $path;
             }

             $user = User::create($userData);
             $token = $user->createToken('auth_token')->plainTextToken;

             switch ($request->TypeAccountId) {
                 case 1: {
                     $request->merge(['UserId' => $user->UserId]);
                     $data = (new BailleurController())->store($request, true);
                     if ($data['error'] !== null && $data['error'] != "") {
                         User::destroy($user->UserId);
                         return response()->json([
                             "message" => $data['error']
                         ], 422);
                     }
                     break;
                 }
                 case 2: {
                     $request->merge(['UserId' => $user->UserId]);
                     $data = (new LocataireController())->store($request, true);
                     if ($data['error'] != "") {
                         User::destroy($user->UserId);
                         return response()->json([
                             "message" => $data['error']
                         ], 422);
                     }
                     break;
                 }
                 case 3: {
                     $request->merge(['UserId' => $user->UserId]);
                     $data = (new CommissionnaireController())->store($request, true);
                     if ($data['error'] != "") {
                         User::destroy($user->UserId);
                         return response()->json([
                             "message" => $data['error']
                         ], 422);
                     }
                     break;
                 }
             }

             return response()->json([
                 'success' => true,
                 'message' => 'Utilisateur enregistré avec succès',
                 'data' => [
                     'user' => $user,
                     'token' => $token,
                     'token_type' => 'Bearer'
                 ]
             ], 201);
         } catch (\Exception $e) {
             Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
             return response()->json([
                 'success' => false,
                 'message' => 'Échec de l\'enregistrement'
             ], 500);
         }
     }



    /**
     * Traitement de l'image en base64
     */
    private function processBase64Image($base64String)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            $imageType = $matches[1];
            $allowedTypes = ['jpeg', 'png', 'jpg', 'gif'];

            if (!in_array($imageType, $allowedTypes)) {
                return null;
            }

            $data = substr($base64String, strpos($base64String, ',') + 1);
            $data = base64_decode($data);

            if ($data === false) {
                return null;
            }

            return [
                'data' => $data,
                'extension' => $imageType
            ];
        }

        return null;
    }

    /**
     * Connexion de l'utilisateur
     */

     public function login(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'email' => 'required', // Peut être email ou téléphone
             'password' => 'required',
         ]);

         if ($validator->fails()) {
             return response()->json([
                 'success' => false,
                 'message' => 'Erreur de validation',
                 'errors' => implode(' ', $validator->errors()->all())
             ], 422);
         }

         $identifier = $request->input('email');
         $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

         // Recherche de l'utilisateur par email ou téléphone
         $user = User::where($field, $identifier)->first();

         if (!$user) {
             // Utilisateur non trouvé
             return response()->json([
                 'success' => false,
                 'message' => 'Aucun compte trouvé avec cet identifiant.'
             ], 404);
         }

         // Vérification du mot de passe
         if (!Hash::check($request->password, $user->password)) {
             return response()->json([
                 'success' => false,
                 'message' => 'Mot de passe incorrect.'
             ], 401);
         }

         try {
             $token = $user->createToken('auth_token')->plainTextToken;

             $user->update([
                 'last_login_at' => now(),
                 'last_login_ip' => $request->ip()
             ]);

             return response()->json([
                 'success' => true,
                 'message' => 'Connexion réussie',
                 'data' => [
                     'user' => $user,
                     'token' => $token,
                     'token_type' => 'Bearer'
                 ]
             ]);
         } catch (\Exception $e) {
             Log::error('Erreur de connexion : ' . $e->getMessage());
             return response()->json([
                 'success' => false,
                 'message' => 'Échec de la connexion'
             ], 500);
         }
     }




    /**
     * Récupérer le profil utilisateur
     */
    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            return response()->json([
                'success' => true,
                'message' => 'Profil utilisateur récupéré avec succès',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur de récupération du profil : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la récupération du profil'
            ], 500);
        }
    }

    /**
     * Mettre à jour le profil utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:TUsers,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|string', // Base64 string
            'bio' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = $request->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'city',
                'postal_code',
                'country',
                'date_of_birth',
                'gender',
                'bio'
            ]);

            // Gestion de l'image de profil en base64
            if ($request->profile_picture) {
                // Supprimer l'ancienne image si elle existe
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $imageData = $this->processBase64Image($request->profile_picture);
                if ($imageData) {
                    $path = 'profile_pictures/' . uniqid() . '.' . $imageData['extension'];
                    Storage::disk('public')->put($path, $imageData['data']);
                    $updateData['profile_picture'] = $path;
                }
            }

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Profil mis à jour avec succès',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur de mise à jour du profil : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la mise à jour du profil'
            ], 500);
        }
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Déconnexion réussie'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur de déconnexion : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la déconnexion'
            ], 500);
        }
    }

    /**
     * Changement de mot de passe
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le mot de passe actuel est incorrect'
                ], 401);
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mot de passe changé avec succès'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur de changement de mot de passe : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec du changement de mot de passe'
            ], 500);
        }
    }

    /**
     * Demande de réinitialisation de mot de passe
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['success' => true, 'message' => 'Lien de réinitialisation envoyé avec succès'])
                : response()->json(['success' => false, 'message' => 'Impossible d\'envoyer le lien de réinitialisation'], 400);
        } catch (\Exception $e) {
            Log::error('Erreur de demande de réinitialisation : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la demande de réinitialisation'
            ], 500);
        }
    }

    /**
     * Réinitialisation du mot de passe
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET
                ? response()->json(['success' => true, 'message' => 'Mot de passe réinitialisé avec succès'])
                : response()->json(['success' => false, 'message' => 'Impossible de réinitialiser le mot de passe'], 400);
        } catch (\Exception $e) {
            Log::error('Erreur de réinitialisation : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la réinitialisation'
            ], 500);
        }
    }

    /**
     * Suppression du compte utilisateur
     */
    public function deleteAccount(Request $request)
    {
        try {
            $user = $request->user();

            // Supprimer l'image de profil si elle existe
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Supprimer tous les tokens d'accès
            $user->tokens()->delete();

            // Supprimer l'utilisateur
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Compte supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur de suppression du compte : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Échec de la suppression du compte'
            ], 500);
        }
    }
}
