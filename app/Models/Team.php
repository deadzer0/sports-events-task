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

    // Метод за взимане на всички мачове (домакин + гост)
    public function allGames(): Builder
    {
        return Game::where('home_team_id', $this->id)
            ->orWhere('away_team_id', $this->id);
    }

    // Getter за пълното име на отбора (Град + Име)
    public function getFullNameAttribute(): string
    {
        return "{$this->city} {$this->name}";
    }
}
