<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * Add new players
     */
    public function create(Request $request): RedirectResponse
    {
        $tournament = $request->tournament;
        $player = Player::firstOrCreate([
            'name' => $request->name ?? '',
            'tournament_id' => (int) $tournament,
        ]);
        return Redirect::to('/dashboard/edit-tournament/' . $tournament);
    }
}
