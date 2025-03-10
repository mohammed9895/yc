<section class="py-32">
    <div>
       pm
    </div>
    <div class="w-full inline-flex flex-col flex-nowrap overflow-hidden py-10" dir="ltr">
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause mb-5">
            @foreach($evaluates_1 as $evaluate)
                    <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <img src="{{  $evaluate->user->avatar_url ? '/storage/' . $evaluate->user->avatar_url : asset('images/default.jpg') }}" class="size-12 ml-3 rounded-full" alt="">
                                <h4 class="text-md font-bold">{{ $evaluate->user->name }}</h4>
                            </div>
                            <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                        </div>
                        <p class="text-gray-600 text-sm">
                            {{ $evaluate->devloped }}
                        </p>
                    </div>
            @endforeach
        </div>
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause  mb-5" style="animation-direction: reverse;">
            @foreach($evaluates_2 as $evaluate)
                <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{  $evaluate->user->avatar_url ? '/storage/' . $evaluate->user->avatar_url : asset('images/default.jpg') }}" class="size-12 ml-3 rounded-full" alt="">
                            <h4 class="text-md font-bold">{{ $evaluate->user->name }}</h4>
                        </div>
                        <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                    </div>
                    <p class="text-gray-600 text-sm">
                        {{ $evaluate->devloped }}
                    </p>
                </div>
            @endforeach
        </div>
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause mb-5">
            @foreach($evaluates_3 as $evaluate)
                <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{  $evaluate->user->avatar_url ? '/storage/' . $evaluate->user->avatar_url : asset('images/default.jpg') }}" class="size-12 ml-3 rounded-full" alt="">
                            <h4 class="text-md font-bold">{{ $evaluate->user->name }}</h4>
                        </div>
                        <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                    </div>
                    <p class="text-gray-600 text-sm">
                        {{ $evaluate->devloped }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
