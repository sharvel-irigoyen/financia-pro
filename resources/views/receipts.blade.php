<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 font-weight-bold mb-0">
            Recibos
        </h2>
    </x-slot>

    <x-bs.container container="container" class="justify-content-around">
        <div class="col-12 col-xl-9 col-xxl-12">
            <livewire:receipt.table />
        </div>
    </x-bs.container>
</x-app-layout>
