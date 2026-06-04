<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PostCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /** @var array<int, string> */
    private array $basePermissions = [
        'dashboard.view',
        'users.view', 'users.create', 'users.edit', 'users.delete',
        'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
        'permissions.view', 'permissions.create', 'permissions.edit', 'permissions.delete',
        'menus.view', 'menus.create', 'menus.edit', 'menus.delete',
        'pages.view', 'pages.create', 'pages.edit', 'pages.delete', 'pages.approve',
        'posts.view', 'posts.create', 'posts.edit', 'posts.delete', 'posts.approve', 'posts.publish',
        'announcements.view', 'announcements.create', 'announcements.edit', 'announcements.delete', 'announcements.approve', 'announcements.publish',
        'unions.view', 'unions.create', 'unions.edit', 'unions.delete',
        'union_members.view', 'union_members.create', 'union_members.edit', 'union_members.delete',
        'complaints.view', 'complaints.edit', 'complaints.reply', 'complaints.delete',
        'galleries.view', 'galleries.create', 'galleries.edit', 'galleries.delete',
        'videos.view', 'videos.create', 'videos.edit', 'videos.delete',
        'tourism.view', 'tourism.create', 'tourism.edit', 'tourism.delete',
        'advertisements.view', 'advertisements.create', 'advertisements.edit', 'advertisements.delete',
        'systems.view', 'systems.create', 'systems.edit', 'systems.delete',
        'commissions.view', 'commissions.create', 'commissions.edit', 'commissions.delete',
        'home_sections.view', 'home_sections.edit',
        'header_settings.view', 'header_settings.edit',
        'footer_settings.view', 'footer_settings.edit',
        'sms.view', 'sms.send', 'sms.logs',
        'contact_messages.view', 'contact_messages.delete',
        'settings.view', 'settings.edit',
    ];

    public function run(): void
    {
        $permissionIds = collect($this->basePermissions)->mapWithKeys(function (string $name) {
            $permission = Permission::updateOrCreate(
                ['name' => $name],
                [
                    'label' => $this->makeLabel($name),
                    'group' => Str::before($name, '.'),
                    'description' => 'دسترسی پایه '.$this->makeLabel($name),
                ]
            );

            return [$name => $permission->id];
        });

        $superAdmin = Role::updateOrCreate(
            ['name' => 'super-admin'],
            ['label' => 'مدیرکل', 'description' => 'دسترسی کامل به همه بخش‌های پنل مدیریت']
        );
        $superAdmin->permissions()->sync($permissionIds->values()->all());

        $unionExpertPermissions = [
            'dashboard.view',
            'unions.view', 'unions.edit',
            'union_members.view', 'union_members.create', 'union_members.edit', 'union_members.delete',
            'complaints.view', 'complaints.edit', 'complaints.reply',
            'sms.view', 'sms.send', 'sms.logs',
        ];

        $unionExpert = Role::updateOrCreate(
            ['name' => 'union-expert'],
            ['label' => 'کارشناس اتحادیه', 'description' => 'دسترسی نمونه به اتحادیه، اعضا، شکایات و پیامک']
        );
        $unionExpert->permissions()->sync($permissionIds->only($unionExpertPermissions)->values()->all());

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'مدیرکل سامانه', 'password' => Hash::make('password')]
        );
        $adminUser->roles()->syncWithoutDetaching([$superAdmin->id]);

        $expertUser = User::updateOrCreate(
            ['email' => 'union-expert@example.com'],
            ['name' => 'کارشناس اتحادیه', 'password' => Hash::make('password')]
        );
        $expertUser->roles()->syncWithoutDetaching([$unionExpert->id]);

        foreach ([
            ['title' => 'اخبار', 'slug' => 'news', 'sort_order' => 1],
            ['title' => 'مقالات', 'slug' => 'articles', 'sort_order' => 2],
            ['title' => 'اطلاعیه‌ها', 'slug' => 'announcements', 'sort_order' => 3],
        ] as $category) {
            PostCategory::updateOrCreate(
                ['slug' => $category['slug']],
                ['title' => $category['title'], 'sort_order' => $category['sort_order'], 'is_active' => true]
            );
        }
    }

    private function makeLabel(string $permission): string
    {
        [$group, $action] = explode('.', $permission);

        $groups = [
            'dashboard' => 'داشبورد', 'users' => 'کاربران', 'roles' => 'نقش‌ها', 'permissions' => 'دسترسی‌ها',
            'menus' => 'منوها', 'pages' => 'صفحات', 'posts' => 'اخبار', 'announcements' => 'اطلاعیه‌ها',
            'unions' => 'اتحادیه‌ها', 'union_members' => 'اعضای اتحادیه‌ها', 'complaints' => 'شکایات',
            'galleries' => 'گالری تصاویر', 'videos' => 'ویدیوها', 'tourism' => 'گردشگری',
            'advertisements' => 'تبلیغات', 'systems' => 'سامانه‌ها', 'commissions' => 'کمیسیون‌ها',
            'home_sections' => 'تنظیمات صفحه اصلی', 'header_settings' => 'تنظیمات هدر', 'footer_settings' => 'تنظیمات فوتر',
            'sms' => 'پیامک‌ها', 'contact_messages' => 'پیام‌های تماس', 'settings' => 'تنظیمات سایت',
        ];

        $actions = [
            'view' => 'مشاهده', 'create' => 'ایجاد', 'edit' => 'ویرایش', 'delete' => 'حذف',
            'approve' => 'تایید', 'publish' => 'انتشار', 'reply' => 'پاسخ', 'send' => 'ارسال', 'logs' => 'گزارش‌ها',
        ];

        return ($actions[$action] ?? $action).' '.($groups[$group] ?? $group);
    }
}
