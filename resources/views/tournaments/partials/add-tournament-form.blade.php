<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Create New Tournament') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Lorem ipsum dolor set amit') }}
        </p>
    </header>

    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'create-new-tournament')"
    >{{ __('Create') }}</x-primary-button>

    <x-modal name="create-new-tournament" focusable>
        <form method="post" action="{{ route('tournament.create') }}" class="p-6">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('New Tournament') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="title" value="{{ __('Title') }}" class="sr-only" />

                <x-text-input
                    id="title"
                    name="title"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('The Great Blitz Championship') }}"
                />

            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Tournament') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>
