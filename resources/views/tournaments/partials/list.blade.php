<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Your Tournaments') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Lorem ipsum dolor set amit') }}
        </p>
    </header>
    <ul>
        @foreach($tournaments as $tournament)
        <li><a href="/dashboard/edit-tournament/{{{$tournament['id']}}}">{{$tournament['title']}}</a></li>
        @endforeach
    </ul>
</section>
