<div>
    <div class="d-flex align-items-center justify-content-between justify-content-xl-start">
        <div class="col-6 col-sm-4 col-xl-3 pe-3">
            <div class="fs-4 fw-semibold">Registrar mora</div>
            <x-bs.select wire:model="nInstallment" label="Num. Cuota:" for="nInstallment"
                option_title="Seleccione el número de cuota" :key="$installments" :error="$errors->first('nInstallment')" />
        </div>
        <div class="col-6 col-sm-4 col-xl-6  align-self-end">
            <button wire:click="makeOverdue" class="btn btn-outline-warning btn mb-3">
                <span wire:loading wire:target='makeOverdue' class="spinner-border spinner-border-sm"
                    aria-hidden="true"></span>
                Registrar mora
            </button>
        </div>
    </div>
</div>
