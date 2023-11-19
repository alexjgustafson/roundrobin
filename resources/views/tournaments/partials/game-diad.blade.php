<div class="flex justify-center">
  @if($player->id === $opponent->id)
    <div class="w-8 h-4 bg-black"></div>
  @else 
    <div class="flex">
      @foreach($games as $game)
        <div class="game-result">
          {!! $game->getPlayerResult($player) !!}
        </div>
        @if(!$loop->last)
          <div class="separator mx-2">♟️</div>
        @endif
      @endforeach
    </div>
  @endif
<div>