<x-tournament-layout>
      <h1 class="my-12 font-semibold text-4xl text-gray-800 dark:text-gray-200 leading-tight">{{$tournament->title}}</h1>
      @include('tournaments.partials.results-grid')
</x-tournament-layout>

