<div>
    <x-bs.modal id="edit-modal-{{ $customer->id }}" size="modal-lg" ref="editModal{{ $customer->id }}"
        @customer-saved.window="editModal{{ $customer->id }}.hide()" :footer="false">
        <x-slot name="header">
            Editar cliente
        </x-slot>

        <x-slot name="body">
            <form wire:submit='edit'>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-bs.input autofocus wire:model.blur='form.name' label="Nombres:"
                            for="edit-name-{{ $customer->id }}" :error="$errors->first('form.name')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.lastname' label="Apellidos:"
                            for="edit-lastname-{{ $customer->id }}" :error="$errors->first('form.lastname')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.document' label="Documentos:"
                            for="edit-document-{{ $customer->id }}" :error="$errors->first('form.document')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.email' type="email" label="Correo:"
                            for="edit-email-{{ $customer->id }}" :error="$errors->first('form.email')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.phone' type="tel" label="Teléfono:"
                            for="edit-phone-{{ $customer->id }}" :error="$errors->first('form.phone')" />
                    </div>

                    <div class="col-12 col-md-6">
                        <x-bs.select wire:model.blur='form.creditType' label="Tipo de crédito:"
                            for="edit-creditType-{{ $customer->id }}" :key="['TEA' => 'TEA', 'TNA' => 'TNA']"
                            option_title="Seleccione el tipo de crédito " :error="$errors->first('form.creditType')">
                        </x-bs.select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.interestRate' type="number" step="0.01"
                            min="0" max="100" label="Tasa de interés:" for="edit-interestRate-{{ $customer->id }}"
                            :error="$errors->first('form.interestRate')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.paymentDate' type="number" step="1" min="1"
                            max="29" label="Día de pago:" for="edit-paymentDate-{{ $customer->id }}"
                            :error="$errors->first('form.paymentDate')" />
                    </div>
                    <div class="col-12 col-md-6">
                        <x-bs.input autocomplete="on" wire:model.blur='form.creditLimit' type="number" step="1" min="0"
                            max="3000" label="Límite de crédito:" for="edit-creditLimit-{{ $customer->id }}"
                            :error="$errors->first('form.creditLimit')" />
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <span wire:loading wire:target='edit' class="spinner-border spinner-border-sm"
                            aria-hidden="true"></span>
                        Editar</button>
                </div>
            </form>
        </x-slot>
    </x-bs.modal>
</div>
