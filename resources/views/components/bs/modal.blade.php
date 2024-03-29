@props(['size' => '', 'body' => true, 'footer' => true, 'header' => true, 'ref' => ''])

<div wire:ignore.self {{ $attributes->merge(['class' => 'modal fade']) }}
    @if ($ref) x-ref="{{ $ref }}"
    x-init="{{ $ref }} = new bootstrap.Modal($refs.{{ $ref }})" @endif>
    <div class="modal-dialog {{ isset($size) && $size !== '' ? $size : '' }} modal-dialog-centered align-items-end align-items-sm-center">
        <div class="modal-content">
            @if ($header)
                <div {{ $header->attributes->merge(['class' => 'modal-header']) }}>
                    {{ $header }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
            @endif
            @if ($body)
                <div {{ $body->attributes->merge(['class' => 'modal-body']) }}>
                    {{ $body }}
                </div>
            @endif
            @if ($footer)
                <div {{ $footer->attributes->merge(['class' => 'modal-footer']) }}>
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
