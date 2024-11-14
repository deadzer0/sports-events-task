<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'city',
        'country',
        'logo_url'
    ];

    public function homeGames(): HasMany
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames(): HasMany
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    // Method for getting all matches (home + away)
    public function allGames(): Builder
    {
        return Game::where('home_team_id', $this->id)
            ->orWhere('away_team_id', $this->id);
    }

    // Getter for full team name (City + Name)
    public function getFullNameAttribute(): string
    {
        return "{$this->city} {$this->name}";
    }
}
