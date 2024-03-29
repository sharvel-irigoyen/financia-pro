<div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="fs-4 fw-semibold">Categorias</div>
    </div>
    <div class="table-responsive my-3 rounded-4 shadow-lg">
        <table class="table table-sm table-striped align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>
                        Nombre
                    </th>
                    <th>
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#add-modal-category"><i class="fa-solid fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr wire:key="{{ $category->id }}">
                        <td>{{ $category->name }}</td>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#edit-modal-category-{{ $category->id }}"
                                type="button" class="btn btn-sm btn-outline-primary"><i
                                    class="fa-regular fa-pen-to-square"></i></button>

                            <button wire:click="deleteConfirmation({{ $category->id }})" type="button"
                                class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                        <livewire:category.edit-modal :$category :key="'edit-' . $category->id"
                            @category-saved="$refresh" />
                    </tr>
                @empty
                    <tr>
                        <td colspan="2"> No hay registros</td>

                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->onEachSide(0)->links() }}

    <livewire:category.add-modal wire:key="add-category-modal" @category-saved="$refresh" />
</div>
