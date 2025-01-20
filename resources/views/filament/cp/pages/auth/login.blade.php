<div>
    <h2 class="mt-20 text-lg font-semibold text-gray-900">Get started Today</h2>
    <p class="mt-2 text-sm text-gray-700">You Don't have account? <!-- --> <a
            class="font-medium text-[#4a1d96] hover:underline" href="/cp/register">Register</a> <!-- -->your account Now.
    </p>
    <div class="mt-5">
        <form wire:submit="authenticate">
            {{ $this->form }}

            <p class="mt-2 text-sm text-gray-700">Forget your password? <!-- --> <a
                    class="font-medium text-[#4a1d96] hover:underline" href="/cp/password-reset/request">Reset</a> <!-- -->your password now.
            </p>

            <x-filament::button class="mt-5 block w-full" type="submit">
                {{ __('login') }}
            </x-filament::button>
        </form>
    </div>
</div>
