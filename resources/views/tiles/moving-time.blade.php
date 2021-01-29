<x-dashboard-tile :position="$position" refresh-interval="120">
    <h1>{{$movingTimeReadable}} seconds Moving</h1>
    <h2>That's {{$movingTimeInDays}} days</h2>
    <h2>Or {{$movingTimeInHours}} hours</h2>
    <h2>Or {{$movingTimeInMinutes}} minutes</h2>
</x-dashboard-tile>
