<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gold leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card overflow-hidden sm:rounded-lg">
                <div class="p-6 text-silver">
                        {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
