<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'frontend.home')->name('home');
Route::view('/guilds/{slug}', 'frontend.guilds.show')->name('guilds.show');
Route::view('/posts', 'frontend.posts.index')->name('posts.index');
Route::view('/posts/{slug}', 'frontend.posts.show')->name('posts.show');
Route::view('/tourism', 'frontend.tourism.index')->name('tourism.index');
Route::view('/galleries', 'frontend.galleries.index')->name('galleries.index');
Route::view('/galleries/{slug}', 'frontend.galleries.show')->name('galleries.show');
Route::view('/videos/{slug}', 'frontend.videos.show')->name('videos.show');
Route::view('/pages/{slug}', 'frontend.pages.show')->name('pages.show');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    Route::get('users', [UserController::class, 'index'])->middleware('permission:users.view')->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->middleware('permission:users.create')->name('users.create');
    Route::post('users', [UserController::class, 'store'])->middleware('permission:users.create')->name('users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->middleware('permission:users.view')->name('users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->middleware('permission:users.edit')->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->middleware('permission:users.edit')->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('permission:users.delete')->name('users.destroy');

    Route::get('roles', [RoleController::class, 'index'])->middleware('permission:roles.view')->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->middleware('permission:roles.create')->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->middleware('permission:roles.create')->name('roles.store');
    Route::get('roles/{role}', [RoleController::class, 'show'])->middleware('permission:roles.view')->name('roles.show');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:roles.edit')->name('roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])->middleware('permission:roles.edit')->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:roles.delete')->name('roles.destroy');

    Route::get('permissions', [PermissionController::class, 'index'])->middleware('permission:permissions.view')->name('permissions.index');
    Route::get('permissions/create', [PermissionController::class, 'create'])->middleware('permission:permissions.create')->name('permissions.create');
    Route::post('permissions', [PermissionController::class, 'store'])->middleware('permission:permissions.create')->name('permissions.store');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->middleware('permission:permissions.edit')->name('permissions.edit');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->middleware('permission:permissions.edit')->name('permissions.update');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('permission:permissions.delete')->name('permissions.destroy');
});
