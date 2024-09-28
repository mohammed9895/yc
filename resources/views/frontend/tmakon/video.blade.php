<section class="relative">
    <div class="w-full h-[500px] relative" style="background: url('{{asset('images/tmakon-line.svg')}}'); background-size: cover; background-repeat: no-repeat; background-position: bottom;"></div>
    <div class="bg-[#000647]  -mt-24">
        @include('frontend.tmakon.slider')
        <div class="flex justify-between items-center relative">
            <div class="p-12 w-1/2">
                <h1 class="text-5xl text-white font-bold mb-6">تمكُن .. عن قرب</h1>
                <p class="text-white text-2xl leading-relaxed">برنامج تمكن أصحاب العمل الحر هو برنامج يستهدف تمكين الشباب بالمهارات اللازمة لتحويل مهاراتهم إلى مصدر دخل كأصحاب عمل مستقلين، ويهدف البرنامج إلى تعزيز الجهود المبذولة لدعم أصحاب العمل المستقلين، والعمل على إبرازها محليا ودوليا.</p>
                <p class="text-white text-2xl leading-relaxed mt-3">كذلك بهدف تمكين الشباب العماني من أصحاب المهارات وتعزيز لجهود مختلف الجهات لدعم وتمكين ونمو أصحاب المهارات تماشيا مع التوجه العالمي (gig economy).</p>
                <div class="mt-16 flex">
                    <img src="{{ asset('images/tmakon.svg') }}" class=" h-16 ml-2" alt="">
                    <img src="{{ asset('images/omanoil.svg') }}" class=" h-16" alt="">
                </div>
            </div>
            <div class="relative w-1/2">
                <video autoplay muted loop width="100%">
                    <source src="{{ asset('images/tamkon.mov') }}">
                </video>
                <div class="w-full h-full absolute top-0 right-0" style="background: url('{{asset('images/video-overlay.svg')}}'); background-repeat: no-repeat; background-size: cover;">
                </div>

            </div>
        </div>
</section>
