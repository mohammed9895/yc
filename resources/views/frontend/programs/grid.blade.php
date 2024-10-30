<section class="py-32">
    <div class="flex justify-between items-center">
        <div class="w-1/3 mr-10">
            <h1 class="font-bold text-4xl text-gray-800 mb-4">اكتشف البرامج الصيفية</h1>
            <h2 class="text-xl text-gray-500">عش تجارب استثنائية لتوسع آفاق معرفتك</h2>
        </div>
        <div class="w-2/3">
            <img src="{{ asset('images/grid-line.svg') }}" class="w-full" alt="">
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mt-10 mx-10">
        @foreach($upcoming_programs as $program)
            <div class="bg-white shadow-sm ring-1 ring-black/5 data-[dark]:bg-gray-800 data-[dark]:ring-white/15 p-5 rounded-lg">
            <img src="/storage/{{ $program->cover }}" class="mb-3" alt="">
            <h1 class="text-xl">{{ $program->title }}</h1>
            <p class="text-gray-500 text-sm mt-5">{{ $program->description }}</p>
            <div class="mt-5">
                <a href="/cp/available-workshops" class="inline-flex items-center justify-center bg-[#537BDB] px-5 py-2 rounded text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                    </svg>
                    <span>
                                سجل الإن
                           </span>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
