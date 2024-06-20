<div class="mt-4">
    <div class="d-flex align-items-center justify-content-between">
        <div class="fs-4 fw-semibold">Clientes</div>
    </div>
    <div class="table-responsive my-3 rounded-4 shadow-lg">
        <table class="table table-sm table-striped align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombres</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Tipo crédito</th>
                    <th>Tasa de interés</th>
                    <th>Crédito utilizado</th>
                    <th>Día de pago</th>
                    <th>Límite de crédito</th>
                    <th>
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#add-modal-customer"><i class="fa-solid fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr wire:key="{{ $customer->id }}">
                        <th>{{ $customer->id }}</th>
                        <td>{{ $customer->fullName }}</td>
                        <td>{{ $customer->document }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->creditAccount->credit_type }}</td>
                        <td>{{ $customer->creditAccount->interest_rate }}</td>
                        <td>{{ $customer->creditAccount->balance }}</td>
                        <td>{{ $customer->creditAccount->due_date }}</td>
                        <td>{{ $customer->creditAccount->credit_limit }}</td>
                        <td> <button data-bs-toggle="modal" data-bs-target="#edit-modal-{{ $customer->id }}"
                                type="button" class="btn btn-sm btn-outline-primary"><i
                                    class="fa-regular fa-pen-to-square"></i></button>

                            <button wire:click="deleteConfirmation({{ $customer->id }})" type="button"
                                class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </td>

                        <livewire:customer.edit-modal :$customer :key="$customer->id" @customer-saved="$refresh" />
                    </tr>
                @empty
                    <tr>
                        <td colspan="10"> No hay registros</td>

                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $customers->onEachSide(0)->links() }}

    <livewire:customer.add-modal @customer-saved="$refresh" />
</div>
