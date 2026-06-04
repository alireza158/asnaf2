<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdvertisementController as AdminAdvertisementController;
use App\Http\Controllers\Admin\AdvertisementPositionController as AdminAdvertisementPositionController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\SystemController as AdminSystemController;
use App\Http\Controllers\Admin\TourismPlaceController as AdminTourismPlaceController;
use App\Http\Controllers\Admin\UnionController as AdminUnionController;
use App\Http\Controllers\Admin\UnionMemberController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\AnnouncementController as FrontendAnnouncementController;
use App\Http\Controllers\Frontend\ComplaintController as FrontendComplaintController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\SystemController as FrontendSystemController;
use App\Http\Controllers\Frontend\TourismController as FrontendTourismController;
use App\Http\Controllers\Frontend\UnionController as FrontendUnionController;
use App\Http\Controllers\Frontend\VideoController as FrontendVideoController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendHomeController::class, 'index'])->name('home');
Route::get('/guilds', [FrontendUnionController::class, 'index'])->name('guilds.index');
Route::get('/guilds/{slug}', [FrontendUnionController::class, 'show'])->name('guilds.show');
Route::get('/posts', [FrontendPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [FrontendPostController::class, 'show'])->name('posts.show');
Route::get('/announcements', [FrontendAnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{slug}', [FrontendAnnouncementController::class, 'show'])->name('announcements.show');
Route::get('/tourism', [FrontendTourismController::class, 'index'])->name('tourism.index');
Route::get('/tourism/{slug}', [FrontendTourismController::class, 'show'])->name('tourism.show');
Route::get('/galleries', [FrontendGalleryController::class, 'index'])->name('galleries.index');
Route::get('/galleries/{slug}', [FrontendGalleryController::class, 'show'])->name('galleries.show');
Route::get('/videos', [FrontendVideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{slug}', [FrontendVideoController::class, 'show'])->name('videos.show');
Route::get('/systems', [FrontendSystemController::class, 'index'])->name('systems.index');
Route::get('/systems/{slug}', [FrontendSystemController::class, 'show'])->name('systems.show');
Route::get('/pages/{slug}', [FrontendPageController::class, 'show'])->name('pages.show');
Route::get('/complaints/create', [FrontendComplaintController::class, 'create'])->name('complaints.create');
Route::post('/complaints', [FrontendComplaintController::class, 'store'])->name('complaints.store');
Route::get('/complaints/track', [FrontendComplaintController::class, 'track'])->name('complaints.track');
Route::post('/complaints/track', [FrontendComplaintController::class, 'lookup'])->name('complaints.lookup');

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

    Route::get('unions', [AdminUnionController::class, 'index'])->middleware('permission:unions.view')->name('unions.index');
    Route::get('unions/create', [AdminUnionController::class, 'create'])->middleware('permission:unions.create')->name('unions.create');
    Route::post('unions', [AdminUnionController::class, 'store'])->middleware('permission:unions.create')->name('unions.store');
    Route::get('unions/{union}', [AdminUnionController::class, 'show'])->middleware('permission:unions.view')->name('unions.show');
    Route::get('unions/{union}/edit', [AdminUnionController::class, 'edit'])->middleware('permission:unions.edit')->name('unions.edit');
    Route::put('unions/{union}', [AdminUnionController::class, 'update'])->middleware('permission:unions.edit')->name('unions.update');
    Route::delete('unions/{union}', [AdminUnionController::class, 'destroy'])->middleware('permission:unions.delete')->name('unions.destroy');

    Route::get('complaints', [AdminComplaintController::class, 'index'])->middleware('permission:complaints.view')->name('complaints.index');
    Route::get('complaints/{complaint}', [AdminComplaintController::class, 'show'])->middleware('permission:complaints.view')->name('complaints.show');
    Route::get('complaints/{complaint}/edit', [AdminComplaintController::class, 'edit'])->middleware('permission:complaints.edit')->name('complaints.edit');
    Route::put('complaints/{complaint}', [AdminComplaintController::class, 'update'])->middleware('permission:complaints.edit')->name('complaints.update');
    Route::patch('complaints/{complaint}/reply', [AdminComplaintController::class, 'reply'])->middleware('permission:complaints.reply')->name('complaints.reply');
    Route::get('complaints/{complaint}/download', [AdminComplaintController::class, 'download'])->middleware('permission:complaints.view')->name('complaints.download');
    Route::delete('complaints/{complaint}', [AdminComplaintController::class, 'destroy'])->middleware('permission:complaints.delete')->name('complaints.destroy');

    Route::get('sms', [SmsController::class, 'index'])->middleware('permission:sms.view')->name('sms.index');
    Route::get('sms/create', [SmsController::class, 'create'])->middleware('permission:sms.send')->name('sms.create');
    Route::post('sms', [SmsController::class, 'store'])->middleware('permission:sms.send')->name('sms.store');
    Route::get('sms/logs', [SmsController::class, 'logs'])->middleware('permission:sms.logs')->name('sms.logs');
    Route::get('sms/logs/{smsLog}', [SmsController::class, 'show'])->middleware('permission:sms.logs')->name('sms.show');

    Route::get('advertisement-positions', [AdminAdvertisementPositionController::class, 'index'])->middleware('permission:advertisements.view')->name('advertisement_positions.index');
    Route::get('advertisement-positions/create', [AdminAdvertisementPositionController::class, 'create'])->middleware('permission:advertisements.create')->name('advertisement_positions.create');
    Route::post('advertisement-positions', [AdminAdvertisementPositionController::class, 'store'])->middleware('permission:advertisements.create')->name('advertisement_positions.store');
    Route::get('advertisement-positions/{advertisement_position}/edit', [AdminAdvertisementPositionController::class, 'edit'])->middleware('permission:advertisements.edit')->name('advertisement_positions.edit');
    Route::put('advertisement-positions/{advertisement_position}', [AdminAdvertisementPositionController::class, 'update'])->middleware('permission:advertisements.edit')->name('advertisement_positions.update');
    Route::delete('advertisement-positions/{advertisement_position}', [AdminAdvertisementPositionController::class, 'destroy'])->middleware('permission:advertisements.delete')->name('advertisement_positions.destroy');

    Route::get('advertisements', [AdminAdvertisementController::class, 'index'])->middleware('permission:advertisements.view')->name('advertisements.index');
    Route::get('advertisements/create', [AdminAdvertisementController::class, 'create'])->middleware('permission:advertisements.create')->name('advertisements.create');
    Route::post('advertisements', [AdminAdvertisementController::class, 'store'])->middleware('permission:advertisements.create')->name('advertisements.store');
    Route::get('advertisements/{advertisement}', [AdminAdvertisementController::class, 'show'])->middleware('permission:advertisements.view')->name('advertisements.show');
    Route::get('advertisements/{advertisement}/edit', [AdminAdvertisementController::class, 'edit'])->middleware('permission:advertisements.edit')->name('advertisements.edit');
    Route::put('advertisements/{advertisement}', [AdminAdvertisementController::class, 'update'])->middleware('permission:advertisements.edit')->name('advertisements.update');
    Route::delete('advertisements/{advertisement}', [AdminAdvertisementController::class, 'destroy'])->middleware('permission:advertisements.delete')->name('advertisements.destroy');

    Route::get('systems', [AdminSystemController::class, 'index'])->middleware('permission:systems.view')->name('systems.index');
    Route::get('systems/create', [AdminSystemController::class, 'create'])->middleware('permission:systems.create')->name('systems.create');
    Route::post('systems', [AdminSystemController::class, 'store'])->middleware('permission:systems.create')->name('systems.store');
    Route::get('systems/{system}', [AdminSystemController::class, 'show'])->middleware('permission:systems.view')->name('systems.show');
    Route::get('systems/{system}/edit', [AdminSystemController::class, 'edit'])->middleware('permission:systems.edit')->name('systems.edit');
    Route::put('systems/{system}', [AdminSystemController::class, 'update'])->middleware('permission:systems.edit')->name('systems.update');
    Route::delete('systems/{system}', [AdminSystemController::class, 'destroy'])->middleware('permission:systems.delete')->name('systems.destroy');

    Route::get('home-sections', [HomeSectionController::class, 'index'])->middleware('permission:home_sections.view')->name('home_sections.index');
    Route::get('home-sections/{homeSection}/edit', [HomeSectionController::class, 'edit'])->middleware('permission:home_sections.edit')->name('home_sections.edit');
    Route::put('home-sections/{homeSection}', [HomeSectionController::class, 'update'])->middleware('permission:home_sections.edit')->name('home_sections.update');
    Route::post('home-sections/sort', [HomeSectionController::class, 'sort'])->middleware('permission:home_sections.edit')->name('home_sections.sort');

    Route::get('galleries', [AdminGalleryController::class, 'index'])->middleware('permission:galleries.view')->name('galleries.index');
    Route::get('galleries/create', [AdminGalleryController::class, 'create'])->middleware('permission:galleries.create')->name('galleries.create');
    Route::post('galleries', [AdminGalleryController::class, 'store'])->middleware('permission:galleries.create')->name('galleries.store');
    Route::get('galleries/{gallery}', [AdminGalleryController::class, 'show'])->middleware('permission:galleries.view')->name('galleries.show');
    Route::get('galleries/{gallery}/edit', [AdminGalleryController::class, 'edit'])->middleware('permission:galleries.edit')->name('galleries.edit');
    Route::put('galleries/{gallery}', [AdminGalleryController::class, 'update'])->middleware('permission:galleries.edit')->name('galleries.update');
    Route::delete('galleries/{gallery}', [AdminGalleryController::class, 'destroy'])->middleware('permission:galleries.delete')->name('galleries.destroy');

    Route::get('videos', [AdminVideoController::class, 'index'])->middleware('permission:videos.view')->name('videos.index');
    Route::get('videos/create', [AdminVideoController::class, 'create'])->middleware('permission:videos.create')->name('videos.create');
    Route::post('videos', [AdminVideoController::class, 'store'])->middleware('permission:videos.create')->name('videos.store');
    Route::get('videos/{video}', [AdminVideoController::class, 'show'])->middleware('permission:videos.view')->name('videos.show');
    Route::get('videos/{video}/edit', [AdminVideoController::class, 'edit'])->middleware('permission:videos.edit')->name('videos.edit');
    Route::put('videos/{video}', [AdminVideoController::class, 'update'])->middleware('permission:videos.edit')->name('videos.update');
    Route::delete('videos/{video}', [AdminVideoController::class, 'destroy'])->middleware('permission:videos.delete')->name('videos.destroy');

    Route::get('tourism', [AdminTourismPlaceController::class, 'index'])->middleware('permission:tourism.view')->name('tourism.index');
    Route::get('tourism/create', [AdminTourismPlaceController::class, 'create'])->middleware('permission:tourism.create')->name('tourism.create');
    Route::post('tourism', [AdminTourismPlaceController::class, 'store'])->middleware('permission:tourism.create')->name('tourism.store');
    Route::get('tourism/{tourism}', [AdminTourismPlaceController::class, 'show'])->middleware('permission:tourism.view')->name('tourism.show');
    Route::get('tourism/{tourism}/edit', [AdminTourismPlaceController::class, 'edit'])->middleware('permission:tourism.edit')->name('tourism.edit');
    Route::put('tourism/{tourism}', [AdminTourismPlaceController::class, 'update'])->middleware('permission:tourism.edit')->name('tourism.update');
    Route::delete('tourism/{tourism}', [AdminTourismPlaceController::class, 'destroy'])->middleware('permission:tourism.delete')->name('tourism.destroy');

    Route::get('union-members', [UnionMemberController::class, 'index'])->middleware('permission:union_members.view')->name('union_members.index');
    Route::get('union-members/create', [UnionMemberController::class, 'create'])->middleware('permission:union_members.create')->name('union_members.create');
    Route::post('union-members', [UnionMemberController::class, 'store'])->middleware('permission:union_members.create')->name('union_members.store');
    Route::get('union-members/{union_member}', [UnionMemberController::class, 'show'])->middleware('permission:union_members.view')->name('union_members.show');
    Route::get('union-members/{union_member}/edit', [UnionMemberController::class, 'edit'])->middleware('permission:union_members.edit')->name('union_members.edit');
    Route::put('union-members/{union_member}', [UnionMemberController::class, 'update'])->middleware('permission:union_members.edit')->name('union_members.update');
    Route::delete('union-members/{union_member}', [UnionMemberController::class, 'destroy'])->middleware('permission:union_members.delete')->name('union_members.destroy');

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
