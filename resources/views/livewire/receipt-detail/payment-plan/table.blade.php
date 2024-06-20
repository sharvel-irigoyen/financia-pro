<div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="fs-4 fw-semibold">Plan de pagos</div>
    </div>
    <div class="table-responsive my-3 rounded-4 shadow-lg">
        <table class="table table-sm table-striped align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>
                        Num Cuota
                    </th>
                    <th>
                        Periodo de gracia
                    <th>
                        Interés
                    </th>
                    <th>
                        Cuota
                    </th>
                    <th>
                        Amortización
                    </th>
                    <th>
                        Mora
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paymentPlans as $paymentPlan)
                    <tr wire:key="{{ $paymentPlan->id }}">
                        <td>{{ $paymentPlan->installment_number }}</td>
                        <td>{{ $paymentPlan->is_period_grace }}</td>
                        <td>{{ $paymentPlan->interest_amount }}</td>
                        <td>{{ $paymentPlan->installment }}</td>
                        <td>{{ $paymentPlan->amortization }}</td>
                        <td>{{ $paymentPlan->is_overdue }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7"> No hay registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $paymentPlans->onEachSide(0)->links() }}
</div>
