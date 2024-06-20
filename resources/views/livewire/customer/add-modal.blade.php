<div>
    <x-bs.modal id="add-modal-customer" size="modal-lg" ref="addModalCustomer"
        @customer-saved.window="addModalCustomer.hide()" :footer="false">
        <x-slot name="header">
            Nuevo cliente
        </x-slot>

        <x-slot name="body">
            <form wire:submit='add'>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-bs.input autofocus autocomplete="on" wire:model.blur='form.name' label="Nombres:"
                            for="names" :error="$errors->first('form.name')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.lastname' label="Apellidos:" for="lastname"
                            :error="$errors->first('form.lastname')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.document' label="Documentos:" for="document"
                            :error="$errors->first('form.document')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.email' type="email" label="Correo:"
                            for="email" :error="$errors->first('form.email')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.phone' type="tel" label="Teléfono:"
                            for="phone" :error="$errors->first('form.phone')" />
                    </div>

                    <div class="col-12 col-md-6">
                        <x-bs.select wire:model.blur='form.creditType' label="Tipo de crédito:" for="creditType"
                            :key="['TEA' => 'TEA', 'TNA' => 'TNA']" option_title="Seleccione el tipo de crédito " :error="$errors->first('form.creditType')">
                        </x-bs.select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.interestRate' type="number" step="0.01"
                            min="0" max="100" label="Tasa de interés:" for="interestRate"
                            :error="$errors->first('form.interestRate')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.paymentDate' type="number" step="1"
                            min="1" max="29" label="Día de pago:" for="paymentDate" :error="$errors->first('form.paymentDate')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.creditLimit' type="number" step="1"
                            min="0" max="3000" label="Límite de crédito:" for="creditLimit"
                            :error="$errors->first('form.creditLimit')" />
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-success btn-sm">
                        <span wire:loading wire:target='add' class="spinner-border spinner-border-sm"
                            aria-hidden="true"></span>
                        Agregar</button>
                </div>
            </form>
        </x-slot>
    </x-bs.modal>
</div>
