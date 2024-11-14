<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tournament;

class TournamentSeeder extends Seeder
{
    public function run(): void
    {
        $tournaments = [
            [
                'name' => 'Premier League',
                'description' => 'English Premier League Championship',
                'sport_type' => 'Football'
            ],
            [
                'name' => 'La Liga',
                'description' => 'Spanish La Liga Championship',
                'sport_type' => 'Football'
            ]
        ];

        foreach ($tournaments as $tournament) {
            Tournament::create($tournament);
        }
    }
}
