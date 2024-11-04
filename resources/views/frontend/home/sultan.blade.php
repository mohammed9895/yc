<section class="">
    <div class="container mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 md:grid-rows-5 gap-4">
            <div class="col-span-2 md:row-span-2 bg-gray-50/60 px-5 pt-5 rounded-lg shadow-sm ring-1 ring-black/5">
                <div class="flex flex-col md:flex-row">
                    <div>
                        <div class="size-20 items-center justify-center">
                            <svg class="size-14 fill-[#720AD8] bg-[#720AD8]/30 p-4 rounded-lg" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 viewBox="0 0 32 32" xml:space="preserve">
                                    <g>
                                        <g id="right_x5F_quote">
                                            <g>
                                                <path  d="M0,4v12h8c0,4.41-3.586,8-8,8v4c6.617,0,12-5.383,12-12V4H0z"/>
                                                <path  d="M20,4v12h8c0,4.41-3.586,8-8,8v4c6.617,0,12-5.383,12-12V4H20z"/>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                        </div>
                        <h1 class="text-[#720AD8] text-2xl font-bold mb-3">حضرة صاحب الجلالة السلطان هيثم بن طارق آل سعيد</h1>
                        <p class="text-lg text-gray-500">إن الشباب هم ثروة الأمم وموردها الذي لا ينضب، وسواعدها التي تبني، هم حاضر الأمة ومستقبلها، وسوف نحرص على الاستماع لهم وتلمُس احتياجاتهم واهتماماتهم وتطلعاتهم، ولا شك أنها ستجد العناية التي تستحقها.</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/sultan-haitham.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="md:row-span-2 md:col-start-3 bg-green-100 px-5 pt-5 rounded-lg flex justify-center items-center shadow-sm ring-1 ring-green-900/10">
                <div class="flex flex-col items-center justify-center">
                    <div class="mb-3">
                        {!! $statistices[1]->icon !!}
                    </div>
                    <h1 class="text-7xl font-bold text-green-900">{{ $statistices[1]->number }}</h1>
                    <h3 class="text-lg text-green-900">{{ $statistices[1]->title }}</h3>
                </div>
            </div>
            <div class="md:row-span-2 md:col-start-1 md:row-start-3 bg-cyan-100 px-5 pt-5 rounded-lg flex justify-center items-center shadow-sm ring-1 ring-cyan-900/10">
                <div class="flex flex-col items-center justify-center">
                    <div class="mb-3">
                        {!! $statistices[0]->icon !!}
                    </div>
                    <h1 class="text-7xl font-bold text-cyan-900">{{ $statistices[0]->number }}</h1>
                    <h3 class="text-lg text-cyan-900">{{ $statistices[0]->title }}</h3>
                </div>
            </div>
            <div class="col-span-2 md:row-span-2 md:col-start-3 row-start-3 bg-gray-50/60 px-5 pt-5 rounded-lg shadow-sm ring-1 ring-black/5">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="ml-4">
                        <img src="{{ asset('images/y3.png') }}" width="800" alt="">
                    </div>
                    <div>
                        <div class="size-20 items-center justify-center">
                            <svg class="size-14 fill-[#537BDB] bg-[#537BDB]/30 p-4 rounded-lg" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 viewBox="0 0 32 32" xml:space="preserve">
                                    <g>
                                        <g id="right_x5F_quote">
                                            <g>
                                                <path  d="M0,4v12h8c0,4.41-3.586,8-8,8v4c6.617,0,12-5.383,12-12V4H0z"/>
                                                <path  d="M20,4v12h8c0,4.41-3.586,8-8,8v4c6.617,0,12-5.383,12-12V4H20z"/>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                        </div>
                        <h1 class="text-[#537BDB] text-2xl font-bold mb-3">السيد ذي يزن بن هيثم بن طارق آل سعيد
                            <br>
                            وزير الثقافة والرياضة والشباب </h1>
                        <p class="text-lg text-gray-500">معاهدين جلالته أن نكون جنود اأوفياء لخدمةِ وطننِا عمان في مختلف الميادين وعلى كلِّ الأصعدةِ تحت ظلِّ قيادةِ جلالتِه الحكيمةَ مسترشدين بتوجيهاته السديدةِ للوصول بعمانِنا الغالية إلى ذرى السؤددِ وهاماتِ المجد.</p>
                    </div>
                </div>
            </div>
            <div class="md:row-span-2 md:col-start-4 md:row-start-1 bg-orange-100 px-5 pt-5 rounded-lg flex justify-center items-center shadow-sm ring-1 ring-orange-900/10">
                <div class="flex flex-col items-center justify-center">
                    <div class="mb-3">
                        {!! $statistices[3]->icon !!}
                    </div>
                    <h1 class="text-7xl font-bold text-orange-900">{{ $statistices[3]->number }}</h1>
                    <h3 class="text-lg text-orange-900">{{ $statistices[3]->title }}</h3>
                </div>
            </div>
            <div class="md:row-span-2 md:col-start-2 md:row-start-3 bg-rose-100 px-5 pt-5 rounded-lg flex justify-center items-center shadow-sm ring-1 ring-rose-900/10">
                <div class="flex flex-col items-center justify-center">
                    <div class="mb-3">
                        {!! $statistices[2]->icon !!}
                    </div>
                    <h1 class="text-7xl font-bold text-rose-900">{{ $statistices[2]->number }}</h1>
                    <h3 class="text-lg text-rose-900">{{ $statistices[2]->title }}</h3>
                </div>
            </div>
        </div>
    </div>
</section>
