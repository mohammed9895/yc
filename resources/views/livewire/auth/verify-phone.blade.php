<div>
    <h2 class="mt-20 text-lg font-semibold text-gray-900">Verify Your Phone Now</h2>
    <p class="mt-2 text-sm text-gray-700">You didn't receive your OTP? <!-- --> <a
            class="font-medium text-[#4a1d96] hover:underline" href="/cp/register">resend</a> <!-- -->again.
    </p>
    <div class="mt-5">
    <form action="" method="POST">
        <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white mb-2">OTP code</label>
        <x-filament::input.wrapper>
            <x-filament::input
                type="text"
                wire:model="name"
            />
        </x-filament::input.wrapper>
        <x-filament::button class="mt-5 block w-full">
            {{ __('Verify Now') }}
        </x-filament::button>
    </form>
</div>
