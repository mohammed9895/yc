<div class="relative" >
    <nav class="z-50" >
        <div class="container mx-auto py-5 md:py-12 md:px-2">
            <div class="flex justify-between items-center">
                <div>
                    <a href="/">
                        <img src="{{ asset('images/yc-logo-colored.svg') }}" width="200" alt="">
                    </a>
                </div>
                <button @click="menuOpen = !menuOpen" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-white md:hidden hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary" aria-controls="navbar-default" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 text-gray-800 h-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>
                <div class="w-full z-50 hidden mt-5 md:mt-0 md:block md:w-auto" >
                    <ul class="flex items-center space-x-reverse space-x-10">
                        <li>
                            <a href="{{ route('home.index') }}">الرئيسية</a>
                        </li>
        {{--                <li>--}}
        {{--                    <a href="#">رؤيتنا</a>--}}
        {{--                </li>--}}
                        <li>
                            <a href="{{ route('home.incubators') }}">الحاضنات</a>
                        </li>
                        <li>
                            <a href="{{ route('home.tmakon') }}">تَمكن</a>
                        </li>
                        <li>
                            <a href="{{ route('home.programs') }}">البرامج</a>
                        </li>
                        <li>
                            <a href="{{ route('home.contact') }}">تواصل معنا</a>
                        </li>
                    </ul>
                </div>
                <div class="items-center space-x-reverse space-x-5 hidden md:flex">
                    <a href="/cp/login">
                        تسجيل دخول
                    </a>
                    <a href="/cp/register" class="border border-purple-700 text-purple-700 rounded-md px-5 py-3 hover:bg-purple-700 hover:text-white transition">
                        أنشاء حساب
                    </a>
                </div>
            </div>
        </div>
        <div x-show="menuOpen" class="w-full mt-2 md:mt-0 md:w-auto p-2 bg-transparent text-gray-800 md:hidden" x="" :class="{ 'bg-white': !atTop, 'bg-transparent': atTop }" bis_skin_checked="1">
            <ul class="flex flex-col space-y-5 md:flex-row md:space-x-10">
                <li>
                    <a href="{{ route('home.index') }}">الرئيسية</a>
                </li>
                {{--                <li>--}}
                {{--                    <a href="#">رؤيتنا</a>--}}
                {{--                </li>--}}
                <li>
                    <a href="{{ route('home.incubators') }}">الحاضنات</a>
                </li>
                <li>
                    <a href="{{ route('home.tmakon') }}">تَمكن</a>
                </li>
                <li>
                    <a href="{{ route('home.programs') }}">البرامج</a>
                </li>
                <li>
                    <a href="{{ route('home.contact') }}">تواصل معنا</a>
                </li>
                <div class="flex justify-between items-center">
                    <a href="/cp/login">
                        تسجيل دخول
                    </a>
                    <a href="/cp/register" class="border border-purple-700 text-purple-700 rounded-md px-5 py-3 hover:bg-purple-700 hover:text-white transition">
                        أنشاء حساب
                    </a>
                </div>
            </ul>
        </div>
    </nav>
</div>
