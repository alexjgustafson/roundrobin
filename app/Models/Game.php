<?php

namespace App\Models;

use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loser', // player id that lost, nullable
        'playerResults', // object keyed by player id with result string value
        'players', // Collection of player ids
        'result', // winning player id, 'draw', nullable
        'tournament_id',
        'winner', // player id that won, nullable
    ];

    /**
     * Get the tournament that owns the game.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function getPlayerResult(Player $player): string
    {
        return json_decode($this->playerResults)->{$player->id};
    }

    public function hasPlayer(Player $player): bool
    {
        return Collection::make(json_decode($this->players))->contains($player->id);
    }
}
