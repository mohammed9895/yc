<div>
    <h2 class="mt-20 text-lg font-semibold text-gray-900">Get started Today</h2>
    <p class="mt-2 text-sm text-gray-700">You have account? <!-- --> <a
            class="font-medium text-[#4a1d96] hover:underline" href="/cp/login">Sign In</a> <!-- -->to your account Now.
    </p>
    <div class="mt-5">
        <form wire:submit="register">
            {{ $this->form }}
        </form>
    </div>
</div>
