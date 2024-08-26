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

    Route::get('/register', function () {
        return view('pages.auth.register');
    })->name('auth.register.index');

    Route::post('/post-register', [App\Http\Controllers\UserController::class, 'store'])->name('auth.register');
});

// Admin
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');

    Route::get('/admin', function () {
        return view('pages.master.admin');
    })->name('admin.dashboard');

    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/form', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/form', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/form/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/form/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
});
