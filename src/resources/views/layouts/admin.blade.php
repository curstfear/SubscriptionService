@vite('resources/css/app.css')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin panel</title>
</head>

<body class="bg-gray-100 h-screen flex flex-col">
    
    <header class="bg-white shadow mb-8">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('pages.home') }}">
                <img class="max-w-[150px]" src="{{ asset('storage/logo.svg') }}" alt="Logo">
            </a>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('admin.index') }}" class="text-blue-500 hover:underline">Главная</a></li>
                    <li><a href="{{ route('admin.sections.index') }}" class="text-blue-500 hover:underline">Секции</a>
                    </li>
                    <li><a href="{{ route('admin.plans.index') }}" class="text-blue-500 hover:underline">Планы</a></li>
                </ul>
            </nav>
        </div>
    </header>

    
    <main class="container mx-auto px-4 flex-1 pb-4">
        @yield('content')
        @yield('scripts')
    </main>

</body>
</html>