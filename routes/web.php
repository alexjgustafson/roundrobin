<?php

use App\Http\Controllers\{GameController, PlayerController, ProfileController, TournamentController};
use App\Models\Tournament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tournament/{id}', function ($id) {
    return view('tournaments.view', [
        'id' => $id,
        'tournament' => Tournament::find($id)
    ]);
});

Route::get('/dashboard', function () {
    $tournaments = Tournament::where('admin', Auth::id())->get();
    return view('dashboard', [
        'tournaments' => $tournaments,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/edit-tournament/{id}', function (string $id) {
    $userTournments = Tournament::where('admin', Auth::id())->get();
    $userIsTournamentAdmin = $userTournments->map->id->contains($id);
    $tournament = $userTournments->first(function (Tournament $t, int $key) use ($id) {
        return $t->id === intval($id);
    });
    return view('tournaments.edit', [
        'id' => $id,
        'tournament' => $tournament,
        'userIsTournamentAdmin' => $userIsTournamentAdmin
    ]);
})->middleware(['auth', 'verified'])->name('dashboard.edit.tournament');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/tournament', [TournamentController::class, 'create'])->name('tournament.create');
    Route::post('/player', [PlayerController::class, 'create'])->name('player.create');
    Route::post('/game', [GameController::class, 'create'])->name('game.create');
});

require __DIR__.'/auth.php';
