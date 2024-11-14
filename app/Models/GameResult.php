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

    // Проверка дали мача е равен
    public function isDraw(): bool
    {
        return $this->home_team_score === $this->away_team_score;
    }

    // Вземане на резултата като стринг (пример: "4:2")
    public function getScoreAttribute(): string
    {
        return "{$this->home_team_score}:{$this->away_team_score}";
    }

    // Определяне на победителя (връща 'home', 'away' или null при равен)
    public function getWinnerAttribute(): ?string
    {
        if ($this->isDraw()) {
            return null;
        }
        return $this->home_team_score > $this->away_team_score ? 'home' : 'away';
    }

    // Взема победителя като отбор (Team модел)
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
