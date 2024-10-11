<section class="w-full h-full flex justify-center items-center bg-[#000F4A] relative flex-col">
    <form wire:submit="register">
        {{ $this->form }}
    </form>
    <div class="absolute bottom-0 left-0 flex">
        <img src="{{ asset('images/website icons-01.png') }}" width="400" alt="">
        <img src="{{ asset('images/website icons-02.png') }}" width="400" alt="">
        <img src="{{ asset('images/website icons-03.png') }}" width="400" alt="">
        <img src="{{ asset('images/website icons-04.png') }}" width="400" alt="">
    </div>
</section>
