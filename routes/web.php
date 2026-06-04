<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'frontend.home')->name('frontend.home');
Route::view('/guilds/{slug}', 'frontend.guilds.show')->name('frontend.guilds.show');
Route::view('/posts', 'frontend.posts.index')->name('frontend.posts.index');
Route::view('/posts/{slug}', 'frontend.posts.show')->name('frontend.posts.show');
Route::view('/tourism', 'frontend.tourism.index')->name('frontend.tourism.index');
Route::view('/galleries', 'frontend.galleries.index')->name('frontend.galleries.index');
Route::view('/galleries/{slug}', 'frontend.galleries.show')->name('frontend.galleries.show');
Route::view('/videos/{slug}', 'frontend.videos.show')->name('frontend.videos.show');
Route::view('/pages/{slug}', 'frontend.pages.show')->name('frontend.pages.show');
