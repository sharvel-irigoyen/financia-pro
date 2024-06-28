<div>
    <div class="d-flex align-items-center justify-content-between justify-content-xl-start">
        <div class="col-6 col-sm-4 col-xl-6 pe-3">
            <div class="fs-4 fw-semibold">Registrar pago</div>
            <x-bs.select wire:model.live="receiptId" label="Cod. de Recibo:" for="receiptId"
                option_title="Seleccione el cod. del recibo" :key="$receipts" :error="$errors->first('receiptId')" />
        </div>
        <div class="col-6 col-sm-4 col-xl-6 align-self-end">
            <button wire:click="makePayment" class="btn btn-outline-success btn mb-3">
                <span wire:loading wire:target='makePayment' class="spinner-border spinner-border-sm"
                    aria-hidden="true"></span>
                Registrar pago
            </button>
            @if ($errors->has('payment'))
                <div class="text-danger">{{ $errors->first('payment') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col col-xl-6">
            @if ($receipt)
                <x-bs.card>
                    <x-slot name="header">
                        <h2 class="h5 font-weight-bold mb-0">
                            Cuotas totales: {{ $receipt->receiptDetails?->first()?->total_installment }}
                        </h2>
                    </x-slot>
                    <x-slot name="slot">
                        <p>Num cuota actual: {{ $paymentPlan->installment_number }}</p>
                        <p>Cuota: S/.{{ $paymentPlan->installment }}</p>
                        <p>Fecha de pago: {{ $paymentPlan->payment_date }}</p>
                        <p>Mora: {{ $paymentPlan->is_overdue ? 'Si' : 'No' }}</p>
                        <p>Estado: {{ $paymentPlan->status ? 'Pagado' : 'Pendiente' }}</p>
                        {{-- <p>Subtotal: S/.{{ $receipt->subtotal }}</p>
                        <p>Interés total: S/.{{ $receipt->interest_total }}</p>
                        <p>Estado: {{ $receipt->status ? 'Pagado' : 'Pendiente' }}</p>
                        <p class="fw-bolder">Total: S/.{{ $receipt->total }}</p> --}}
                    </x-slot>
                </x-bs.card>
            @endif
        </div>
    </div>
</div>
