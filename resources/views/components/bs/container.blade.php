@props(['container' => 'container'])

<div class="{{ $container }}">
    <div {{ $attributes->merge(['class' => 'row']) }}>
        {{ $slot }}
    </div>
</div>
