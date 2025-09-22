<section class="top mb-[150px]">
    <div class="flex flex-row items-center justify-around">
        <div class="flex flex-col">
            <h2 class="font-bold text-8xl mb-[30px]">{{ $section->title }}</h2>
            <p class="max-w-90 text-[#696871] mb-[30px]">{{ $section->description }}</p>
            <a href="{{ $section->link }}"
                class="text-black bg-white inline py-[20px] px-[40px] max-w-[200px] text-center rounded-xl border-2 border-[#5454D4] hover:text-white hover:bg-[#5454D4] transition-all duration-200">Get
                Started</a>
        </div>
        @if($section->image_url)
            <img class="max-w-xl" src="{{ asset('storage/' . $section->image_url) }}" alt="{{ $section->title }}">
        @endif
    </div>
</section>