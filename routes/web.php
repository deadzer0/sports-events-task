<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportController;

Route::get('/', [SportController::class, 'index']);
Route::get('/test-rabbit', [\App\Http\Controllers\MatchController::class, 'sendUpdate']);


