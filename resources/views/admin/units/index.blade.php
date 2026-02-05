@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-center justify-between sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Мерни единици</h1>
                <p class="mt-2 text-gray-600">Управлявайте всички мерни единици в системата</p>
            </div>
            <a href="{{ route('admin.units.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ДОБАВИ МЕРНА ЕДИНИЦА
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg max-w-7xl mx-auto">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->has('delete'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg max-w-7xl mx-auto">
                {{ $errors->first('delete') }}
            </div>
        @endif

        <!-- Units Table -->
        <div class="overflow-x-auto bg-white rounded shadow mx-auto xl:max-w-7xl">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Наименование (en/bg)</th>
                        <th class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Услуги</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($units ?? [] as $unit)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-2 sm:py-3">
                                <div class="text-xs lg:text-sm">
                                    <div class="text-blue-600">en: {{ $unit->getTranslation('name', 'en') }}</div>
                                    <div class="text-red-600">bg: {{ $unit->getTranslation('name', 'bg') }}</div>
                                </div>
                            </td>
                            <td class="hidden lg:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                @php
                                    $serviceNames = $unit->services->map(fn($s) => $s->getTranslation('name', 'bg'))->filter()->values();
                                @endphp
                                {{ $serviceNames->isNotEmpty() ? $serviceNames->implode(', ') : 'N/A' }}
                            </td>
                            @include('partials.action-buttons', [
                                'editRoute' => 'admin.units.edit',
                                'deleteRoute' => 'admin.units.destroy',
                                'model' => $unit,
                                'confirmMessage' => 'Сигурни ли сте, че искате да изтриете тази мерна единица?',
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                Няма намерени мерни единици. <a href="{{ route('admin.units.create') }}"
                                    class="text-blue-600 hover:underline">Създай една сега</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
@include('partials.delete-form-handler')