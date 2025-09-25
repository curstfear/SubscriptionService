@extends('layouts.admin')

@section('content')
  <h1 class="text-3xl font-bold">Добро пожаловать, {{ auth()->user()->name }}!</h1>
  <p class="text-xl mb-10">Вы находитесь в административной панели.</p>
  <div class="flex gap-5 flex-wrap mb-[50px]">
    <div
      class="bg-white max-w-[370px] min-h-[200px] w-full p-[10px] px-[25px] rounded-xl flex flex-row items-start justify-between gap-[70px]">
      <div class="flex flex-col justify-between h-full">
        <div>
          <p class="text-[#202224] mb-[15px]">Total User</p>
          <p class="text-3xl font-bold mb-[50px]">{{ $userCount }}</p>
        </div>
        <p>Какая-нибудь статистика</p>
      </div>
      <img src="{{ asset('storage/admin/users.png') }}" alt="users">
    </div>

    <div
      class="bg-white max-w-[370px] min-h-[200px] w-full p-[10px] px-[25px] rounded-xl flex flex-row items-start justify-between gap-[70px]">
      <div class="flex flex-col justify-between h-full">
        <div>
          <p class="text-[#202224] mb-[15px]">Total Sections</p>
          <p class="text-3xl font-bold mb-[50px]">{{ $sectionCount }}</p>
        </div>
        <p>Какая-нибудь статистика</p>
      </div>
      <img src="{{ asset('storage/admin/sections.png') }}" alt="users">
    </div>
    <div
      class="bg-white max-w-[370px] min-h-[200px] w-full p-[10px] px-[25px] rounded-xl flex flex-row items-start justify-between gap-[70px]">
      <div class="flex flex-col justify-between h-full">
        <div>
          <p class="text-[#202224] mb-[15px]">Total Plans</p>
          <p class="text-3xl font-bold mb-[50px]">{{ $planCount }}</p>
        </div>
        <p>Какая-нибудь статистика</p>
      </div>
      <img src="{{ asset('storage/admin/plans.png') }}" alt="users">
    </div>
    <div
      class="bg-white max-w-[370px] min-h-[200px] w-full p-[10px] px-[25px] rounded-xl flex flex-row items-start justify-between gap-[70px]">
      <div class="flex flex-col justify-between h-full">
        <div>
          <p class="text-[#202224] mb-[15px]">Любой блок</p>
          <p class="text-3xl font-bold mb-[50px]">150</p>
        </div>
        <p>Любая статистика</p>
      </div>
      <img src="{{ asset('storage/admin/plans.png') }}" alt="users">
    </div>
  </div>
  <h1 class="text-3xl font-bold">И, в принципе, любая другая информация.</h1>
@endsection