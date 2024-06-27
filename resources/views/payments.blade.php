<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 font-weight-bold mb-0">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <x-bs.container container="container" class="justify-content-start mt-4">
        <div class="col-12 col-xl-9 col-xxl-3">
            <h4>Buscar cliente</h4>
            <livewire:customer.search />
        </div>
        <div class="col-12 col-xl-9 col-xxl-6">
            <livewire:payment.register-payment />
        </div>
    </x-bs.container>
</x-app-layout>
