@extends('layouts.admin')

@section('content')
  <div class="h-full w-full bg-white rounded-xl shadow-lg p-10">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Добавление секции</h1>
    </div>

    <form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data"
      class="space-y-6">
      @csrf

      <div class="space-y-2">
        <label for="name" class="block text-xl font-semibold text-gray-700">
          Имя <span class="text-red-500">*</span>
        </label>
        <input type="text" id="name" name="name" required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('name') border-red-500 @enderror"
          placeholder="Введите имя секции">
        @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="space-y-2">
        <label for="title" class="block text-xl font-semibold text-gray-700">
          Заголовок <span class="text-red-500">*</span>
        </label>
        <input type="text" id="title" name="title" required
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
          placeholder="Введите описание секции"></textarea>
        @error('description')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="space-y-2">
        <label for="image" class="block text-xl font-semibold text-gray-700">
          Изображение<span class="text-red-500">*</span>
        </label>

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
          Ссылка
        </label>
        <input type="url" id="link" name="link"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('link') border-red-500 @enderror"
          placeholder="https://example.com">
        @error('link')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="space-y-2">
        <label for="is_reversed" class="block text-xl font-semibold text-gray-700">
          Отзеркалить секцию
        </label>
        <select id="is_reversed" name="is_reversed" required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-white @error('is_reversed') border-red-500 @enderror">
          <option value="" disabled>
            Выберите опцию
          </option>
          <option value="0">
            Нет
          </option>
          <option value="1">
            Да
          </option>
        </select>
        @error('is_reversed')
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
            Добавить секцию
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