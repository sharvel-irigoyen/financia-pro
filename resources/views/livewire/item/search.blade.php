<div>
    <x-bs.input wire:model="code" label="Código del producto:" for="code" :add_on_right="true" :error="$errors->first('code')">
        <x-slot name="slot">
            <button wire:click="search" class="btn btn-outline-secondary btn-sm">
                <span wire:loading wire:target='search' class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <i class="fa-solid fa-search"></i>
            </button>
        </x-slot>
    </x-bs.input>

    @if ($item)
        <x-bs.card>
            <x-slot name="header">
                <h2 class="h5 font-weight-bold mb-0">
                    {{ $item->category->name }}
                </h2>
            </x-slot>
            <x-slot name="slot">
                <p>Descripción: {{ $item->description }}</p>
                <p>Precio: {{ $item->price }}</p>
            </x-slot>
        </x-bs.card>
    @endif
</div>
