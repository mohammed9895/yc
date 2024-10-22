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

<body class="antialiased flex h-full flex-col bg-[#000F4A]">



<div class="relative flex min-h-full shrink-0 justify-center md:px-12 lg:px-0">
    <div
        class="relative z-10 flex flex-1 flex-col bg-white px-4 py-10 shadow-2xl sm:justify-center md:flex-none md:px-28  w-5/12 rounded-tr-3xl">
        <main class="mx-auto w-full sm:px-4 md:w-full md:px-0 ">
            <div class="flex"><a aria-label="Home" href="/">
                    <img src="{{ asset('images/yc-logo-colored.svg') }}" class="w-auto h-10 " alt="">
                </a></div>

            {{ $slot }}
        </main>
    </div>
    <div class="hidden sm:contents lg:relative lg:block lg:flex-1"><img alt="" loading="lazy"
                                                                        class="absolute inset-0 h-full w-full object-cover"
                                                                        src="{{ asset('images/auth.svg') }}">
    </div>
</div>



@filamentScripts
@vite('resources/js/app.js')
@livewire('notifications')
</body>
</html>
