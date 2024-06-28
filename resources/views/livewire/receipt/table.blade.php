<div>
    <div class="table-responsive my-3 rounded-4 shadow-lg">
        <table class="table table-sm table-striped align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>
                        Num. Recibo
                    </th>
                    <th>
                        Num. Doc
                    </th>
                    <th>
                        Cliente
                    </th>
                    <th>
                        Subtotal
                    </th>
                    <th>
                        Interés total
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Fecha de pago
                    <th>
                        Estado
                    </th>
                    <th>
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($receipts as $receipt)
                    <tr wire:key="{{ $receipt->id }}">
                        <td>{{ $receipt->id }}</td>
                        <td>{{ $receipt->customer->document }}</td>
                        <td>{{ $receipt->customer->full_name }}</td>
                        <td>{{ $receipt->subtotal }}</td>
                        <td>{{ $receipt->interest_total }}</td>
                        <td>{{ $receipt->total }}</td>
                        <td>{{ $receipt->payment_date }}</td>
                        <td>{{ $receipt->status ? 'Pagado' : 'Pendiente' }}</td>
                        <td>

                            <a role="button" href="{{ route('receipts.detail', ['id' => $receipt->id]) }}"
                                class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7"> No hay registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $receipts->onEachSide(0)->links() }}
</div>
