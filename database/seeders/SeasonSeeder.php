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
        // Взимаме всички турнири
        $tournaments = Tournament::all();

        // За всеки турнир създаваме по един сезон 2024/2025
        foreach ($tournaments as $tournament) {
            Season::create([
                'tournament_id' => $tournament->id,
                'name' => '2024/2025',
                'start_date' => Carbon::create(2024, 8, 1),  // 1 Август 2024
                'end_date' => Carbon::create(2025, 5, 31),   // 31 Май 2025
                'status' => 'active'
            ]);
        }
    }
}
