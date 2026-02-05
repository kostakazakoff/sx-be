@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="mb-8 flex items-start justify-between sticky top-16 z-40 bg-gray-50 py-4 mx-auto xl:max-w-7xl">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Проекти</h1>
                <p class="mt-2 text-gray-600">Управлявайте всички проекти в системата</p>
            </div>
            <a href="{{ route('admin.projects.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                + ДОБАВИ ПРОЕКТ
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg xl:max-w-7xl mx-auto">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Projects Table -->
        <div class="overflow-x-auto bg-white rounded shadow mx-auto xl:max-w-7xl">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Снимка</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Заглавие (en/bg)</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Цена</th>
                        <th class="hidden sm:table-cell px-4 sm:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm">Дата</th>
                        <th class="px-4 sm:px-6 py-2 sm:py-3 text-right text-xs lg:text-sm">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects ?? [] as $project)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-3">
                                @if ($project->image_src)
                                    <img src="{{ $project->image_src }}" alt="{{ $project->translation_key }}"
                                        class="h-12 w-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3">
                                <div class="text-xs lg:text-sm">
                                    <div class="text-blue-600">en: {{ $project->getTranslation('title', 'en') ?? '—' }}</div>
                                    <div class="text-red-600">bg: {{ $project->getTranslation('title', 'bg') ?? '—' }}</div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                {{ $project->price ? number_format($project->price, 2) . ' лв.' : '—' }}
                            </td>
                            <td class="hidden sm:table-cell px-4 sm:px-6 py-2 sm:py-3 text-xs lg:text-sm">
                                {{ $project->date ? \Carbon\Carbon::parse($project->date)->format('d.m.Y') : '—' }}
                            </td>
                            @include('partials.action-buttons', [
                                'editRoute' => 'admin.projects.edit',
                                'deleteRoute' => 'admin.projects.destroy',
                                'model' => $project,
                                'confirmMessage' => 'Сигурни ли сте, че искате да изтриете този проект?'
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Няма намерени проекти. <a href="{{ route('admin.projects.create') }}"
                                    class="text-blue-600 hover:underline">Създай първия проект</a>
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
