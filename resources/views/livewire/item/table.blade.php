<div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="fs-4 fw-semibold">Productos</div>
    </div>
    <div class="table-responsive my-3 rounded-4 shadow-lg">
        <table class="table table-sm table-striped align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>
                        Código
                    </th>
                    <th>
                        Categoría
                    </th>
                    <th>
                        Descripción
                    </th>
                    <th>
                        Precio
                    </th>
                    <th>
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#add-modal-item"><i class="fa-solid fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr wire:key="{{ $item->id }}">
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#edit-modal-item-{{ $item->id }}"
                                type="button" class="btn btn-sm btn-outline-primary"><i
                                    class="fa-regular fa-pen-to-square"></i></button>

                            <button wire:click="deleteConfirmation({{ $item->id }})" type="button"
                                class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                        <livewire:item.edit-modal :$item :key="'edit-' . $item->id"
                            @item-saved="$refresh" />
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"> No hay registros</td>

                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $items->onEachSide(0)->links() }}

    <livewire:item.add-modal wire:key="add-item-modal" @item-saved="$refresh" />
</div>
