<?php

namespace App\Models;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'tournament_id',
    ];

    /**
     * Get the tournament that owns the player.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function getScore(): float {
        return $this->tournament->games
        ->filter(fn($g)=>$g->hasPlayer($this))
        ->map(fn($g)=>$g->getPlayerResult($this))
        ->map(function($x){
            switch($x){
                case '&frac12;':
                    return 0.5;
                default:
                    return (float) $x;
            }
        })
        ->sum();
    }
}
