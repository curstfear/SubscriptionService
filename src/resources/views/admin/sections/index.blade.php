@extends('layouts.admin')

@section('content')
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Секции</h1>
    <a href="{{ route('admin.sections.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
      Добавить секцию
    </a>
  </div>

  <table class="table-auto w-full border-collapse rounded-2xl overflow-hidden shadow-md">
    <thead>
      <tr class="bg-gray-200 text-black border-b-2 border-gray-300">
        <th class="px-4 py-5">Порядок</th>
        <th class="px-4 py-5">Название</th>
        <th class="px-4 py-5">Тип</th>
        <th class="px-4 py-5">Видимость</th>
        <th class="px-4 py-5">Действия</th>
      </tr>
    </thead>
    <tbody>
      @forelse($sections as $section)
        <tr data-section-id="{{ $section->id }}">
          <td class="bg-white px-4 py-2 text-center">
            <div class="flex items-center justify-center space-x-2">
              <button class="move-up bg-gray-300 text-black px-2 py-1 rounded hover:bg-gray-400 transition {{ $loop->first ? 'opacity-50 cursor-not-allowed' : '' }}"
                      data-section-id="{{ $section->id }}"
                      {{ $loop->first ? 'disabled' : '' }}>
                ↑
              </button>
              <span>{{ $section->order }}</span>
              <button class="move-down bg-gray-300 text-black px-2 py-1 rounded hover:bg-gray-400 transition {{ $loop->last ? 'opacity-50 cursor-not-allowed' : '' }}"
                      data-section-id="{{ $section->id }}"
                      {{ $loop->last ? 'disabled' : '' }}>
                ↓
              </button>
            </div>
          </td>
          <td class="bg-white px-4 py-2 text-center">{{ $section->name }}</td>
          <td class="bg-white px-4 py-2 text-center">{{ $section->type }}</td>
          <td class="bg-white px-4 py-2 text-center">
            <label class="inline-flex items-center cursor-pointer">
              <input type="checkbox" 
                     class="toggle-visibility sr-only peer" 
                     data-section-id="{{ $section->id }}" 
                     {{ $section->is_visible ? 'checked' : '' }}>
              <div class="relative w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-600 transition duration-200">
                <div class="absolute w-5 h-5 bg-white rounded-full top-0.5 left-0.5 peer-checked:translate-x-5 transition duration-200"></div>
              </div>
              <span class="ml-2 toggle-text">{{ $section->is_visible ? 'Видно' : 'Скрыто' }}</span>
            </label>
          </td>
          <td class="bg-white px-4 py-2 flex items-center justify-center space-x-4">
            @if ($section->type !== 'pricing')            
            <a href="{{ route('admin.sections.edit', $section) }}"
               class="bg-[#5454D4] my-[5px] text-white px-4 py-2 rounded-xl hover:bg-[#3535D2] transition duration-200">
              Редактировать
            </a>
            @else
            <div class="bg-white my-[5px] text-white px-4 py-2"></div>
            @endif
            @if ($section->type === 'default')            
            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" class="m-0" onsubmit="
                      return true;
                  ">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition duration-200">
                Удалить
              </button>
            </form>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center py-4">Секций пока нет</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {

      document.querySelectorAll('.toggle-visibility').forEach(toggle => {
        toggle.addEventListener('change', function () {
          const sectionId = this.dataset.sectionId;
          const isVisible = this.checked;
          const textEl = this.closest('label').querySelector('.toggle-text');

          fetch('/admin/sections/' + sectionId + '/toggle-visibility', {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            },
            body: JSON.stringify({ is_visible: isVisible })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              textEl.textContent = isVisible ? 'Видно' : 'Скрыто';
              alert(isVisible ? 'Секция теперь видна' : 'Секция теперь не видна');
            } else {
              alert('Ошибка при обновлении видимости');
              this.checked = !isVisible;
              textEl.textContent = isVisible ? 'Скрыто' : 'Видно';
            }
          })
          .catch(() => {
            alert('Ошибка при обновлении видимости');
            this.checked = !isVisible;
            textEl.textContent = isVisible ? 'Скрыто' : 'Видно';
          });
        });
      });


      document.querySelectorAll('.move-up').forEach(button => {
        button.addEventListener('click', function () {
          const sectionId = this.dataset.sectionId;
          changeOrder(sectionId, 'up');
        });
      });

      document.querySelectorAll('.move-down').forEach(button => {
        button.addEventListener('click', function () {
          const sectionId = this.dataset.sectionId;
          changeOrder(sectionId, 'down');
        });
      });

      function changeOrder(sectionId, direction) {
        fetch('/admin/sections/' + sectionId + '/change-order', {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ direction: direction })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {

            const currentRow = document.querySelector(`tr[data-section-id="${sectionId}"]`);
            const siblingRow = direction === 'up' 
              ? currentRow.previousElementSibling 
              : currentRow.nextElementSibling;

            if (siblingRow) {

              const currentOrder = currentRow.querySelector('td:nth-child(1) span'); 
              const siblingOrder = siblingRow.querySelector('td:nth-child(1) span');

              const temp = currentOrder.textContent;
              currentOrder.textContent = siblingOrder.textContent;
              siblingOrder.textContent = temp;


              if (direction === 'up') {
                currentRow.parentNode.insertBefore(currentRow, siblingRow);
              } else {
                currentRow.parentNode.insertBefore(siblingRow, currentRow);
              }


              updateButtonStates();
              alert('Порядок секции изменен');
            }
          } else {
            alert('Ошибка при изменении порядка');
          }
        })
        .catch(() => {
          alert('Ошибка при изменении порядка');
        });
      }

      function updateButtonStates() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
          const upButton = row.querySelector('.move-up');
          const downButton = row.querySelector('.move-down');

          if (index === 0) {
            upButton.disabled = true;
            upButton.classList.add('opacity-50', 'cursor-not-allowed');
          } else {
            upButton.disabled = false;
            upButton.classList.remove('opacity-50', 'cursor-not-allowed');
          }

          if (index === rows.length - 1) {
            downButton.disabled = true;
            downButton.classList.add('opacity-50', 'cursor-not-allowed');
          } else {
            downButton.disabled = false;
            downButton.classList.remove('opacity-50', 'cursor-not-allowed');
          }
        });
      }
    });
  </script>
@endsection