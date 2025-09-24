@props(['section'])

<section>
    <div class="container">
        <h1 class="font-bold text-6xl mb-[100px] max-w-[525px]">{{ $section->title }}</h1>
        <div class="flex items-center justify-between flex-wrap">
            @foreach($section->plans as $plan)
                <div
                    class="flex flex-col items-center text-center rounded-[10px] p-[30px] mb-[100px] w-[330px] h-[440px]
                                    {{ $plan->is_popular ? 'scale-[1.2] bg-[#FF7143] text-white' : 'bg-[#F8F8F8] text-[#696871]' }}">

                    <p class="text-lg">{{ $plan->name }}</p>
                    <div class="mb-[20px]">
                        @if ($plan->price === 0)
                            <p class="font-bold text-5xl my-[30px] {{ $plan->is_popular ? 'text-white' : 'text-[#1D293F]' }}">
                                Free</p>
                        @else
                            <p class="font-bold text-5xl my-[30px] {{ $plan->is_popular ? 'text-white' : 'text-[#1D293F]' }}">
                                ${{ $plan->price }}<span class="text-lg font-bold">/month</span>
                            </p>
                        @endif
                    </div>
                    <div class="mb-[40px]">
                        @foreach ($plan->features as $feature)
                            <p class="mb-[20px]">
                                {{ $feature->value }} <span>{{ $feature->feature }}</span>
                            </p>
                        @endforeach
                    </div>

                    <a class="rounded-[5px] px-[30px] py-[15px] font-bold border-1
                                           {{ $plan->is_popular ? 'bg-[#9F3919] border-[#9F3919] text-white' : 'bg-white border-[#EAE9F2] text-[#5454D4]' }}"
                        href="{{ $plan->link }}">
                        Get Started
                    </a>

                </div>
            @endforeach
        </div>
    </div>
</section>