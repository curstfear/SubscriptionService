@props(['section'])

<section class="mb-[120px]">
    <div class="flex {{ $section->is_reversed ? 'flex-row-reverse' : 'flex-row' }} items-center justify-around">
        @if($section->image_url)
            <img class="max-w-sm" src="{{ asset('storage/' . $section->image_url) }}" alt="{{ $section->title }}">
        @endif
        <div class="flex flex-col">
            <h2 class="font-bold text-5xl mb-[30px]">{{ $section->title }}</h2>
            <p class="max-w-90 text-[#696871] mb-[30px]">{{ $section->description }}</p>
            @if ($section->link)
                <a href="{{ $section->link }}" class="text-[#5454D4] font-bold">Learn more</a>
            @endif
        </div>

        @if($section->items->count())
            <div class="flex gap-30">
                @foreach($section->items as $item)
                    <div class="flex flex-col items-center justify-around text-center">
                        @if($item->image_url)
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->title }}" class="mb-4 max-w-[150px] hover:scale-150 transition-transform duration-200">
                        @endif
                        <h3 class="font-semibold text-xl mb-[20px]">{{ $item->title }}</h3>
                        <p class="text-[#696871] text-sm">{{ $item->description }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>