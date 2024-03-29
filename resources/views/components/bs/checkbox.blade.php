@props(['label'=>false, 'for', 'error' => false])
<div class="form-check text-start mb-2 fs-6 mb-0">
    <input {{ $attributes->merge(['class' => 'form-check-input' . ($error ? ' is-invalid' : '')]) }} type="checkbox"
        id="{{ $for }}">
    @if ($label)
        <label class="form-check-label" for="{{ $for }}">
            {{ $label }}
        </label>
    @else
        <label class="form-check-label" for="{{ $for }}">
            {{ $slot }}
        </label>
    @endif
    @if ($error)
        <div class="invalid-feedback">
            *{{ $error }}
        </div>
    @endif
</div>
