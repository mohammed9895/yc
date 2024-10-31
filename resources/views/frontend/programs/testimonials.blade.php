<section class="py-32">
    <div>
        <div class="flex flex-col md:flex-row justify-start items-center w-full">
            <div class="w-full md:w-1/3 mt-5 md:mb-0">
                <img src="{{ asset('images/grid-line.svg') }}" class="w-full rotate-180" alt="">
            </div>
            <div class="w-full md:w-2/3 md:mr-10">
                <h1 class="font-bold text-4xl text-gray-800">آراء المتدربيين عن الدورات و الورش المقدمة</h1
            </div>
        </div>
    </div>
    <div class="w-full inline-flex flex-col flex-nowrap overflow-hidden py-10" dir="ltr">
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause mb-5">
            @foreach($evaluates_1 as $evaluate)
                    <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <img src="/storage/{{  $evaluate->user->avatar_url }}" class="size-12 ml-3" alt="">
                                <h4 class="text-md font-bold">{{ $evaluate->user->name }}</h4>
                            </div>
                            <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                        </div>
                        <p class="text-gray-600 text-sm">
                            {{ $evaluate->suggestions }}
                        </p>
                    </div>
            @endforeach
        </div>
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause  mb-5" style="animation-direction: reverse;">
            @foreach($evaluates_2 as $evaluate)
                <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="/storage/{{  $evaluate->user->avatar_url }}" class="size-12 ml-3" alt="">
                            <h4 class="text-md font-bold">{{ $evaluate->user->name }}</h4>
                        </div>
                        <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                    </div>
                    <p class="text-gray-600 text-sm">
                        {{ $evaluate->suggestions }}
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
                        {{ $evaluate->suggestions }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
