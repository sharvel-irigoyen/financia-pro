@props([
    'key',
    'option_title',
    'label' => false,
    'for',
    'error' => false,
    'relation_key' => false,
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

    <select {{ $attributes->merge(['class' => 'form-select fs-6 ' . ($error ? 'is-invalid' : '')]) }} id="{{ $for }}"
        class="form-select fs-5 @if ($error) is-invalid @endif"
        @if ($disabled) disabled @endif>
        <option disabled selected value="">{{$option_title}}</option>
        @if (is_array($key))
            @foreach ($key as $key => $element)
                <option value="{{ $key }}">
                    {{ $element }}
                </option>
            @endforeach
        @else
            @foreach ($key as $element)
                <option value="{{ intval($element->id) }}">
                    {{ $relation_key ? $element->$relation_key->name : $element->name }}
                </option>
            @endforeach
        @endif
    </select>
    @if ($error)
        <div class="invalid-feedback">
            *{{ $error }}
        </div>
    @endif
</div>
