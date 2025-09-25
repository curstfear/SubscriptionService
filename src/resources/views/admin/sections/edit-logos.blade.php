@extends('layouts.admin')

@section('content')
  <div class="w-full bg-white rounded-xl shadow-lg p-10">
    <div class="mb-10">
      <h1 class="text-3xl font-bold text-gray-800">Редактирование логотипов</h1>
      <p class="text-lg text-gray-600 mt-1 mb-3">{{ $section->name }}</p>
      <p>Максимум <span class="font-bold text-red-500">6</span> логотипов</p>
    </div>

    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data"
      class="space-y-10" id="logo-form">
      @csrf
      @method('PUT')
      <input type="hidden" name="delete_ids" id="delete_ids" value="">

      <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($section->logos as $logo)
          <div
            class="bg-gray-50 rounded-xl border p-6 shadow-sm hover:shadow-md hover:border-blue-300 flex flex-col space-y-6"
            data-logo-id="{{ $logo->id }}">
            <h2 class="text-sm font-semibold text-gray-700">Логотип #{{ $loop->iteration }}</h2>
            <div class="flex flex-col items-center space-y-3">
              @if($logo->image_url)
                <img src="{{ asset('storage/' . $logo->image_url) }}" alt="Изображение логотипа"
                  class="w-32 h-32 object-contain rounded-lg shadow border border-gray-200">
                <span class="text-xs text-gray-400">Текущее изображение</span>
              @endif
              <input type="file" id="image_{{ $logo->id }}" name="images[{{ $logo->id }}]"
                accept="image/jpeg,image/png,image/gif,image/svg+xml,image/webp"
                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg p-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-2 file:py-2 file:px-2 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
              <span class="text-xs text-gray-500">JPEG, PNG, GIF, WebP • до 2MB</span>
              @error("images.{$logo->id}")
                <span class="text-xs text-red-500">{{ $message }}</span>
              @enderror
            </div>
            <div class="flex flex-col space-y-2">
              <label for="link_{{ $logo->id }}" class="text-sm font-medium text-gray-600">Ссылка <span
                  class="text-red-500">*</span></label>
              <input type="text" id="link_{{ $logo->id }}" name="links[{{ $logo->id }}]"
                value="{{ old("links.{$logo->id}", $logo->link_url) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                placeholder="Введите ссылку" required>
              @error("links.{$logo->id}")
                <span class="text-xs text-red-500">{{ $message }}</span>
              @enderror
              <button type="button"
                class="delete-logo-btn w-full flex items-center justify-center gap-2 text-red-600 hover:text-red-800 font-medium px-4 py-2 rounded transition border border-red-200 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 mt-4"
                data-logo-id="{{ $logo->id }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Удалить
              </button>
            </div>
          </div>
        @endforeach

        @for ($i = $section->logos->count(); $i < 6; $i++)
          <div class="logo-slot">
            <div
              class="new-logo-card max-h-[490px] h-full hidden bg-gray-50 rounded-xl border p-6 shadow-sm hover:shadow-md hover:border-blue-300 flex flex-col space-y-6">
              <div class="flex justify-between items-center">
                <h2 class="text-sm font-semibold text-gray-700">Новый логотип</h2>
                <button type="button" onclick="hideLogo(this)" class="text-red-500 hover:text-red-700 transition">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
              <div class="flex flex-col items-center space-y-3">
                <div
                  class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-100">
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z">
                    </path>
                  </svg>
                </div>
                <input type="file" name="new_images[]" accept="image/jpeg,image/png,image/gif,image/svg+xml,image/webp"
                  class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg p-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-2 file:py-2 file:px-2 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <span class="text-xs text-gray-500">JPEG, PNG, GIF, SVG, WebP • до 2MB</span>
                @error("new_images.{$i}")
                  <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
              </div>
              <div class="flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-600">Ссылка</label>
                <input type="text" name="new_links[]" value="{{ old("new_links.{$i}") }}"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                  placeholder="Введите ссылку">
                @error("new_links.{$i}")
                  <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div
              class="add-logo-btn flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-6 text-gray-400 hover:border-blue-400 hover:text-blue-500 transition cursor-pointer"
              onclick="showNextLogo(this)">
              <div class="flex flex-col items-center space-y-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-sm font-medium">Добавить логотип</span>
              </div>
            </div>
          </div>
        @endfor
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

    <div class="mt-6 text-sm text-gray-600">
      <p><span class="text-red-500">*</span> — обязательные для заполнения поля</p>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function showNextLogo(btn) {
      const slot = btn.closest('.logo-slot');
      const logoCard = slot.querySelector('.new-logo-card');
      const addBtn = slot.querySelector('.add-logo-btn');

      if (logoCard && addBtn) {
        logoCard.classList.remove('hidden');
        logoCard.classList.add('flex', 'flex-col', 'space-y-6');
        logoCard.style.opacity = 0;
        setTimeout(() => logoCard.style.opacity = 1, 10);
        addBtn.classList.add('hidden');
        updateAddLogoButtons();
      }
    }

    function hideLogo(btn) {
      const slot = btn.closest('.logo-slot');
      const logoCard = slot.querySelector('.new-logo-card');
      const addBtn = slot.querySelector('.add-logo-btn');

      if (logoCard && addBtn) {
        logoCard.classList.add('hidden');
        logoCard.classList.remove('flex', 'flex-col', 'space-y-6');
        logoCard.style.opacity = '';
        addBtn.classList.remove('hidden');

        const fileInput = logoCard.querySelector('input[type="file"]');
        const linkInput = slot.querySelector('input[type="text"]');
        if (fileInput) fileInput.value = '';
        if (linkInput) linkInput.value = '';
        updateAddLogoButtons();
      }
    }

    let deleteIds = [];
    document.querySelectorAll('.delete-logo-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        if (!confirm('Удалить этот логотип?')) return;

        const logoId = btn.getAttribute('data-logo-id');
        if (logoId && !deleteIds.includes(logoId)) {
          deleteIds.push(logoId);
          document.querySelector('#delete_ids').value = deleteIds.join(',');
        }

        const logoCard = btn.closest('div[data-logo-id]');
        if (logoCard) {
          logoCard.remove();
          updateAddLogoButtons();
        }
      });
    });

    document.querySelector('#logo-form').addEventListener('submit', (e) => {
      const newLogoCards = document.querySelectorAll('.new-logo-card:not(.hidden)');

      document.querySelectorAll('.new-logo-card input[type="file"]').forEach(input => input.removeAttribute('name'));
      document.querySelectorAll('.new-logo-card input[type="text"]').forEach(input => input.removeAttribute('name'));

      newLogoCards.forEach((card, index) => {
        const fileInput = card.querySelector('input[type="file"]');
        const linkInput = card.querySelector('input[type="text"]');

        if (fileInput?.files.length || linkInput?.value.trim()) {
          fileInput.name = `new_images[${index}]`;
          linkInput.name = `new_links[${index}]`;
        }
      });
    });

    function updateAddLogoButtons() {
      const totalLogos = document.querySelectorAll('div[data-logo-id]').length + document.querySelectorAll('.new-logo-card:not(.hidden)').length;

      document.querySelectorAll('.logo-slot').forEach(slot => {
        const addBtn = slot.querySelector('.add-logo-btn');
        const logoCard = slot.querySelector('.new-logo-card');
        if (addBtn && logoCard) {
          addBtn.classList.toggle('hidden', !logoCard.classList.contains('hidden') || totalLogos >= 6);
        }
      });
    }

    document.addEventListener('DOMContentLoaded', updateAddLogoButtons);
  </script>
@endsection