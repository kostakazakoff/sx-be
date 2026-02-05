@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-start justify-between sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Категории</h1>
                <p class="mt-2 text-gray-600">Управлявайте всички категории в системата</p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ДОБАВИ КАТЕГОРИЯ
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg xl:max-w-7xl mx-auto">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Categories Table -->
        <div class="overflow-x-auto bg-white rounded shadow mx-auto xl:max-w-7xl">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Изображение</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Име (en/bg)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories ?? [] as $category)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-3">
                                @if ($category->image_src)
                                    <img src="{{ $category->image_src }}" alt="{{ $category->translation_key }}"
                                        class="h-12 w-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">Няма</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3">
                                <div class="text-xs lg:text-sm">
                                    <div class="text-blue-600">en: {{ $category->getTranslation('name', 'en') ?? '—' }}</div>
                                    <div class="text-red-600">bg: {{ $category->getTranslation('name', 'bg') ?? '—' }}</div>
                                </div>
                            </td>
                                @include('partials.action-buttons', [
                                    'editRoute' => 'admin.categories.edit',
                                    'deleteRoute' => 'admin.categories.destroy',
                                    'model' => $category,
                                    'confirmMessage' => 'Сигурни ли сте, че искате да изтриете тази категория?'
                                ])
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="font-medium">Няма намерени категории</p>
                                        <p class="text-sm mt-1">Създайте първата категория чрез бутона ДОБАВИ КАТЕГОРИЯ по-горе</p>
                                    </div>
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
