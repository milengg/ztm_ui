@extends('layouts.app')

@section('content')
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<livewire:info />

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Параметър
                </th>
                <th scope="col" class="px-6 py-3">
                    Стойност
                </th>
                <th scope="col" class="px-6 py-3">
                    Синхронизация bgERP
                </th>
                <th scope="col" class="px-6 py-3">
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($settings as $setting)
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    {{ $setting->parameter_name }}
                </th>
                @if($setting->parameter_name == 'envm.window_tamper.activations' || $setting->parameter_name == 'envm.door_tamper.activations' || $setting->parameter_name == 'envm.pir.activations')
                @switch($setting->parameter_name)
                    @case('envm.window_tamper.activations')
                        <td class="px-6 py-4">
                            {{ $window_tamper_state ? 'Отворено':'Затворено' }}
                        </td>
                        @break
                    @case('envm.door_tamper.activations')
                        <td class="px-6 py-4">
                            {{ $door_tamper_state ? 'Отворено':'Затворено' }}
                        </td>
                        @break
                    @case('envm.pir.activations')
                        <td class="px-6 py-4">
                            липсва
                        </td>
                        @break
                @endswitch
                @else
                <td class="px-6 py-4">
                    {{ $setting->parameter_value}}
                </td>
                @endif
                <td class="px-6 py-4">
                    {{ $setting->bgerp_sync ? 'Да':'Не' }}
                </td>
                @if($setting->parameter_name != 'serial_number' && $setting->parameter_name != 'updater_version' && $setting->parameter_name != 'envm.window_tamper.activations' && $setting->parameter_name != 'envm.door_tamper.activations' && $setting->parameter_name != 'envm.pir.activations')
                <td class="px-6 py-4">
                    <a href="{{ route('admin.edit.parameter', $setting->id) }}" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        Редакция
                    </a>
                </td>
                @else
                <td class="px-6 py-4"></td>
                @endif
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    Няма намерени параметри в базата данни!
                </th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $settings->links() }}
</div>
@push('js')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection