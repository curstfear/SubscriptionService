@props(['section'])

<section class="mb-[150px]">
    <div class="flex {{ $section->is_reversed ? 'flex-row-reverse' : 'flex-row' }} items-center justify-around">

        @if($section->image_url)
            <img class="max-w-sm" src="{{ asset('storage/' . $section->image_url) }}" alt="{{ $section->title }}">
        @endif

        @if($section->title || $section->description || $section->link)
            <div class="flex flex-col max-w-[550px]">
                @if($section->title)
                    <h2 class="font-bold text-5xl mb-[30px]">{{ $section->title }}</h2>
                @endif

                @if($section->description)
                    <p class="max-w-90 text-[#696871] mb-[30px]">{{ $section->description }}</p>
                @endif

                @if ($section->link)
                    <a href="{{ $section->link }}" class="text-[#5454D4] font-bold">Learn more</a>
                @endif
            </div>
        @endif

        @if($section->items->count())
            <div class="flex justify-center items-center gap-6">
                @foreach($section->items as $item)
                    @if($item->title || $item->description || $item->image_url)
                        <div class="flex flex-col max-w-[310px] items-center text-center">
                            @if($item->image_url)
                                <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->title }}"
                                    class="mb-4 max-w-[150px] hover:scale-150 transition-transform duration-200">
                            @endif

                            @if($item->title)
                                <h3 class="font-semibold text-xl mb-[20px]">{{ $item->title }}</h3>
                            @endif

                            @if($item->description)
                                <p class="text-[#696871] text-sm">{{ $item->description }}</p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

    </div>
</section>