@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Редактирай новина</h1>
                <p class="mt-2 text-gray-600">Актуализирай информация за новината</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Image Upload Field (Drag & Drop) with Delete -->
                    @php
                        $newsMedia = $news->getFirstMedia('news_thumbs');
                    @endphp
                    @include('partials.single-image-dropzone', [
                        'label' => 'Основна снимка',
                        'name' => 'image',
                        'existingImage' => $newsMedia ? $newsMedia->getUrl() : null,
                        'deleteUrl' => $newsMedia
                            ? route('admin.news.delete-media', ['news' => $news->id, 'media' => $newsMedia->id])
                            : null,
                    ])

                    <!-- Display Key (read-only) -->
                    <div>
                        <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                            Ключ на статия
                        </label>
                        <div
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-medium">
                            {{ $news->translation_key }}
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Този ключ не може да бъде променен</p>
                    </div>

                    <!-- Title Fields Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Заглавие на статия</h3>

                        <!-- Title bg -->
                        <div>
                            <label for="title_bg" class="block text-sm font-medium text-gray-700 mb-2">
                                Заглавие (Български)
                            </label>
                            <input type="text" id="title_bg" name="title_bg" placeholder="Въведете наслов на български"
                                value="{{ old('title_bg', $news->getTranslation('title', 'bg')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_bg') border-red-500 @enderror"
                                required>
                            @error('title_bg')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title en -->
                        <div class="mb-4">
                            <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                                Заглавие (Английски)
                            </label>
                            <input type="text" id="title_en" name="title_en"
                                placeholder="Въведете наслов на новината на английски"
                                value="{{ old('title_en', $news->getTranslation('title', 'en')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_en') border-red-500 @enderror"
                                required>
                            @error('title_en')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="button" id="translate-title-btn"
                        class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                        Преведи
                    </button>

                    <!-- Content Fields Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Съдържание</h3>

                        <!-- Content bg -->
                        <div>
                            <label for="content_bg" class="block text-sm font-medium text-gray-700 mb-2">
                                Съдържание (Български)
                            </label>
                            <textarea id="content_bg" name="content_bg" placeholder="Въведете съдържание на български" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content_bg') border-red-500 @enderror"
                                required>{{ old('content_bg', $news->getTranslation('content', 'bg')) }}</textarea>
                            @error('content_bg')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content en -->
                        <div class="mb-4">
                            <label for="content_en" class="block text-sm font-medium text-gray-700 mb-2">
                                Съдържание (Английски)
                            </label>
                            <textarea id="content_en" name="content_en" placeholder="Въведете съдържание на новината на английски" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content_en') border-red-500 @enderror"
                                required>{{ old('content_en', $news->getTranslation('content', 'en')) }}</textarea>
                            @error('content_en')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="button" id="translate-content-btn"
                        class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                        Преведи
                    </button>

                    <!-- Action Buttons -->
                    <div class="border-t pt-6 flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Актуализирай новина
                        </button>
                        <a href="{{ route('admin.news.index') }}"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center">
                            Откажи
                        </a>
                    </div>
                </form>

                <!-- Delete Button (Separate Form) -->
                <form action="{{ route('admin.news.destroy', $news) }}" method="POST"
                    class="mt-6 pt-6 border-t border-gray-200 delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        class="delete-btn w-full inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium"
                        data-confirm-message="Сигурни ли сте, че искате да изтриете тази новина?">
                        Изтрий новина
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.delete-form-handler')

    {{-- Drag & drop image script is now initialized globally via resources/js/app.js --}}
@endsection

{{-- Translation Script --}}

@include('partials.translation-script', [
    'btnSelector' => '#translate-title-btn',
    'bgFieldSelector' => '#title_bg',
    'enFieldSelector' => '#title_en',
]);

@include('partials.translation-script', [
    'btnSelector' => '#translate-content-btn',
    'bgFieldSelector' => '#content_bg',
    'enFieldSelector' => '#content_en',
]);
