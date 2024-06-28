<x-guest-layout>

    <x-bs.container container="container" class="justify-content-around my-4">
        <div class="col-12 col-xl-9 col-xxl-3">
            <h4>Buscar cliente</h4>
            <livewire:customer.search />
        </div>
        <div class="col-12 col-xl-9 col-xxl-9">
            <h2 class="fs-4 font-weight-bold mb-0">
                Recibos
            </h2>
            <livewire:receipt.table />
        </div>
    </x-bs.container>
</x-guest-layout>
