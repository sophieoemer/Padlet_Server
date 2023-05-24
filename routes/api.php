<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\PadletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Padlet;

// Diese Zeile definiert eine geschützte Route, die nur für authentifizierte Benutzer zugänglich ist.
// Der auth:sanctum Middleware wird angewendet, um sicherzustellen, dass der Benutzer authentifiziert ist.
// Wenn ein nicht authentifizierter Benutzer versucht, auf diese Route zuzugreifen, wird eine
// Fehlermeldung zurückgegeben.

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Hier werden die Routen für die API definiert, die verschiedenen
// Aktionen im Zusammenhang mit Padlets, Einträgen und Authentifizierung
// ermöglicht
// die Routen können im Postman dann unter api/'was in de Klammern steht' + Methodenname
// aufgerufen werden

    Route::post('padlets', [PadletController::class, 'save']);
    Route::put('padlets/{id}', [PadletController::class, 'update']);
    Route::delete('padlets/{id}', [PadletController::class, 'delete']);
    Route::post('entries', [EntryController::class, 'save']);
    Route::put('entries/{id}', [EntryController::class, 'update']);
    Route::delete('entries/{id}', [EntryController::class, 'delete']);


    Route::get('padlets', [PadletController::class, 'index']);
    Route::get('padlets/{id}', [PadletController::class, 'findById']);
    Route::get('padlets/checkid/{id}', [PadletController::class, 'checkId']);
    Route::get('padlets/search/{searchTerm}', [PadletController::class, 'findBySearchTerm']);


    Route::get('entries', [EntryController::class, 'index']);
    Route::get('entries/{id}', [EntryController::class, 'findById']);
    Route::get('entries/checkid/{id}', [EntryController::class, 'checkId']);
    Route::get('entries/search/{searchTerm}', [EntryController::class, 'findBySearchTerm']);

//Authentication
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/logout', [AuthController::class, 'logout']);





