<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReclamationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [authController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reclamations', [ReclamationController::class, 'index']);
    Route::post('/reclamations', [ReclamationController::class, 'store']);
    Route::get('/reclamations/{id}', [ReclamationController::class, 'show']);
});


