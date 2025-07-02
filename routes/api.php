<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyVisitController;
use App\Http\Controllers\PropertyFeatureController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BailleurController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\TypeCardController;

//ROUTES POUR L'AUTHENTIFICATION
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

//ROUTES POUR LES PROPRIETES
Route::get('properties', [PropertyController::class, 'index']);
Route::get('properties/{id}', [PropertyController::class, 'show']);

//ROUTES POUR LES FONCTIONNALITES
Route::get('features', [PropertyFeatureController::class, 'index']);
Route::get('features/{feature}', [PropertyFeatureController::class, 'show']);
Route::get('features/{feature}/properties', [PropertyFeatureController::class, 'properties']);

//ROUTES POUR LES PROPERTYTYPE
Route::get('property', [PropertyTypeController::class, 'index']);
Route::get('property/{propertyType}', [PropertyTypeController::class, 'show']);
Route::get('propertyType/{propertyTypeId}/properties', [PropertyTypeController::class, 'getPropertiesByType']);

//ROUTES POUR BAILLEUR parrainage
Route::resource('bailleur', BailleurController::class)->only(['index', 'store']);
//ROUTES POUR TypeCard
Route::resource('type-card', TypeCardController::class)->only(['index']);
Route::middleware('auth:sanctum')->group(function () {
    //ROUTES POUR L'AUTHENTIFICATION
    Route::get('profile', [AuthController::class, 'profile']);
    Route::put('profile', [AuthController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::delete('delete-account', [AuthController::class, 'deleteAccount']);

    //ROUTES POUR LES FONCTIONNALITES
    Route::post('features', [PropertyFeatureController::class, 'store']);
    Route::put('features/{feature}', [PropertyFeatureController::class, 'update']);
    Route::delete('features/{feature}', [PropertyFeatureController::class, 'destroy']);

    //ROUTES POUR LES PROPRIETES
    Route::post('properties', [PropertyController::class, 'store']);
    Route::put('properties/{id}', [PropertyController::class, 'update']);
    Route::delete('properties/{id}', [PropertyController::class, 'destroy']);

    //ROUTES POUR LES RESERVATIONS
    Route::get('visits/status/{status}', [PropertyVisitController::class, 'getByStatus']);
    Route::put('visits/{id}/status', [PropertyVisitController::class, 'changeStatus']);
    Route::post('visit', [PropertyVisitController::class, 'store']);

    //ROUTES POUR LES PROPERTYTYPE

    Route::post('propertyType', [PropertyTypeController::class, 'store']);
    Route::put('propertyType/{propertyType}', [PropertyTypeController::class, 'update']);
    Route::delete('propertyType/{propertyType}', [PropertyTypeController::class, 'destroy']);
});
