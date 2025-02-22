<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}
        <x-filament::button type="submit" class="mt-3">
            Submit
        </x-filament::button>
    </form>

    {{ $this->table }}

    <x-filament-actions::modals />
</x-filament-panels::page>
