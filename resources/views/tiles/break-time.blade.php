<x-dashboard-tile :position="$position" refresh-interval="120">
    <h1>{{$breakTimeReadable}} seconds on a break</h1>
    <h2>That's {{$breakTimeInDays}} days</h2>
    <h2>Or {{$breakTimeInHours}} hours</h2>
    <h2>Or {{$breakTimeInMinutes}} minutes</h2>
</x-dashboard-tile>
