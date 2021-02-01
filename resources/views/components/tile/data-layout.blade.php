@props(['title', 'data'])


<div
    class="grid gap-2 justify-items-center h-full text-center"
    style="grid-template-rows: auto 1fr auto;"
>
    <h1 class="font-medium text-dimmed text-sm uppercase tracking-wide tabular-nums">{{$title}}</h1>

    <div class="self-center font-bold text-4xl tracking-wide leading-none">{{$data}}</div>

    <h1 class="font-medium text-dimmed text-sm uppercase tracking-wide tabular-nums">
        {{$slot}}
    </h1>

</div>
