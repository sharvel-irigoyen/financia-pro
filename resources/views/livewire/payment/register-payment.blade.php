<div>
    <div class="d-flex align-items-center justify-content-between justify-content-xl-start">
        <div class="col-6 col-sm-4 col-xl-6 pe-3">
            <div class="fs-4 fw-semibold">Registrar pago</div>
            <x-bs.select wire:model="receipt" label="Cod. de Recibo:" for="receipt"
                option_title="Seleccione el cod. del recibo" :key="$receipts" :error="$errors->first('receipt')" />
            @if ($customer)
                <x-bs.card>
                    <x-slot name="header">
                        <h2 class="h5 font-weight-bold mb-0">
                        {{ $customer->receipts->id }}
                        </h2>
                    </x-slot>
                    <x-slot name="slot">
                    <p>Subtotal: {{ $customer->receipts->email }}</p>
                    <p>Interés total: {{ $customer->receipts->phone }}</p>
                    <p>Estado: {{ $customer->receipts->creditAccount->credit_type }}</p>
                    <p>Total: {{ $customer->receipts->creditAccount->interest_rate }}</p>
                    <p>Fecha de pago: {{ $customer->receipts->creditAccount->balance }}</p>
                    </x-slot>
                </x-bs.card>
            @endif
        </div>
        <div class="col-6 col-sm-4 col-xl-6 align-self-end">
            <button wire:click="makePayment" class="btn btn-outline-success btn mb-3">
                <span wire:loading wire:target='makePayment' class="spinner-border spinner-border-sm"
                    aria-hidden="true"></span>
                Registrar pago
            </button>
        </div>

    </div>
</div>
