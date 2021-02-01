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
                @foreach(\App\Models\StravaConnectionLog::where('team_id', \Illuminate\Support\Facades\Auth::user()->currentTeam->id)->get() as $log)
                    <li>
                        {{ $log->id }}
                        <ul>
                            <li>{{$log->type}}</li>
                            <li>{{$log->log}}</li>
                        </ul>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
