<?php

use App\Http\Controllers\Admin\AdminDashboardController;
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
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
});
