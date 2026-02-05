@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Редактирай проект</h1>
                <p class="mt-2 text-gray-600">Актуализирай информация на проекта и галерията
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Existing Images Gallery -->
                    @include('partials.existing-images-gallery', [
                        'model' => $project,
                        'media' => $project->getMedia('project_images'),
                        'deleteRoute' => '/admin/projects',
                        'label' => 'Текущи снимки',
                        'helpText' => 'Провлачвай снимките за смяна на реда. Първата става основна (миниатюра).',
                        'deleteConfirm' => 'Сигурни ли сте, че искате да изтриете тази снимка?',
                    ])

                    <!-- Add New Images -->
                    @include('partials.images-dropzone', ['label' => 'Добави нови снимки'])

                    <!-- Display Key (read-only) -->
                    <div>
                        <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                            Ключ на проект
                        </label>
                        <div
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-medium">
                            {{ $project->translation_key }}
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Този ключ не може да бъде променен</p>
                    </div>

                    <!-- Title Fields Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Заглавие на проекта</h3>

                        <!-- Title bg -->
                        <div>
                            <label for="title_bg" class="block text-sm font-medium text-gray-700 mb-2">
                                Заглавие (Български)
                            </label>
                            <input type="text" id="title_bg" name="title_bg" placeholder="Въведете наслов на български"
                                value="{{ old('title_bg', $project->getTranslation('title', 'bg')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_bg') border-red-500 @enderror"
                                required>
                            @error('title_bg')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Title en -->
                    <div class="mb-4">
                        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                            Заглавие (Английски)
                        </label>
                        <input type="text" id="title_en" name="title_en"
                            placeholder="Въведете наслов на проекта на английски"
                            value="{{ old('title_en', $project->getTranslation('title', 'en')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_en') border-red-500 @enderror"
                            required>
                        @error('title_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" id="translate-title-btn"
                        class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                        Преведи
                    </button>

                    <!-- Description Fields Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Описания</h3>

                        <!-- Description bg -->
                        <div>
                            <label for="description_bg" class="block text-sm font-medium text-gray-700 mb-2">
                                Описание (Български)
                            </label>
                            <textarea id="description_bg" name="description_bg" placeholder="Въведете описание на български" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_bg') border-red-500 @enderror">{{ old('description_bg', $project->getTranslation('description', 'bg')) }}</textarea>
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
                        <textarea id="description_en" name="description_en" placeholder="Въведете описание на проекта на английски"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_en') border-red-500 @enderror">{{ old('description_en', $project->getTranslation('description', 'en')) }}</textarea>
                        @error('description_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" id="translate-desc-btn"
                        class="h-10 px-3 bg-blue-200 hover:bg-blue-300 text-gray-800 font-medium rounded-lg transition duration-200 w-full cursor-pointer">
                        Преведи
                    </button>

                    <!-- Additional Fields -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Допълнителна информация</h3>

                        <!-- Price -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Стойност на проекта
                            </label>
                            <input type="number" id="price" name="price" step="0.01" min="0"
                                placeholder="0.00" value="{{ old('price', $project->price) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Дата на проекта
                            </label>
                            <input type="date" id="date" name="date"
                                value="{{ old('date', $project->date ? \Carbon\Carbon::parse($project->date)->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date') border-red-500 @enderror">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-4 pt-6 border-t">
                        <a href="{{ route('admin.projects.index') }}"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium flex-1 text-center">
                            Откажи
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex-1 text-center">
                            Актуализирай проект
                        </button>
                    </div>
                </form>

                <!-- Delete Button (Separate Form) -->
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                    class="mt-6 pt-6 border-t border-gray-200 delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        class="delete-btn w-full inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 border border-red-300 rounded hover:bg-red-100 transition text-sm font-medium"
                        data-confirm-message="Сигурни ли сте, че искате да изтриете този проект?">
                        Изтрий проект
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('partials.delete-form-handler')

{{-- Translation Script --}}

@include('partials.translation-script', [
    'btnSelector' => '#translate-title-btn',
    'bgFieldSelector' => '#title_bg',
    'enFieldSelector' => '#title_en',
]);

@include('partials.translation-script', [
    'btnSelector' => '#translate-desc-btn',
    'bgFieldSelector' => '#description_bg',
    'enFieldSelector' => '#description_en',
]);
