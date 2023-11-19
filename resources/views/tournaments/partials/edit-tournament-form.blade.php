<div id="edit-tournament-form" class="">
  <div class="py-4">
    <h3 class="text-xl mb-6">Players</h3>
    @if(count($tournament->players))
    <ul>
      @foreach ($tournament->players->sortBy('name') as $player)
        <li>{{$player->name}}</li>
      @endforeach
    </ul>
    @endif
    <x-primary-button
      x-data=""
      x-on:click.prevent="$dispatch('open-modal', 'add-player')"
      class="mt-4"
    >{{ __('Add Player') }}</x-primary-button>
  </div>

  <div class="py-4">
    <h3 class="text-xl mb-6">Games</h3>
    @if(count($tournament->games))
      @include('tournaments.partials.results-grid')
    @endif
    @if(count($tournament->players)>=2)
      <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'add-game')"
      >{{ __('Record Game') }}</x-primary-button>
    @endif
  </div>

  <x-modal name="add-player" focusable>
    <form method="post" action="{{ route('player.create') }}" class="p-6">
      @csrf
      @method('post')
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Add Player') }}
      </h2>
      <div class="mt-6">
          <x-input-label for="name" value="{{ __('Name') }}" class="sr-only" />

          <x-text-input
              id="name"
              name="name"
              type="text"
              class="mt-1 block w-3/4"
              placeholder="{{ __('Doe, John') }}"
          />

          <x-input-label for="tournament" value="{{ __('Tournament') }}" class="sr-only" />
          <x-text-input 
            id="tournament" 
            name="tournament" 
            value="{{$tournament->id}}" 
            hidden
          />
      </div>
      <div class="mt-6 flex justify-end">
          <x-secondary-button x-on:click="$dispatch('close')">
              {{ __('Cancel') }}
          </x-secondary-button>

          <x-primary-button class="ms-3">
              {{ __('Add Player') }}
          </x-primary-button>
      </div>
    </form>
  </x-modal>
  <x-modal name="add-game" focusable>'
    <form 
    x-data="{ 
      playerOne: '',
      playerTwo: '',
      result: '',
    }"
    method="post" action="{{ route('game.create') }}" class="p-6">
      @csrf
      @method('post')
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Record Result') }}
      </h2>
      <div class="mt-6">
          
          <x-input-label for="player_one" value="{{ __('Player One') }}" class="" />
          <select
            id="player_one"
            name="player_one"
            class="mb-4"
            x-model="playerOne"
          >
            <option value="" x-show="!playerTwo">Select...</option>
            @foreach($tournament->players as $player)
              <option x-show="!playerTwo || ({{$player->id}} == playerOne)" value="{{$player->id}}">{{$player->name}}</option>
            @endforeach
          </select>
          
          <x-input-label for="player_two" value="{{ __('Player Two') }}" class="" />
          <select
            id="player_two"
            name="player_two"
            class="mb-4"
            x-model="playerTwo"
            x-show="playerOne"
          >
            <option value="">Select...</option>
            @foreach($tournament->players as $player)
              <option x-show="{{$player->id}} != playerOne" value="{{$player->id}}">{{$player->name}}</option>
            @endforeach
          </select>
          
          <x-input-label for="result" value="{{ __('Result') }}" class="" />
          <select
            id="result"
            name="result"
            class="mb-4"
            x-model="result"
            x-show="playerOne && playerTwo"
          >
            <option value="draw">Draw</option>
            @foreach($tournament->players as $player)
              <option x-show="{{$player->id}} == playerOne || {{$player->id}} == playerTwo" value="{{$player->id}}">{{$player->name}} wins</option>
            @endforeach
          </select>

          <x-input-label for="tournament_id" value="{{ __('Tournament') }}" class="sr-only" />
          <x-text-input 
            id="tournament_id" 
            name="tournament_id" 
            value="{{$tournament->id}}" 
            hidden
          />
      </div>
      <div class="mt-6 flex justify-end">
          <x-secondary-button x-on:click="$dispatch('close')">
              {{ __('Cancel') }}
          </x-secondary-button>

          <x-primary-button class="ms-3">
              {{ __('Submit') }}
          </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>