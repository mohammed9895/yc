<div>
    <h2 class="mt-20 text-lg font-semibold text-gray-900">Verify Your Phone Now</h2>
    <p class="mt-2 text-sm text-gray-700">You didn't receive your OTP? <!-- --> <button
            class="font-medium text-[#4a1d96] hover:underline" wire:click="resend" type="button">resend</button> <!-- -->again.
    </p>
    <div class="mt-5">
    <form wire:submit="verify" method="POST">
        <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white mb-2">OTP code</label>
        <x-filament::input.wrapper :valid="! $errors->has('otp')">
            <x-filament::input
                type="text"
                wire:model="otp"
            />

            @error('otp')  <p class="fi-fo-field-wrp-error-message text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p> @enderror

        </x-filament::input.wrapper>
        <x-filament::button class="mt-5 block w-full" color="primary" type="submit">
            {{ __('Verify Now') }}
        </x-filament::button>
    </form>
</div>
