<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Strava Connection Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <ul>
                @foreach(app(\App\Support\Team\CurrentTeamResolver::class)->currentTeam()->clubSyncronisations as $sync)
                    <li>
                        {{ $sync->id }}
                        <ul>
                            <li>{{$sync->record_count}}</li>
                            <li>{{$sync->created_at}}</li>
                        </ul>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
