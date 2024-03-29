<div>
    <x-bs.modal id="add-modal-category" ref="addModalCategory" @category-saved.window="addModalCategory.hide()" :footer="false">
        <x-slot name="header">
            Nueva categoría
        </x-slot>

        <x-slot name="body">
            <form wire:submit='add'>
                <x-bs.input autofocus autocomplete="on" wire:model.blur='name' label="Categoría:" for="names" :error="$errors->first('name')" />
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-success btn-sm">
                        <span wire:loading wire:target='add' class="spinner-border spinner-border-sm"
                            aria-hidden="true"></span>
                        Agregar</button>
                </div>
            </form>
        </x-slot>
    </x-bs.modal>
</div>
