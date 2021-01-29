<x-dashboard-tile :position="$position" refresh-interval="120">
    <h1>{{$elapsedTimeReadable}} seconds Elapsed</h1>
    <h2>That's {{$elapsedTimeInDays}} days</h2>
    <h2>Or {{$elapsedTimeInHours}} hours</h2>
    <h2>Or {{$elapsedTimeInMinutes}} minutes</h2>
</x-dashboard-tile>
