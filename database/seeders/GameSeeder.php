<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Season;
use App\Models\Team;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\GameResult;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $seasons = Season::all();
        $now = Carbon::now();

        foreach ($seasons as $season) {
            // Gets teams filtered by tournament
            $teams = $this->getTeamsForTournament($season->tournament_id);

            // 2 completed games (completed)
            for ($i = 0; $i < 2; $i++) {
                $this->createGame(
                    $season,
                    $teams,
                    $now->copy()->subDays(rand(1, 5)),
                    'completed'
                );
            }

            // 1 game in progress (today)
            $this->createGame(
                $season,
                $teams,
                $now->copy(),
                'in_progress'
            );

            // 2 scheduled games (upcoming)
            for ($i = 0; $i < 2; $i++) {
                $this->createGame(
                    $season,
                    $teams,
                    $now->copy()->addDays(rand(1, 10)),
                    'scheduled'
                );
            }
        }
    }

    private function getTeamsForTournament($tournamentId): \Illuminate\Database\Eloquent\Collection
    {
        // Premier League = 1, La Liga = 2
        $country = $tournamentId === 1 ? 'England' : 'Spain';
        return Team::where('country', $country)->get();
    }

    private function createGame($season, $teams, $startTime, $status)
    {
        // Select different teams (home/away) from same league
        $homeTeam = $teams->random();
        $awayTeam = $teams->where('id', '!=', $homeTeam->id)->random();

        // Set time to reasonable hours (between 19:00 and 21:45)
        $startTime = $startTime->setHour(rand(19, 21))->setMinute(rand(0, 45))->setSecond(0);

        $game = Game::create([
            'season_id' => $season->id,
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'start_datetime' => $startTime,
            'end_datetime' => $startTime->copy()->addMinutes(90),
            'status' => $status,
            'venue' => $homeTeam->name . ' Stadium'
        ]);

        // Create score based on status
        if ($status === 'completed') {
            GameResult::create([
                'game_id' => $game->id,
                'home_team_score' => rand(0, 5),
                'away_team_score' => rand(0, 5),
                'additional_stats' => json_encode([
                    'possession' => [
                        'home' => rand(30, 70),
                        'away' => rand(30, 70)
                    ],
                    'shots' => [
                        'home' => rand(5, 20),
                        'away' => rand(5, 20)
                    ],
                    'first_half' => [
                        'home' => rand(0, 3),
                        'away' => rand(0, 3)
                    ],
                    'second_half' => [
                        'home' => rand(0, 3),
                        'away' => rand(0, 3)
                    ]
                ])
            ]);
        } elseif ($status === 'in_progress') {
            GameResult::create([
                'game_id' => $game->id,
                'home_team_score' => rand(0, 2),
                'away_team_score' => rand(0, 2),
                'additional_stats' => json_encode([
                    'possession' => [
                        'home' => rand(30, 70),
                        'away' => rand(30, 70)
                    ],
                    'shots' => [
                        'home' => rand(3, 10),
                        'away' => rand(3, 10)
                    ]
                ])
            ]);
        }
    }
}
