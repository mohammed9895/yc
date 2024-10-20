<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <style>[x-cloak] { display: none !important; }</style>
    @filamentStyles
    @vite('resources/css/app.css')
    @livewireStyles
    @livewireScripts
    @stack('scripts')
</head>

<body class="antialiased flex h-full flex-col">



<div class="relative flex min-h-full shrink-0 justify-center md:px-12 lg:px-0">
    <div
        class="relative z-10 flex flex-1 flex-col bg-white px-4 py-10 shadow-2xl sm:justify-center md:flex-none md:px-28  w-1/3">
        <main class="mx-auto w-full sm:px-4 md:w-full md:px-0 ">
            <div class="flex"><a aria-label="Home" href="/">
                    <img src="{{ asset('images/yc-logo-colored.svg') }}" class="w-auto h-10 " alt="">
                </a></div>
            <h2 class="mt-20 text-lg font-semibold text-gray-900">Get started Today</h2>

            @if(request()->routeIs('filament.cp.auth.login'))
                <p class="mt-2 text-sm text-gray-700">You Don't have account? <!-- --> <a
                        class="font-medium text-[#4a1d96] hover:underline" href="/cp/register">Register</a> <!-- -->your account Now.
                </p>
            @else
                <p class="mt-2 text-sm text-gray-700">You have account? <!-- --> <a
                        class="font-medium text-[#4a1d96] hover:underline" href="/cp/login">Sign In</a> <!-- -->to your account Now.
                </p>
            @endif
            <div class="mt-5">
                {{ $slot }}
            </div>
        </main>
    </div>
    <div class="hidden sm:contents lg:relative lg:block lg:flex-1"><img alt="" loading="lazy" width="1664" height="1866"
                                                                        class="absolute inset-0 h-full w-full object-cover"
                                                                        src="{{ asset('images/register-bg.jpg') }}">
    </div>
</div>



@filamentScripts
@vite('resources/js/app.js')
@livewire('notifications')
</body>
</html>
