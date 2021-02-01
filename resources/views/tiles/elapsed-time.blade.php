<x-dashboard-tile :position="$position" refresh-interval="60">
    <x-tile.data-layout
        title="Total Time"
        :data="sprintf('%s (%s)', number_format(round($time, 0)), $unit)">
        <a href="#" wire:click="setUnit('hrs')">hours</a> |
        <a href="#" wire:click="setUnit('days')">days</a> |
        <a href="#" wire:click="setUnit('secs')">seconds</a>
    </x-tile.data-layout>

</x-dashboard-tile>

