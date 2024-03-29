<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 font-weight-bold mb-0">
            {{ __('Items') }}
        </h2>
    </x-slot>

    <x-bs.container container="container" class="justify-content-around">
        <div class="col-12 col-xl-9 col-xxl-3">
            <livewire:category.table />
        </div>
        <div class="col-12 col-xl-9 col-xxl-9">
            <livewire:item.table />
        </div>
    </x-bs.container>
</x-app-layout>
