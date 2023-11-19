<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Game;
use App\Models\Player;
use App\Models\Tournament;

class GameController extends Controller
{
    /**
     * Add new game
     */
    public function create(Request $request): RedirectResponse
    {
        // Collection of player ids
        $players = Collection::make([
            (int) $request->player_one,
            (int) $request->player_two,
        ]);

        // winner id, 'draw', nullable
        $result = $request->result === 'draw' ? 'draw' : $request->result;

        $MAX_GAMES_PER_PAIRING = 2;
        $tournament = Tournament::find($request->tournament_id);
        $previousGamesFromPairing = $tournament->getGamesByPairing(Player::find($request->player_one), Player::find($request->player_two));
        if($previousGamesFromPairing->count() >= $MAX_GAMES_PER_PAIRING){
            return Redirect::to('/dashboard/edit-tournament/' . $request->tournament_id);
        }

        // player id that won, nullable
        $winner = null;
        if($result && ($result !== 'draw')){
            $winner = $result;
        }

        // player id that lost, nullable
        $loser = null;
        if($winner){
            $loser = $players->first(fn($id)=>$id!==$winner);
        }

        // object keyed by player id with result 
        $playerResults = (object) $players->map(function (string $playerId) use ($result, $winner){
            $x = [
                'playerId' => $playerId,
            ];
            if(!$result){
                $x['result'] = '-';
                return $x;
            }
            if($result === 'draw'){
                $x['result'] = '&frac12;';
                return $x;
            }
            $playerResult = $playerId === $winner ? '1' : '0';
            $x['result'] = $playerResult;
            return $x;

        })->mapWithKeys(function(array $item, int $key){
            return [$item['playerId']=>$item['result']];
        });

        $game = Game::create([
            'tournament_id' => (int) $request->tournament_id,
            'loser'         => $loser,
            'playerResults' => $playerResults,
            'players'       => $players, 
            'result'        => $result,
            'winner'        => $winner,
        ]);
        return Redirect::to('/dashboard/edit-tournament/' . $request->tournament_id);
    }
}
