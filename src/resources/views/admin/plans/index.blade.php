@extends('layouts.admin')

@section('content')
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Планы</h1>
  </div>
  <div class="grid grid-cols-3 gap-6">
    @foreach($plans as $plan)
      <div class="flex flex-col space-y-4">
        <form action="{{ route('admin.plans.update', $plan) }}" method="POST"
          class="bg-gray-50 rounded-xl border border-dashed border-blue-300 p-6 shadow-sm hover:shadow-md hover:border-blue-500 hover:border-solid flex flex-col space-y-6 transition duration-200">
          @csrf
          @method('PATCH')

          <div>
            <label class="block font-bold mb-1">Название</label>
            <input type="text" name="name" value="{{ $plan->name }}" class="w-full border border-gray-400 rounded-xl p-2">
          </div>

          <div>
            <label class="block font-bold mb-1">Цена</label>
            <input type="number" name="price" value="{{ $plan->price }}" class="w-full border border-gray-400 rounded-xl p-2">
          </div>

          <div>
            <label class="inline-flex items-center space-x-2 cursor-pointer">
              <input type="checkbox" name="is_popular" value="1" {{ $plan->is_popular ? 'checked' : '' }} class="hidden peer">
              <span
                class="w-5 h-5 border-2 border-gray-400 rounded-md flex items-center justify-center peer-checked:bg-[#FF7143] peer-checked:border-[#FF7143] transition duration-200">
              </span>
              <span class="font-medium">Популярный</span>
            </label>
          </div>

          <div>
            <h3 class="font-bold mb-2">Параметры</h3>
            @foreach($plan->features as $feature)
              <div class="flex space-x-2 mb-2">
                <input type="text" name="features[{{ $feature->id }}][value]" value="{{ $feature->value }}"
                  class="border border-gray-400 rounded-xl p-2 max-w-[50%]">
                <input type="text" name="features[{{ $feature->id }}][feature]" value="{{ $feature->feature }}"
                  class="border border-gray-400 rounded-xl p-2 max-w-[50%]">
              </div>
            @endforeach
          </div>

          <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-3 rounded-lg transition duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Сохранить</button>
        </form>

        @if(session('success_plan') == $plan->id)
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
            План обновлен!
          </div>
        @endif
      </div>
    @endforeach
  </div>
@endsection