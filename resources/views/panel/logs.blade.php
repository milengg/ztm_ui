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
                    Действие
                </th>
                <th scope="col" class="px-6 py-3">
                    Стойност
                </th>
                <th scope="col" class="px-6 py-3">
                    Дата на събитие
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr class="bg-blue-dark border-b border-blue-block">
                @if($log->action == 'Админ пин приет' || $log->action == 'Ресет пин приет')
                <th scope="row" class="px-6 py-4 font-medium text-green-500 whitespace-nowrap">
                    {{ $log->action }}
                </th>
                <td class="px-6 py-4">
                    {{ $log->action_value}}
                </td>
                @else
                <th scope="row" class="px-6 py-4 font-medium text-red-500 whitespace-nowrap">
                    {{ $log->action }}
                </th>
                <td class="px-6 py-4">
                    {{ $log->action_value}}
                </td>
                @endif
                <td class="px-6 py-4">
                    {{ $log->created_at }}
                </td>
            </tr>
            @empty
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    Няма намерени параметри в базата данни!
                </th>
                <td></td>
                <td></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $logs->links() }}
</div>
@push('js')
<script src="{{ asset('js/auth.js') }}"></script>
@endpush
@endsection