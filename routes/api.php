<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\StatistiqueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [authController::class, 'logout']);


// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reclamations', [ReclamationController::class, 'index']);
    Route::post('/reclamations', [ReclamationController::class, 'store']);
    Route::get('/reclamations/{id}', [ReclamationController::class, 'show']);
// });

// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/stats', [StatistiqueController::class, 'index']);
    Route::get('/stats/user/{id}', [StatistiqueController::class, 'reclamationsParUtilisateur']);
// });

Route::put('/reclamations/{id}/assign-technicien', [ReclamationController::class, 'assignTechnicien']);
Route::put('/reclamations/{id}/cloturer', [ReclamationController::class, 'cloturerReclamation']);
Route::get('/statistiques/utilisateurs', [StatistiqueController::class, 'statistiquesParRole']);

Route::middleware('auth:sanctum')->get('/mes-reclamations/{id}', [ReclamationController::class, 'reclamationsParClient']);



// middleware('auth:sanctum')->
