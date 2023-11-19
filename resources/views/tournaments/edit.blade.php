<x-app-layout>
  <div class="w-full py-12">
    @if ($tournament)
    <div id="tournament" class="w-9/12 mx-auto my-8">
      <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-8">Edit Tournament: {{$tournament->title}}</h1>
      @include('tournaments.partials.edit-tournament-form', [
        'tournament' => $tournament,
        'players' => json_decode($tournament->players),
        'games' => json_decode($tournament->games),
      ])

      <div id="view-tournament" class="mt-6">
        <p><a href="/tournament/{{$tournament->id}}">View Tournament</a></p>
      </div>
    </div>
    @endif

    <div id="dashboard" class="w-9/12 mx-auto mt-8">
      @if (!$userIsTournamentAdmin)
        <p>You do not have permission to edit this tournament.</p>
      @endif
      <p><a href="/dashboard">Return to dashboard</a></p>
    </div>
  </div>
</x-app-layout>