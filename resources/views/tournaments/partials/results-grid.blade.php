<table>
  <tr>
    <th></th>
    <th>Name</th>
    @for ($i = 1; $i <= count($tournament->players); $i++)
      <th>{{$i}}</th>
    @endfor
    <th>Score</th>
  </tr>
  @foreach($tournament->getPlayersByScore() as $player)
    <tr
      class="
        @if($loop->even)
        bg-slate-200
        @endif
      "
    >
      <td class="p-2 border-solid border-y-2 border-l-2 border-slate-400">{{$loop->index + 1}}</td>
      <td class="px-6 py-2 border-solid border-y-2 border-slate-400">{{$player->name}}</td>
      @for ($i = 1; $i <= count($tournament->players); $i++)
        <td class="border-solid border-2 border-slate-400 p-2">@include('tournaments.partials.game-diad', [
          'player'   => $player,
          'opponent' => $tournament->getPlayersByScore()->values()->get($i-1),
          'games'    => $tournament->getGamesByPairing($player, $tournament->getPlayersByScore()->values()->get($i-1))->take(2),
        ])</td>
      @endfor
      <td class="px-6 py-2 text-center border-solid border-2 border-slate-400">{{$player->getScore()}}</td>
    </tr>
  @endforeach
</table>
