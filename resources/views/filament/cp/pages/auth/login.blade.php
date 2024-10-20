<form wire:submit="register">
    {{ $this->form }}
    <x-filament::button class="mt-5 block w-full">
        {{ __('login') }}
    </x-filament::button>
</form>
