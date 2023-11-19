<?php

namespace App\Models;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Tournament extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin',
        'title',
    ];

    /**
     * Get the players for the tournament.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Get the games for the tournament.
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function getGamesByPairing(Player $player, Player $opponent): Collection
    {
        return $this->games
            ->filter(function (Game $game) use ($player, $opponent) {
                $gamePlayers = json_decode($game->players);
                return in_array($player->id, $gamePlayers) && in_array($opponent->id, $gamePlayers);
            });
    }

    public function getPlayersByScore(): Collection {
        return $this->players->sortBy(fn($p)=>$p->getScore())->reverse();
    }
}
