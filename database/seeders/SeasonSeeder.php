<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tournament;
use App\Models\Season;
use Carbon\Carbon;

class SeasonSeeder extends Seeder
{
    public function run(): void
    {
        // Get all Tournaments
        $tournaments = Tournament::all();

        // Create one season 2024/2025 for each tournament
        foreach ($tournaments as $tournament) {
            Season::create([
                'tournament_id' => $tournament->id,
                'name' => '2024/2025',
                'start_date' => Carbon::create(2024, 8, 1),  // 1 August 2024
                'end_date' => Carbon::create(2025, 5, 31),   // 31 May 2025
                'status' => 'active'
            ]);
        }
    }
}
