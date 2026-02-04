<x-app-layout>
    <x-slot name="header">
        <h1 class="section-title">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <div class="page-wrapper">
        <div class="page-container">

            <!-- Sección de Información del Perfil -->
            <div class="content-box">
                <div class="form-container">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Sección de Cambio de Contraseña -->
            <div class="content-box">
                <div class="form-container">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
