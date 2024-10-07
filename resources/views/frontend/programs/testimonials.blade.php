<section class="py-32 ">
    <div>
        <div class="flex justify-start items-center w-full">
            <div class="w-1/3 ">
                <img src="{{ asset('images/grid-line.svg') }}" class="w-full rotate-180" alt="">
            </div>
            <div class="w-2/3 mr-10">
                <h1 class="font-bold text-4xl text-gray-800">آراء المتدربيين عن الدورات و الورش المقدمة</h1
            </div>
        </div>
    </div>
    <div class="w-full inline-flex flex-col flex-nowrap overflow-hidden py-10" dir="ltr">
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause mb-5">
            @for($x = 0; $x < 20; $x++)
                    <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <img src="{{ asset('images/safa.jpg') }}" class="size-12 ml-3" alt="">
                                <h4 class="text-md font-bold">صفاء الحسيني</h4>
                            </div>
                            <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                        </div>
                        <p class="text-gray-600 text-sm">
                            تعد برامج مراكز الشباب مهمة لمساعدة الشباب على بناء الروابط الاجتماعية، وتطوير المهارات الحياتية، والوصول إلى الموارد التي تدعم رفاههم العام ونجاحهم في المستقبل.
                        </p>
                    </div>
            @endfor
        </div>
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause  mb-5" style="animation-direction: reverse;">
            @for($x = 0; $x < 20; $x++)
                    <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <img src="{{ asset('images/safa.jpg') }}" class="size-12 ml-3" alt="">
                                <h4 class="text-md font-bold">صفاء الحسيني</h4>
                            </div>
                            <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                        </div>
                        <p class="text-gray-600 text-sm">
                            تعد برامج مراكز الشباب مهمة لمساعدة الشباب على بناء الروابط الاجتماعية، وتطوير المهارات الحياتية، والوصول إلى الموارد التي تدعم رفاههم العام ونجاحهم في المستقبل.
                        </p>
                    </div>
            @endfor
        </div>
        <div class="flex  space-x-5  animate-infinite-scroll  hover:pause mb-5">
            @for($x = 0; $x < 20; $x++)
                <div dir="rtl" class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg w-[350px] max-w-full md:w-[450px] flex flex-col flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{ asset('images/safa.jpg') }}" class="size-12 ml-3" alt="">
                            <h4 class="text-md font-bold">صفاء الحسيني</h4>
                        </div>
                        <img src="{{ asset('images/small-icons.svg') }}" class="size-16" alt="">
                    </div>
                    <p class="text-gray-600 text-sm">
                        تعد برامج مراكز الشباب مهمة لمساعدة الشباب على بناء الروابط الاجتماعية، وتطوير المهارات الحياتية، والوصول إلى الموارد التي تدعم رفاههم العام ونجاحهم في المستقبل.
                    </p>
                </div>
            @endfor
        </div>
    </div>
</section>
