<x-dashboard-tile :position="$position" refresh-interval="60">
    <x-tile.data-layout
        title="Elevation"
        :data="sprintf('%s (%s)', number_format(round($distance, 0)), $unit)">
            <a href="#" wire:click="setUnit('km')">km</a> |
            <a href="#" wire:click="setUnit('mi')">miles</a> |
            <a href="#" wire:click="setUnit('m')">metres</a>
    </x-tile.data-layout>

</x-dashboard-tile>
