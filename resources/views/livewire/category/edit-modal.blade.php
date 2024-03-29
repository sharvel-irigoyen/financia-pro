<div>
    <x-bs.modal id="edit-modal-category-{{ $category->id }}" ref="editModalCategory{{ $category->id }}"
        @category-saved.window="editModalCategory{{ $category->id }}.hide()" :footer="false">
        <x-slot name="header">
            Editar categoría
        </x-slot>

        <x-slot name="body">
            <form wire:submit='edit'>
                <x-bs.input autofocus wire:model.blur='name' label="Categoría:" for="edit-name-{{ $category->id }}"
                    :error="$errors->first('name')" />
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
