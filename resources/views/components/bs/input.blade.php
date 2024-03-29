@props([
    'label' => false,
    'for',
    'error' => false,
    'type' => 'text',
    'add_on_left' => false,
    'add_on_right' => false,
    'disabled' => false,
    'customLabel' => false,
])
<div class="mb-3">
    @if ($label)
        <label for="{{ $for }}" class="form-label">{{ $label }}
            @if ($customLabel)
                {{ $customLabel }}
            @endif
        </label>
    @endif

    <div class=" input-group  @if ($error) has-validation @endif">
        @if ($add_on_left)
            {{ $slot }}
        @endif
        <input @if ($disabled) disabled @endif
            {{ $attributes->merge(['class' => 'form-control fs-6 ' . ($error ? 'is-invalid' : '')]) }}
            id="{{ $for }}" type="{{ $type }}">
        @if ($add_on_right)
            {{ $slot }}
        @endif
        @if ($error)
            <div class="invalid-feedback">
                *{{ $error }}
            </div>
        @endif
    </div>
</div>
