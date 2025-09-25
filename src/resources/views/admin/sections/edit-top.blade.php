@extends('layouts.admin')

@section('content')
  <div class="h-full w-full bg-white rounded-xl shadow-lg p-10">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Редактирование секции</h1>
      <p class="text-lg text-gray-600">{{ $section->name }}</p>
    </div>

    <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data"
      class="space-y-6">
      @csrf
      @method('PUT')

      <div class="space-y-2">
        <label for="title" class="block text-xl font-semibold text-gray-700">
          Заголовок <span class="text-red-500">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $section->title) }}" required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('title') border-red-500 @enderror"
          placeholder="Введите заголовок секции">
        @error('title')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="space-y-2">
        <label for="description" class="block text-xl font-semibold text-gray-700">
          Описание <span class="text-red-500">*</span>
        </label>
        <textarea id="description" name="description" rows="4" required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 resize-vertical @error('description') border-red-500 @enderror"
          placeholder="Введите описание секции">{{ old('description', $section->description) }}</textarea>
        @error('description')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="space-y-2">
        <label for="image" class="block text-xl font-semibold text-gray-700">
          Изображение
        </label>

        @if($section->image_url)
          <div class="mb-4 p-4 bg-gray-50 rounded-lg border">
            <p class="text-sm text-gray-600 mb-3">Текущее изображение:</p>
            <div class="inline-block">
              <img src="{{ asset('storage/' . $section->image_url) }}" alt="Изображение секции"
                class="max-w-xs h-auto rounded-lg shadow-sm border border-gray-200">
            </div>
          </div>
  @endif
  <div class="relative">
          <input type="file" id="image" name="image" accept="image/*"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('image') border-red-500 @enderror">
        </div>
        <p class="text-sm text-gray-500">Поддерживаемые форматы: JPEG, PNG, JPG, GIF, SVG, WebP. Максимальный размер: 2MB
        </p>
        @error('image')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="space-y-2">
        <label for="link" class="block text-xl font-semibold text-gray-700">
          Ссылка <span class="text-red-500">*</span>
        </label>
        <input type="url" id="link" name="link" value="{{ old('link', $section->link) }}" required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('link') border-red-500 @enderror"
          placeholder="https://example.com">
        @error('link')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center space-x-4 pt-6">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-3 rounded-lg transition duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          <span class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Обновить секцию
          </span>
        </button>

        <a href="{{ route('admin.sections.index') }}"
          class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-8 py-3 rounded-lg transition duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
          <span class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Отмена
          </span>
        </a>
      </div>
    </form>
    <div class="mt-4 text-sm text-gray-600">
      <p><span class="text-red-500">*</span> - обязательные для заполнения поля</p>
    </div>
  </div>

@endsection