<div>
    <div class="mt-3 flex space-x-8 space-x-reverse border-b border-gray-50/30">
        @foreach($tmakonCtegories as $category)
            <a wire:click="setCategory({{ $category->id }})" class="text-white inline-block py-5 text-lg hover:text-[#B7F200] @if($selectedCategory == $category->id) text-[#B7F200] @endif">{{ $category->name }}</a>
        @endforeach
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 mt-10 gap-7">
        @foreach($this->tmakonUsers as $user)
            <div class="pt-5 bg-gradient-to-tl from-[#F05964] to-transparent rounded-lg flex justify-between items-center relative">
                <div>
                    <img src="/storage/{{ $user->image }}"  class="w-72" alt="">
                </div>
                <div class="text-right text-white flex-1">
                    <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                    <h1 class="text-lg text-white mt-2">{{ $user->job }}</h1>
                </div>
                <a href="mailto:{{ $user->email }}" class="bg-white rounded-full px-3 py-2 absolute bottom-5 left-5 text-[#000647]">تواصل معي</a>
            </div>
        @endforeach
    </div>
</div>
