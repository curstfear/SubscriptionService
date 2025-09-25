@extends('layouts.admin')

@section('content')
  <div class="h-full w-full bg-white rounded-xl shadow-lg p-10">
    <p class="text-2xl text-gray-600 mb-[50px]">Секция: {{ $section->name }}</p>
    <form action="{{ route('admin.sections.update', $section) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="title" class="block text-2xl text-gray-800 font-bold mb-2">Заголовок</label>
        <input type="text" id="title" name="title" value="{{ $section->title }}"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          required>
      </div>
    </form>


    <h1>{{ $section->title }}</h1>
    <h1>{{ $section->description }}</h1>
    <h1>{{ $section->image_url }}</h1>
    <h1>{{ $section->link }}</h1>
    <h1>{{ $section->type }}</h1>
    <h1>{{ $section->is_reversed }}</h1>
    <h1>{{ $section->page_id }}</h1>
  </div>
@endsection