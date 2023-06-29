@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

<div class="bg-blue-block p-4">
     <div class="flex justify-between">
        <p class="text-white font-bold text-xl">Детайли за група: {{ $group->name }}</p>
        <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.groups.update', $group->id) }}'">МАСОВ ЪПДЕЙТ</button>
    </div>
</div>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Таблет име
                </th>
                <th scope="col" class="px-6 py-3">
                    Ъпдейти
                </th>
                <th scope="col" class="px-6 py-3">
                    Етаж
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($tablets as $tablet)
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    {{ $tablet->tablet_name }}
                </th>
                <td class="px-6 py-4">
                    {{ $tablet->distribute_settings ? 'Пуснати':'Спрени' }}
                </td>
                <td class="px-6 py-4">
                    {{ $tablet->floor }}
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <td scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    Няма намерени данни
                </th>
                <td></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $tablets->links() }}
</div>
@endsection