<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 font-weight-bold mb-0">
            Detalle recibo
        </h2>
    </x-slot>

    <x-bs.container container="container" class="justify-content-around my-4">
        <div class="col-12 col-xl-3 col-xxl-12">
            <livewire:receipt-detail.payment-plan.register-overdue />
        </div>
        <div class="col-12 col-xl-9 col-xxl-12">
            <livewire:receipt-detail.payment-plan.table :receiptDetail="$detail" />
        </div>
    </x-bs.container>
</x-app-layout>
