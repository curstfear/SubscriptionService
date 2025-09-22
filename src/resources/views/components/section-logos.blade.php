@props(['section'])

<section class="py-12 mb-[150px]">
    <div class="flex items-center justify-around flex-wrap">
        @foreach($section->logos as $logo)
            <a href="{{ $logo->link_url }}" target="_blank" rel="noopener noreferrer">
                <img src="{{ asset('storage/' . $logo->image_url) }}" alt="logo" class="max-w-[120px] hover:scale-150 transition-transform duration-200">
            </a>
        @endforeach
    </div>
</section>