<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\AnnouncementController as FrontendAnnouncementController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Admin\PermissionController;
use App\Models\Announcement;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $importantPosts = Post::query()->published()->important()->with('category')->latest('published_at')->take(6)->get();
    $importantAnnouncements = Announcement::query()->published()->important()->shownOnHome()->latest('published_at')->take(5)->get();

    return view('frontend.home', compact('importantPosts', 'importantAnnouncements'));
})->name('home');
Route::view('/guilds/{slug}', 'frontend.guilds.show')->name('guilds.show');
Route::get('/posts', [FrontendPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [FrontendPostController::class, 'show'])->name('posts.show');
Route::get('/announcements', [FrontendAnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{slug}', [FrontendAnnouncementController::class, 'show'])->name('announcements.show');
Route::view('/tourism', 'frontend.tourism.index')->name('tourism.index');
Route::view('/galleries', 'frontend.galleries.index')->name('galleries.index');
Route::view('/galleries/{slug}', 'frontend.galleries.show')->name('galleries.show');
Route::view('/videos/{slug}', 'frontend.videos.show')->name('videos.show');
Route::get('/pages/{slug}', [FrontendPageController::class, 'show'])->name('pages.show');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    Route::get('pages', [AdminPageController::class, 'index'])->middleware('permission:pages.view')->name('pages.index');
    Route::get('pages/create', [AdminPageController::class, 'create'])->middleware('permission:pages.create')->name('pages.create');
    Route::post('pages', [AdminPageController::class, 'store'])->middleware('permission:pages.create')->name('pages.store');
    Route::get('pages/{page}', [AdminPageController::class, 'show'])->middleware('permission:pages.view')->name('pages.show');
    Route::get('pages/{page}/edit', [AdminPageController::class, 'edit'])->middleware('permission:pages.edit')->name('pages.edit');
    Route::put('pages/{page}', [AdminPageController::class, 'update'])->middleware('permission:pages.edit')->name('pages.update');
    Route::delete('pages/{page}', [AdminPageController::class, 'destroy'])->middleware('permission:pages.delete')->name('pages.destroy');
    Route::patch('pages/{page}/approve', [AdminPageController::class, 'approve'])->middleware('permission:pages.approve')->name('pages.approve');
    Route::patch('pages/{page}/publish', [AdminPageController::class, 'publish'])->middleware('permission:pages.approve')->name('pages.publish');
    Route::patch('pages/{page}/reject', [AdminPageController::class, 'reject'])->middleware('permission:pages.approve')->name('pages.reject');

    Route::get('posts', [AdminPostController::class, 'index'])->middleware('permission:posts.view')->name('posts.index');
    Route::get('posts/create', [AdminPostController::class, 'create'])->middleware('permission:posts.create')->name('posts.create');
    Route::post('posts', [AdminPostController::class, 'store'])->middleware('permission:posts.create')->name('posts.store');
    Route::get('posts/{post}', [AdminPostController::class, 'show'])->middleware('permission:posts.view')->name('posts.show');
    Route::get('posts/{post}/edit', [AdminPostController::class, 'edit'])->middleware('permission:posts.edit')->name('posts.edit');
    Route::put('posts/{post}', [AdminPostController::class, 'update'])->middleware('permission:posts.edit')->name('posts.update');
    Route::delete('posts/{post}', [AdminPostController::class, 'destroy'])->middleware('permission:posts.delete')->name('posts.destroy');
    Route::patch('posts/{post}/approve', [AdminPostController::class, 'approve'])->middleware('permission:posts.approve')->name('posts.approve');
    Route::patch('posts/{post}/publish', [AdminPostController::class, 'publish'])->middleware('permission:posts.publish')->name('posts.publish');
    Route::patch('posts/{post}/reject', [AdminPostController::class, 'reject'])->middleware('permission:posts.approve')->name('posts.reject');

    Route::get('announcements', [AdminAnnouncementController::class, 'index'])->middleware('permission:announcements.view')->name('announcements.index');
    Route::get('announcements/create', [AdminAnnouncementController::class, 'create'])->middleware('permission:announcements.create')->name('announcements.create');
    Route::post('announcements', [AdminAnnouncementController::class, 'store'])->middleware('permission:announcements.create')->name('announcements.store');
    Route::get('announcements/{announcement}', [AdminAnnouncementController::class, 'show'])->middleware('permission:announcements.view')->name('announcements.show');
    Route::get('announcements/{announcement}/edit', [AdminAnnouncementController::class, 'edit'])->middleware('permission:announcements.edit')->name('announcements.edit');
    Route::put('announcements/{announcement}', [AdminAnnouncementController::class, 'update'])->middleware('permission:announcements.edit')->name('announcements.update');
    Route::delete('announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->middleware('permission:announcements.delete')->name('announcements.destroy');
    Route::patch('announcements/{announcement}/approve', [AdminAnnouncementController::class, 'approve'])->middleware('permission:announcements.approve')->name('announcements.approve');
    Route::patch('announcements/{announcement}/publish', [AdminAnnouncementController::class, 'publish'])->middleware('permission:announcements.publish')->name('announcements.publish');
    Route::patch('announcements/{announcement}/reject', [AdminAnnouncementController::class, 'reject'])->middleware('permission:announcements.approve')->name('announcements.reject');

    Route::get('menus', [MenuController::class, 'index'])->middleware('permission:menus.view')->name('menus.index');
    Route::get('menus/create', [MenuController::class, 'create'])->middleware('permission:menus.create')->name('menus.create');
    Route::post('menus', [MenuController::class, 'store'])->middleware('permission:menus.create')->name('menus.store');
    Route::get('menus/{menu}', [MenuController::class, 'show'])->middleware('permission:menus.view')->name('menus.show');
    Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])->middleware('permission:menus.edit')->name('menus.edit');
    Route::put('menus/{menu}', [MenuController::class, 'update'])->middleware('permission:menus.edit')->name('menus.update');
    Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->middleware('permission:menus.delete')->name('menus.destroy');

    Route::get('menus/{menu}/items/create', [MenuItemController::class, 'create'])->middleware('permission:menus.create')->name('menus.items.create');
    Route::post('menus/{menu}/items', [MenuItemController::class, 'store'])->middleware('permission:menus.create')->name('menus.items.store');
    Route::get('menus/{menu}/items/{item}/edit', [MenuItemController::class, 'edit'])->middleware('permission:menus.edit')->name('menus.items.edit');
    Route::put('menus/{menu}/items/{item}', [MenuItemController::class, 'update'])->middleware('permission:menus.edit')->name('menus.items.update');
    Route::patch('menus/{menu}/items/{item}/toggle', [MenuItemController::class, 'toggle'])->middleware('permission:menus.edit')->name('menus.items.toggle');
    Route::delete('menus/{menu}/items/{item}', [MenuItemController::class, 'destroy'])->middleware('permission:menus.delete')->name('menus.items.destroy');
    Route::post('menus/{menu}/items/sort', [MenuItemController::class, 'sort'])->middleware('permission:menus.edit')->name('menus.items.sort');

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
