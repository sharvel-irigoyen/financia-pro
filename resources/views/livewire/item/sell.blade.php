<div>
    <div class="d-flex justify-content-between">
        @if ($isCredit)
            <h5>Pago a crédito</h5>
        @else
            <h5>Pago al contado</h5>
        @endif

        <div class="form-check form-switch">
            <input wire:model.live='isCredit' class="form-check-input" type="checkbox" role="switch" id="is_credit">
            <label class="form-check-label" for="is_credit"> ¿ Dar a crédito ?</label>
        </div>
    </div>

    @if ($isCredit)
        <div class="row">
            <div class="col-6 col-sm-4">
                <x-bs.input wire:model.live="installments" label="Num de cuotas:" for="installments"
                    :error="$errors->first('installments')" />
            </div>
            <div class="col-6 col-sm-4">
                <x-bs.select wire:model.live="grace_period_type" label="Tipo de gracia:" for="grace_period_type"
                    option_title="Seleccione el tipo de gracia" :key="['Total' => 'Total', 'Parcial' => 'Parcial', 'Ninguno' => 'Ninguno']" :error="$errors->first('grace_period_type')" />
            </div>
            @if ($grace_period_type != 'Ninguno')
                <div class="col-6 col-sm-4">
                    <x-bs.input wire:model.live="grace_period" label="Periodo de gracia:" for="grace_period"
                        :error="$errors->first('grace_period')" />
                </div>
            @endif
        </div>

        <p>Interés total: S/.{{ $interest }}</p>
        <p>Cuota mensual (1ra): S/.{{ $installment }}</p>
        <p>Precio inicial: S/. {{ $item?->price ?? 0 }}</p>
        <p>Precio total: S/.{{ $total }}</p>
        <p>Fecha 1ra cuota: {{ $firstInstallmentDate->toDateString() }}</p>
        <p>Fecha última cuota: {{ $lastInstallmentDate->toDateString() }}</p>
        <button wire:click="giveCredit" class="btn btn-outline-success btn-sm">
            <span wire:loading wire:target='giveCredit' class="spinner-border spinner-border-sm"
                aria-hidden="true"></span>
            Dar a crédito
        </button>
    @else
        <p>Precio: S/. {{ $item?->price ?? 0 }}</p>
        <button wire:click="sell" class="btn btn-outline-success btn-sm">
            <span wire:loading wire:target='sell' class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            Vender
        </button>
    @endif
    @if ($errors->has('item'))
        <div class="text-danger">{{ $errors->first('item') }}</div>
    @endif

    @if ($errors->has('customer'))
        <div class="text-danger">{{ $errors->first('customer') }}</div>
    @endif

</div>
