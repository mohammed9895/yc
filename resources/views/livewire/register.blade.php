<div class="relative flex min-h-full shrink-0 justify-center md:px-12 lg:px-0">
    <div
        class="relative z-10 flex flex-1 flex-col bg-white px-4 py-10 shadow-2xl sm:justify-center md:flex-none md:px-28 w-1/3">
        <main class="mx-auto w-full max-w-md sm:px-4 md:w-full md:px-0">
            <div class="flex"><a aria-label="Home" href="/">
                    <img src="{{ asset('images/yc-logo-colored.svg') }}" class="w-auto h-10 " alt="">
                </a></div>
            <h2 class="mt-20 text-lg font-semibold text-gray-900">Get started for free</h2>
            <p class="mt-2 text-sm text-gray-700">Already registered?<!-- --> <a
                    class="font-medium text-blue-600 hover:underline" href="/cp/login">Sign in</a> <!-- -->to your account.
            </p>
           <div class="mt-5">
               <form wire:submit="register">
                {{ $this->form }}
               </form>
           </div>
        </main>
    </div>
    <div class="hidden sm:contents lg:relative lg:block lg:flex-1"><img alt="" loading="lazy" width="1664" height="1866"
                                                                        class="absolute inset-0 h-full w-full object-cover"
                                                                        src="{{ asset('images/register-bg.jpg') }}">
    </div>
</div>
