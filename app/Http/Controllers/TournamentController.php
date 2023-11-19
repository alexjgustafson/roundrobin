<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Tournament;

class TournamentController extends Controller
{
    /**
     * Add new tournament
     */
    public function create(Request $request): RedirectResponse
    {
        $user = (object) $request->user();
        $tournament = Tournament::firstOrCreate([
            'admin' => $user->id,
            'title' => self::formatTitle($request->title ?? ''),
        ]);
        return Redirect::to('/dashboard/edit-tournament/' . $tournament->id);
    }

    private static function formatTitle(string $title) : string {
        $CHAR_LIMIT = 256;
        $title = strip_tags($title);
        if(strlen($title) > $CHAR_LIMIT){
            $title = substr($title, 0, $CHAR_LIMIT);
        }
        return $title;
    }
}
