@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

@if(checkMode() == 'server')
<div class="bg-blue-block p-10">
    <p class="text-xl text-white mb-5">Добавяне на таблет</p>
    <form method="POST" action="{{ route('admin.clients.create.tablet') }}">
      @csrf
      <div class="mb-6">
        <label for="tablet_name" class="block mb-2 text-sm font-medium text-white">Име таблет</label>
        <input type="text" name="tablet_name" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" required>
      </div>
      <div class="mb-6">
        <label for="group_id" class="block mb-2 text-sm font-medium text-white">Група</label>
        <select name="group_id" class="bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @foreach($groups as $group)
              <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
      </div>
      <div class="mb-6">
        <label for="floor" class="block mb-2 text-sm font-medium text-white">Етаж</label>
        <input type="text" name="floor" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" required>
      </div>
      <div class="mb-6">
        <label for="room" class="block mb-2 text-sm font-medium text-white">Стая</label>
        <input type="text" name="room" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" required>
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Добави</button>
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.clients') }}'">Отказ</button>
    </form>
</div>
@elseif(checkMode() == 'client')
<div class="bg-blue-block p-10">
    <p class="text-xl text-white mb-5">Добавяне на настройки за сървър</p>
    <form method="POST" action="{{ route('admin.clients.create.server') }}">
      @csrf
      <div class="mb-6">
        <label for="server_name" class="block mb-2 text-sm font-medium text-white">Име сървър</label>
        <input type="text" name="server_name" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" required>
      </div>
      <div class="mb-6">
        <label for="server_ip" class="block mb-2 text-sm font-medium text-white dark:text-white">Мрежов адрес на сървър</label>
        <input type="text" name="server_ip" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" required>
      </div>
      <div class="mb-6">
        <label for="public_key" class="block mb-2 text-sm font-medium text-white dark:text-white">Криптиращ ключ</label>
        <textarea name="public_key" rows="4" class="bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" placeholder="Публичен ключ..."></textarea>
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Добави</button>
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="window.location.href='{{ route('admin.clients') }}'">Отказ</button>
    </form>
</div>
@endif
@push('js')
<script src="{{ asset('js/keyboard-init.js') }}"></script>
<script>
    KioskBoard.run('.js-virtual-keyboard', {});
</script>
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection