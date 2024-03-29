<div>
    <x-bs.modal id="edit-modal-item-{{ $item->id }}" ref="editModalItem{{ $item->id }}"
        @item-saved.window="editModalItem{{ $item->id }}.hide()" :footer="false">
        <x-slot name="header">
            Editar producto
        </x-slot>

        <x-slot name="body">
            <form wire:submit='edit'>
                <x-bs.input autofocus wire:model.blur='code' label="Código:" for="edit-code-{{ $item->id }}"
                    :error="$errors->first('code')" />
                <x-bs.select wire:model.blur="categoryId" :key="$categories" label="Categoría:"
                    for="edit-category-{{ $item->id }}" :error="$errors->first('categoryId')" option_title="Seleccione una categoría" />
                <x-bs.input autofocus autocomplete="on" wire:model.blur='description' label="Descripción:"
                    for="edit-description-{{ $item->id }}" :error="$errors->first('description')" />
                <x-bs.input autofocus autocomplete="on" wire:model.blur='price' label="Precio:"
                    for="edit-price-{{ $item->id }}" :error="$errors->first('price')" />
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <span wire:loading wire:target='edit' class="spinner-border spinner-border-sm"
                            aria-hidden="true"></span>
                        Editar</button>
                </div>

            </form>
        </x-slot>
    </x-bs.modal>
</div>
