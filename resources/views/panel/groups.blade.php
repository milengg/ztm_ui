@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

<div class="bg-blue-block p-4">
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.groups.add') }}'">ДОБАВИ ГРУПА</button>
    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" onclick="window.location.href='{{ route('admin.clients') }}'">НАЗАД</button>
</div>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Име
                </th>
                <th scope="col" class="px-6 py-3">
                    Версия на софтуера
                </th>
                <th scope="col" class="px-6 py-3">
                    Клиенти
                </th>
                <th scope="col" class="px-6 py-3">
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($groups as $group)
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    {{ $group->name }}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    {{ $group->version ?? 'Липсва' }}
                </th>
                <td class="px-6 py-4">
                    {{ $group->tablets->count() }}
                </td>
                <td class="px-6 py-4 flex">
                    <a href="{{ route('admin.groups.edit', $group->id) }}" class="text-purple-700 mr-2 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.groups.view', $group->id) }}" class="text-purple-700 mr-2 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.groups.delete', $group->id) }}" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <td scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    Няма намерени данни
                </th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $groups->links() }}
</div>
@endsection