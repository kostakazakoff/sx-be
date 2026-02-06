<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
});

Route::middleware('auth')->post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect()->route('admin.categories.index');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->prefix('admin/profile')->name('auth.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('update');
    Route::post('/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('update-password');
});

// Admin маршрути - POST, UPDATE, DELETE заявки от Blade форми
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('destroy');
        Route::delete('/{category}/image', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteImage'])->name('deleteImage');
    });

    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\ServiceController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('store');
        Route::get('/{service}/edit', [\App\Http\Controllers\Admin\ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('destroy');
        Route::delete('/{service}/image', [\App\Http\Controllers\Admin\ServiceController::class, 'deleteImage'])->name('deleteImage');
    });

    Route::prefix('units')->name('units.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UnitsController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\UnitsController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\UnitsController::class, 'store'])->name('store');
        Route::get('/{unit}/edit', [\App\Http\Controllers\Admin\UnitsController::class, 'edit'])->name('edit');
        Route::put('/{unit}', [\App\Http\Controllers\Admin\UnitsController::class, 'update'])->name('update');
        Route::delete('/{unit}', [\App\Http\Controllers\Admin\UnitsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\ProjectController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('store');
        Route::get('/{project}/edit', [\App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('destroy');
        Route::delete('/{project}/media/{media}', [\App\Http\Controllers\Admin\ProjectController::class, 'deleteMedia'])->name('deleteMedia');
    });

    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\NewsController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\NewsController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\NewsController::class, 'store'])->name('store');
        Route::get('/{news}/edit', [\App\Http\Controllers\Admin\NewsController::class, 'edit'])->name('edit');
        Route::put('/{news}', [\App\Http\Controllers\Admin\NewsController::class, 'update'])->name('update');
        Route::delete('/{news}', [\App\Http\Controllers\Admin\NewsController::class, 'destroy'])->name('destroy');
        Route::delete('/{news}/media/{media}', [\App\Http\Controllers\Admin\NewsController::class, 'deleteMedia'])->name('delete-media');
    });

    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('index');
        Route::post('/broadcast', [\App\Http\Controllers\Admin\ClientController::class, 'messageBroadcast'])->name('broadcast');
        Route::get('/create', [\App\Http\Controllers\Admin\ClientController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\ClientController::class, 'store'])->name('store');
        Route::get('/{client}/edit', [\App\Http\Controllers\Admin\ClientController::class, 'edit'])->name('edit');
        Route::put('/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'update'])->name('update');
        Route::delete('/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('destroy');
        Route::delete('/{client}/image', [\App\Http\Controllers\Admin\ClientController::class, 'deleteImage'])->name('deleteImage');
    });

    Route::prefix('inquiries')->name('inquiries.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\InquiryController::class, 'index'])->name('index');
        Route::get('/{inquiry}', [\App\Http\Controllers\Admin\InquiryController::class, 'show'])->name('show');
        Route::delete('/{inquiry}', [\App\Http\Controllers\Admin\InquiryController::class, 'destroy'])->name('destroy');
    });
    Route::post('/translate', [\App\Http\Controllers\TranslationController::class, 'translate'])->name('translate');
});
