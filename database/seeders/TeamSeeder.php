<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            // Premier League отбори
            [
                'name' => 'Manchester United',
                'city' => 'Manchester',
                'country' => 'England',
            ],
            [
                'name' => 'Liverpool',
                'city' => 'Liverpool',
                'country' => 'England',
            ],
            [
                'name' => 'Arsenal',
                'city' => 'London',
                'country' => 'England',
            ],
            [
                'name' => 'Chelsea',
                'city' => 'London',
                'country' => 'England',
            ],
            // La Liga отбори
            [
                'name' => 'Barcelona',
                'city' => 'Barcelona',
                'country' => 'Spain',
            ],
            [
                'name' => 'Real Madrid',
                'city' => 'Madrid',
                'country' => 'Spain',
            ],
            [
                'name' => 'Atletico Madrid',
                'city' => 'Madrid',
                'country' => 'Spain',
            ],
            [
                'name' => 'Sevilla',
                'city' => 'Sevilla',
                'country' => 'Spain',
            ],
            [
                'name' => 'Valencia',
                'city' => 'Valencia',
                'country' => 'Spain',
            ]
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
