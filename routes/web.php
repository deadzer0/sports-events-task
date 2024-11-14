<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportController;

Route::get('/', [SportController::class, 'index']);


