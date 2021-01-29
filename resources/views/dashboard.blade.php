<x-dashboard>
    <livewire:total-distance position="a1" :team />
    <livewire:moving-time position="b1" />
    <livewire:elapsed-time position="c1" />
{{--    <livewire:chart-tile chartClass="{{\App\Http\Livewire\TypeDistributionAgainstTimeChart::class}}" position="a2:b3" />--}}
    <livewire:break-time position="c2" />
    <livewire:total-elevation position="c3" />
</x-dashboard>
