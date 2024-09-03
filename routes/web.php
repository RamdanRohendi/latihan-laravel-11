<?php

use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('pages.index');
});

Route::get('/team', function () {
    return view('pages.team');
});

// Auth
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('auth.authenticate');

    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('auth.register.index');
    Route::post('/post-register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('auth.register');
});

// Admin
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');

    Route::get('/admin', [App\Http\Controllers\Auth\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::middleware('can:admin')->group(function () {
        Route::get('/admin/users/data', [App\Http\Controllers\UserController::class, 'getData'])->name('admin.users.data');

        Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/form', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users/form', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/form/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/form/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
