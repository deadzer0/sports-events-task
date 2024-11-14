<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SportDataController;

Route::prefix('v1')->group(function () {
    Route::get('/sport-data', [SportDataController::class, 'index']);
});
