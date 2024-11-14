<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'home_team_score',
        'away_team_score',
        'additional_stats'
    ];

    protected $casts = [
        'additional_stats' => 'json'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    // Check if the game is a draw
    public function isDraw(): bool
    {
        return $this->home_team_score === $this->away_team_score;
    }

    // Get result as string (for example: "4:2")
    public function getScoreAttribute(): string
    {
        return "{$this->home_team_score}:{$this->away_team_score}";
    }

    // Determine the winner (returns 'home', 'away' or null for a draw)
    public function getWinnerAttribute(): ?string
    {
        if ($this->isDraw()) {
            return null;
        }
        return $this->home_team_score > $this->away_team_score ? 'home' : 'away';
    }

    // Get the winner as team (Team model)
    public function getWinningTeamAttribute(): ?Team
    {
        if ($this->isDraw()) {
            return null;
        }
        return $this->home_team_score > $this->away_team_score
            ? $this->game->homeTeam
            : $this->game->awayTeam;
    }
}
