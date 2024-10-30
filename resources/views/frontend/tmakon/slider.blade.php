<section class="px-8 pb-20">
        <div class="owl-carousel owl-carousel-tmakon">
            @foreach($tmakonUsers as $tmakonUser)
                <x-frontend.talent-card :image="'/storage/' . $tmakonUser->image" :name="$tmakonUser->name" :position="$tmakonUser->job" :bg="'bg-gray-300'" />
            @endforeach
        </div>
</section>
