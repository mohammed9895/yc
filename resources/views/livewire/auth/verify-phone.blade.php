<div>
    <form action="" method="POST">
        <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white">OTP code</label>
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
