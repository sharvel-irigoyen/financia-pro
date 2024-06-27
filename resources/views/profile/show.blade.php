<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div>
        <div class="container mx-auto py-5 px-sm-5 px-lg-5">
            <div class="col-12 col-xl-3 col-xxl-3 mb-4">
                <h4>Soporte técnico</h4>
                <a role="button" href="https://api.whatsapp.com/send?phone=51993994620" class="btn btn-outline-success btn mb-3">
                    <i class="fa-brands fa-whatsapp fa-xl"></i> +51 993 994 620
                </a>


            </div>
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-sm-2 mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-sm-2 mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-sm-2 mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-sm-2 mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
