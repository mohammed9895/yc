<section class="py-32">
    <div class="mb-12 px-10">
        <h1 class="text-5xl text-gray-800 font-bold mb-8">البرامج و الفعاليات {{ $upcoming ? 'القادمة' : 'السابقة' }} </h1>
        <p class="text-lg text-gray-500">تصفح  البرامج المُتاحة للتسجيل</p>
    </div>
    <div class="owl-carousel-timeline owl-carousel w-full">
        @foreach($upcoming_programs as $program)
            <div class="item relative">
                <div class="relative">
                    <div class="absolute h-1 w-full bg-[#B7F200] top-1/2 left-0"></div>
                    <div class="text-xl font-bold bg-[#3B57A7] text-white inline-block p-5 rounded-lg relative mr-10">
                        {{ $program->start_date }}
                    </div>
                </div>
                <div class="mt-5 pr-10">
                    <h1 class="text-[#3B57A7] font-bold text-2xl">{{ $program->title }}</h1>
                    <p class="text-gray-400 mt-2">{{ $program->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
