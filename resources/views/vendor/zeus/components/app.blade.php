<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}" class="antialiased filament js-focus-visible">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="{{ config('app.name', 'Laravel') }}">

    <!-- Seo Tags -->
    <x-seo::meta/>
    <!-- Seo Tags -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    @livewireStyles
    @filamentStyles
    @stack('styles')


    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <style>
        * {
            font-family: "IBM Plex Sans Arabic", sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body
    class="font-sans antialiased bg-gray-50 text-gray-900 dark:text-gray-100">

<header x-data="{ open: false }" class="bg-gradient-to-r from-violet-400 to-violet-800 px-4">
    <div class="container mx-auto">
        <div class="flex justify-between items-start h-96 py-10">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a class="italic flex gap-2 group" href="{{ url('/') }}">
                        <img class="w-32" src="{{ asset('images/yc-logo-white.svg') }}"
                             alt="{{ config('app.name', 'Laravel') }}">
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex sm:items-center">

                </div>

            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <a href="/cp/login"
                       class="text-white hover:text-gray-200 dark:text-gray-100 dark:hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                        <img src="{{ auth()->user()->getFilamentAvatarUrl() }}" class="size-12 rounded-full" alt="">
                    </a>
                    @if(app()->getLocale() == 'en')
                        <a href="{{ route('language.switch', 'ar') }}">
                            @svg('heroicon-o-globe-alt', 'size-5 text-white hover:text-gray-200 dark:text-gray-100 dark:hover:text-gray-200')
                        </a>
                    @else
                        <a href="{{ route('language.switch', 'ar') }}">
                            @svg('heroicon-o-globe-alt', 'size-5 text-white hover:text-gray-200 dark:text-gray-100 dark:hover:text-gray-200')
                        </a>
                    @endif
                @endauth
                @guest
                    <a href="/cp/login"
                       class="flex items-center justify-center text-white hover:text-gray-200 dark:text-gray-100 dark:hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>

                        Login
                    </a>
                    <a href="/cp/register"
                       class="flex items-center justify-center text-white hover:text-gray-200 dark:text-gray-100 dark:hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                        </svg>


                        Register
                    </a>
                @endguest
            </div>
        </div>
    </div>
    <div class="container mx-auto py-2 px-3">
        <div class="flex justify-between items-center">
            <div class="w-full">
                @if(isset($header))
                    <div class="italic font-semibold text-xl text-gray-600 dark:text-gray-100">
                        {{ $header }}
                    </div>
                @endif
            </div>
            <span class="bolt-loading animate-pulse"></span>
        </div>
    </div>
</header>


<div class="container mx-auto my-6">
    {{ $slot }}
</div>


@livewireScripts
@filamentScripts
@livewire('notifications')
@stack('scripts')

<script>
    const theme = localStorage.getItem('theme')

    if ((theme === 'dark') || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    }
</script>

</body>
</html>
