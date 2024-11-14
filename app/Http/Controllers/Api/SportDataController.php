<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Season;
use App\Models\Game;
use App\Models\GameResult;
use Illuminate\Http\JsonResponse;

class SportDataController extends Controller
{
    public function index(): JsonResponse
    {
        $tournaments = Tournament::with([
            'seasons',
            'seasons.games',
            'seasons.games.homeTeam',
            'seasons.games.awayTeam',
            'seasons.games.gameResult'
        ])->get();

        return response()->json([
            'data' => $tournaments,
            'timestamp' => now()  // за да знаем кога са опреснени данните
        ]);
    }
}
