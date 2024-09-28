@props([
    'bg',
    'name',
    'position',
    'image',
])
<div>
    <div  class="{{ $bg }} rounded-lg relative overflow-x-hidden">
        <svg class="absolute z-10 separator m-auto my-10 fill-sky-300 opacity-20" width="900" viewBox="0 0 687 155" xmlns="http://www.w3.org/2000/svg"><g stroke="currentColor" stroke-width="7" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><path d="M20 58c27-13.33333333 54-20 81-20 40.5 0 40.5 20 81 20s40.626917-20 81-20 40.123083 20 80.5 20 40.5-20 81-20 40.5 20 81 20 40.626917-20 81-20c26.915389 0 53.748722 6.66666667 80.5 20" opacity=".1"></path><path d="M20 78c27-13.3333333 54-20 81-20 40.5 0 40.5 20 81 20s40.626917-20 81-20 40.123083 20 80.5 20 40.5-20 81-20 40.5 20 81 20 40.626917-20 81-20c26.915389 0 53.748722 6.6666667 80.5 20" opacity=".2"></path><path d="M20 98c27-13.3333333 54-20 81-20 40.5 0 40.5 20 81 20s40.626917-20 81-20 40.123083 20 80.5 20 40.5-20 81-20 40.5 20 81 20 40.626917-20 81-20c26.915389 0 53.748722 6.6666667 80.5 20" opacity=".6"></path><path d="M20 118c27-13.3333333 54-20 81-20 40.5 0 40.5 20 81 20s40.626917-20 81-20 40.123083 20 80.5 20 40.5-20 81-20 40.5 20 81 20 40.626917-20 81-20c26.915389 0 53.748722 6.6666667 80.5 20"></path></g></svg>
        <div class="p-3 text-white">
            <h3 class="font-bold text-md">{{ $name }}</h3>
            <h4 class="">{{ $position }}</h4>
        </div>
        <div class="flex justify-center">
            <img src="{{ $image }}" class="z-50" alt="">
        </div>
    </div>
</div>
