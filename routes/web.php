<?php

use App\Http\Controllers\PadletController;
use App\Models\Padlet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Das waren am Anfang die Routen, die auch gleich eine passende View aufrufen
// jetzt in api.php
Route::get('/', [PadletController::class,'index']);
Route::get('/padlets', [PadletController::class,'index']);
Route::get('/padlets/{padlet}',[PadletController::class,'show']);
