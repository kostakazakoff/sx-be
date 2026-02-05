@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-start mb-6 sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <div>
                <h1 class="text-3xl font-bold">Услуги</h1>
                
                {{-- Filters --}}
                <div class="flex justify-start items-center gap-4 mt-8">
                    <div class="text-gray-700">
                        <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                    </div>

                    <form method="GET" action="{{ route('admin.services.index') }}" class="flex items-center gap-4">
                        {{-- Category Filter --}}
                        <select id="category" name="category"
                            class="px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            onchange="this.form.submit()">
                            <option value="">Всички категории</option>
                            @foreach ($categories ?? [] as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                    {{ $category->getTranslation('name', 'bg') }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- Reset Filters --}}
                    <a href="{{ route('admin.services.index') }}" class="p-2 text-gray-600 hover:text-gray-900 transition-colors" title="Изчисти филтрите">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <a href="{{ route('admin.services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + ДОБАВИ УСЛУГА
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded xl:max-w-7xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow mx-auto xl:max-w-7xl">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Изображение</th>
                        <th class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Категория</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Име (en/bg)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Цена</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-3">
                                @if ($service->image_src)
                                    <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                                        class="h-12 w-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">Няма</span>
                                @endif
                            </td>
                            <td class="hidden md:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">{{ $service->category->getTranslation('name', 'bg') ?? 'Няма' }}</td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3">
                                <div class="text-xs lg:text-sm">
                                    <div class="text-blue-600">en: {{ $service->getTranslation('name', 'en') }}</div>
                                    <div class="text-red-600">bg: {{ $service->getTranslation('name', 'bg') }}</div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                @if ($service->price_from || $service->price_to)
                                    <div>{{ $service->price_from ? '$' . number_format($service->price_from, 2) : '-' }} -
                                        {{ $service->price_to ? '$' . number_format($service->price_to, 2) : '-' }}</div>
                                    @if ($service->unit)
                                        <div class="text-gray-500 text-xs lg:text-sm">{{ $service->unit }}</div>
                                    @endif
                                @else
                                    <span class="text-gray-400">Няма</span>
                                @endif
                            </td>
                            @include('partials.action-buttons', [
                                'editRoute' => 'admin.services.edit',
                                'deleteRoute' => 'admin.services.destroy',
                                'model' => $service,
                                'confirmMessage' => 'Сигурни ли сте, че искате да изтриете тази услуга?'
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p class="font-medium">Няма намерени услуги</p>
                                    <p class="text-sm mt-1">Създайте първата услуга чрез бутона ДОБАВИ УСЛУГА по-горе</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('partials.delete-form-handler')
