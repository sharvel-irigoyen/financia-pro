<div>
    <x-bs.input wire:model="document" label="Número de documento:" for="document" :add_on_right="true" :error="$errors->first('document')">
        <x-slot name="slot">
            <button wire:click="search" class="btn btn-outline-secondary btn-sm">
                <span wire:loading wire:target='search' class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <i class="fa-solid fa-search"></i>
            </button>
        </x-slot>
    </x-bs.input>

    @if ($customer)
        <x-bs.card>
            <x-slot name="header">
                <h2 class="h5 font-weight-bold mb-0">
                    {{ $customer->fullName }}
                </h2>
            </x-slot>
            <x-slot name="slot">
                <p>Correo: {{ $customer->email }}</p>
                <p>Teléfono: {{ $customer->phone }}</p>
                <p>Tipo de crédito: {{ $customer->creditAccount->credit_type }}</p>
                <p>Tasa de interés: {{ $customer->creditAccount->interest_rate }}</p>
                <p>Crédito utilizado: {{ $customer->creditAccount->balance }}</p>
                <p>Día de pago: {{ $customer->creditAccount->due_date }}</p>
                <p>Límite de crédito: {{ $customer->creditAccount->credit_limit }}</p>
            </x-slot>
        </x-bs.card>
    @endif
</div>
