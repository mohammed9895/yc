@push('stylesss')

<style>
    .filament-login-page {
        padding-top: 50px;
    }
</style>

@endpush

<div action="register" >
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament-breezy::default.registration.heading') }}
        </h2>
        <p class="mt-2 text-sm text-center">
            {{ __('filament-breezy::default.or') }}
{{--            <a class="text-primary-600" href="{{ route('filament.auth.login') }}">--}}
{{--                {{ strtolower(__('filament::login.heading')) }}--}}
{{--            </a>--}}
        </p>
    </div>

    {{ $this->form }}


</div>
