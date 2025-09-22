@vite('resources/css/app.css')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $page->title }}</title>
</head>
<body>
  <div class="container">
    @foreach($page->sections as $section)
      @switch($section->type) 
        @case('top') 
          <x-section-top :section="$section" /> 
          @break
        @case('logos')
          <x-section-logos :section="$section" /> 
          @break
        @default 
          <x-section-default :section="$section" /> 
      @endswitch 
    @endforeach
  </div>  
</body>
</html>
