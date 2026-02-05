@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Редактирай категория</h1>
                <p class="mt-2 text-gray-600">Актуализирай информацията за категорията</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Image Upload Field (Drag & Drop) -->
                    <div>
                        @include('partials.single-image-dropzone', [
                            'label' => 'Изображение към категория',
                            'existingImage' => $category->image_src,
                            'deleteUrl' => route('admin.categories.deleteImage', $category),
                        ])
                    </div>

                    <!-- Display Key (read-only) -->
                    <div>
                        <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                            Ключ на категория
                        </label>
                        <div
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-medium">
                            {{ $category->translation_key }}
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Този ключ не може да бъде променян</p>
                    </div>

                    <!-- Name Fields Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Имена на категория</h3>

                        <!-- Name bg -->
                        <div>
                            <label for="name_bg" class="block text-sm font-medium text-gray-700 mb-2">
                                Име (Български)
                            </label>
                            <input type="text" id="name_bg" name="name_bg"
                                placeholder="Въведете категория на български"
                                value="{{ old('name_bg', $category->getTranslation('name', 'bg')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_bg') border-red-500 @enderror"
                                required>
                            @error('name_bg')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Name en -->
                    <div class="mb-4">
                        <label for="name_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Име (Английски)
                        </label>
                        <input type="text" id="name_en" name="name_en"
                            placeholder="Въведете име на категория на английски"
                            value="{{ old('name_en', $category->getTranslation('name', 'en')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_en') border-red-500 @enderror"
                            required>
                        @error('name_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" id="translate-name-btn"
                        class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                        Преведи
                    </button>

                    <!-- Description Fields Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Описания</h3>

                        <!-- De bg -->
                        <div>
                            <label for="description_bg" class="block text-sm font-medium text-gray-700 mb-2">
                                Описание (Български)
                            </label>
                            <textarea id="description_bg" name="description_bg" placeholder="Въведете описание на български" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_bg') border-red-500 @enderror">{{ old('description_bg', $category->getTranslation('description', 'bg')) }}</textarea>
                            @error('description_bg')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description en -->
                    <div class="mb-4">
                        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Описание (Английски)
                        </label>
                        <textarea id="description_en" name="description_en" placeholder="Въведете описание на английски" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_en') border-red-500 @enderror">{{ old('description_en', $category->getTranslation('description', 'en')) }}</textarea>
                        @error('description_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" id="translate-desc-btn"
                        class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                        Преведи
                    </button>

                    <!-- Action Buttons -->
                    <div class="border-t pt-6 flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 cursor-pointer">
                            Обнови категория
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-200 text-center cursor-pointer">
                            Откажи
                        </a>
                    </div>
                </form>

                <!-- Delete Button (Separate Form) -->
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                    class="mt-6 pt-6 border-t border-gray-200 delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        class="delete-btn w-full inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium cursor-pointer"
                        data-confirm-message="Сигурни ли сте, че искате да изтриете тази категория?">
                        Изтрий категория
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('partials.delete-form-handler')

{{-- Translation Script --}}

@include('partials.translation-script', [
    'btnSelector' => '#translate-name-btn',
    'bgFieldSelector' => '#name_bg',
    'enFieldSelector' => '#name_en',
]);

@include('partials.translation-script', [
    'btnSelector' => '#translate-desc-btn',
    'bgFieldSelector' => '#description_bg',
    'enFieldSelector' => '#description_en',
]);
