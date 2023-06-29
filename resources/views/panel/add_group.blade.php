@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

<div class="bg-blue-block p-10">
    <p class="text-xl text-white mb-5">Добавяне на група</p>
    <form method="POST" action="{{ route('admin.groups.create') }}">
      @csrf
      <div class="mb-6">
        <label for="name" class="block mb-2 text-sm font-medium text-white">Име група</label>
        <input type="text" name="name" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" required>
      </div>
      <div class="mb-6">
        <label for="version" class="block mb-2 text-sm font-medium text-white">Версия софтуер</label>
        <input type="text" name="version" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="true" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Добави</button>
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.clients') }}'">Отказ</button>
    </form>
</div>
@push('js')
<script src="{{ asset('js/keyboard-init.js') }}"></script>
<script>
    KioskBoard.run('.js-virtual-keyboard', {});
</script>
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection