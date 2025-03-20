<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\CandidatureController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentification et Sécurité
Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);
Route::post("password/reset", [ApiController::class, "resetPassword"]);

// Gestion des Annonces
Route::group([
    "middleware" => ["auth:api", "check.role:recruteur"]
], function() {
    Route::post("annonces", [AnnonceController::class, "store"]); // Ajouter une annonce
    Route::put("annonces/{id}", [AnnonceController::class, "update"]); // Modifier une annonce
    Route::delete("annonces/{id}", [AnnonceController::class, "destroy"]); // Supprimer une annonce
});

// Candidatures
Route::group([
    "middleware" => ["auth:api", "check.role:candidat"]
], function() {
    Route::post("candidatures", [CandidatureController::class, "store"]); // Postuler à une annonce
    Route::delete("candidatures/{id}", [CandidatureController::class, "destroy"]); // Retirer une candidature
});

// Suivi des Candidatures
Route::group([
    "middleware" => ["auth:api", "check.role:recruteur"]
], function() {
    Route::put("candidatures/{id}/status", [CandidatureController::class, "updateStatus"]); // Mettre à jour le statut d’une candidature
});

// Récupérer les annonces pour les candidats
Route::group([
    "middleware" => ["auth:api", "check.role:candidat"]
], function() {
    Route::get("annonces", [AnnonceController::class, "index"]); // Récupérer la liste des annonces
    Route::get("annonces/{id}", [AnnonceController::class, "show"]); // Détails d'une annonce
});

// Statistiques et Rapports
Route::group([
    "middleware" => ["auth:api", "check.role:admin"]
], function() {
    Route::get("stats/annonces", [StatsController::class, "annonces"]); // Statistiques sur les annonces
    Route::get("stats/candidatures", [StatsController::class, "candidatures"]); // Statistiques sur les candidatures
});