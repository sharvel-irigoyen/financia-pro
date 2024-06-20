<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 font-weight-bold mb-0">
            Vender
        </h2>
    </x-slot>

    <x-bs.container container="container" class="py-3 justify-content-around">
        <div class="col-12 col-xl-3 col-xxl-3">
           <h2>Buscar cliente</h2>
            <livewire:customer.search />
        </div>
        <div class="col-12 col-xl-3 col-xxl-3">
            <h2>Buscar producto</h2>
            <livewire:item.search />
        </div>
        <div class="col-12 col-xl-6 col-xxl-4">
            <h2>Vender</h2>
            <livewire:item.sell />
        </div>
    </x-bs.container>
</x-app-layout>
