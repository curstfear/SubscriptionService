@vite('resources/css/app.css')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title }}</title>
</head>
<body>
  <header class="mt-[40px] mb-[100px]">
    <div class="container">
      <nav>
        <ul class="flex justify-between items-center">
          <li>
            <a href="#">
              <img src="{{ asset('storage/logo.svg') }}" alt="">
            </a>
          </li>
          <div class="flex gap-5 items-center">
            @can('view', App\Models\User::class)
            <li>
              <a href="{{ route('admin.index') }}">
                <div class="border-2 border-[#5454D4] rounded-[20px] cursor-pointer flex items-center p-4 hover:bg-[#5454D4] hover:px-7 hover:rounded-[10px] hover:text-white transition-all duration-200">
                  <span>Admin</span>
                </div>
              </a>
            </li>
            @endcan
            <li>
              <a href="{{ route('login') }}">
                <div class="border-2 border-[#5454D4] rounded-[50px] p-3 cursor-pointer hover:bg-[#5454D4] hover:px-5 hover:rounded-[20px] transition-all duration-200">
                  <img class="max-w-[30px]" src="{{ asset('storage/user-icon.png') }}" alt="">
                </div>
              </a>
            </li>
          </div>
        </ul>
      </nav>
    </div>
  </header>
  <div class="container">
    @foreach($page->sections as $section)
  @if($section->is_visible) 
        @switch($section->type) 
          @case('top') 
            <x-section-top :section="$section" /> 
            @break
          @case('logos')
            <x-section-logos :section="$section" /> 
            @break
          @case('pricing')
            <x-section-pricing :section="$section" />
            @break
          @default 
            <x-section-default :section="$section" /> 
        @endswitch 
      @endif
    @endforeach
  </div>  
</body>
</html>