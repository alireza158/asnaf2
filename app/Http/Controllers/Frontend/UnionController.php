<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\CongratulationMessage;
use App\Models\ElectronicService;
use App\Models\Gallery;
use App\Models\GuildUnion;
use App\Models\OrgLink;
use App\Models\Post;
use App\Models\Price;
use App\Models\System;
use App\Models\UnionMember;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class UnionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $unions = GuildUnion::query()
            ->active()
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('manager_name', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")))
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.guilds.index', compact('unions', 'search'));
    }


    public function ajaxSearch(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $type = (string) $request->query('type', '');

        $unions = GuildUnion::query()
            ->active()
            ->when($search === '' && in_array($type, [GuildUnion::TYPE_PRODUCTION, GuildUnion::TYPE_DISTRIBUTION, GuildUnion::TYPE_SERVICE], true), fn ($query) => $query->where('union_type', $type))
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('manager_name', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")))
            ->orderBy('title')
            ->take(24)
            ->get();

        return response()->json([
            'items' => $unions->values()->map(fn (GuildUnion $union, int $index) => [
                'title' => $union->display_title,
                'description' => $union->short_description ?: $union->manager_name ?: $union->union_type_label,
                'url' => route('guilds.show', $union->slug),
                'complaint_url' => route('complaints.create', $union->id),
                'avatar_class' => 'avatar-'.(($index % 6) + 1),
                'social_links' => $union->social_link_items,
            ]),
        ]);
    }

    public function show(string $slug): View
    {
        $union = GuildUnion::query()
            ->active()
            ->with(['activeCommissions.activeTasks'])
            ->where('slug', $slug)
            ->firstOrFail();

        $members = $union->members_enabled
            ? UnionMember::query()
                ->where('union_id', $union->id)
                ->where('is_active', true)
                ->where('status', 'active')
                ->orderBy('full_name')
                ->take(12)
                ->get()
            : collect();

        $posts = $union->news_enabled
            ? Post::query()
                ->published()
                ->where('union_id', $union->id)
                ->where('type', 'news')
                ->orderByDesc('is_top')
                ->latest('published_at')
                ->take(6)
                ->get()
            : collect();

        $articles = Post::query()
            ->published()
            ->where('union_id', $union->id)
            ->where('type', 'article')
            ->latest('published_at')
            ->take(6)
            ->get();

        if ($articles->isEmpty()) {
            $articles = Post::query()
                ->published()
                ->where('type', 'article')
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        $announcements = $union->announcements_enabled
            ? Announcement::query()
                ->published()
                ->where('union_id', $union->id)
                ->orderByDesc('is_important')
                ->latest('published_at')
                ->take(8)
                ->get()
            : collect();

        $rules = $announcements->take(6)->values();

        $galleries = $union->gallery_enabled
            ? Gallery::query()
                ->published()
                ->with(['images'])
                ->withCount('images')
                ->where('union_id', $union->id)
                ->latest('published_at')
                ->take(6)
                ->get()
            : collect();

        $videos = $union->videos_enabled
            ? Video::query()
                ->published()
                ->where('union_id', $union->id)
                ->latest('published_at')
                ->take(6)
                ->get()
            : collect();

        $trainings = ElectronicService::query()
            ->published()
            ->where(fn ($query) => $query
                ->where('title', 'like', '%آموز%')
                ->orWhere('short_description', 'like', '%آموز%')
                ->orWhere('body', 'like', '%آموز%'))
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(4)
            ->get();

        $systems = System::query()
            ->published()
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(4)
            ->get();

        $prices = Price::query()
            ->active()
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(10)
            ->get();

        $minutes = $announcements
            ->filter(fn (Announcement $announcement) => filled($announcement->attachment))
            ->take(4)
            ->values();

        $congratulationMessages = $union->congratulations_enabled
            ? CongratulationMessage::query()
                ->forUnionPage()
                ->where('union_id', $union->id)
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take(3)
                ->get()
            : collect();

        $orgLinks = OrgLink::query()
            ->active()
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('frontend.guilds.show', [
            'union' => $union,
            'members' => $members,
            'boardMembers' => $members->take(8),
            'posts' => $posts,
            'sliderPosts' => $posts->take(5),
            'articles' => $articles,
            'announcements' => $announcements,
            'rules' => $rules,
            'galleries' => $galleries,
            'videos' => $videos,
            'trainings' => $trainings,
            'systems' => $systems,
            'prices' => $prices,
            'minutes' => $minutes,
            'congratulationMessages' => $congratulationMessages,
            'orgLinks' => $orgLinks,
            'fallbacks' => $this->fallbacks($union),
        ]);
    }

    private function fallbacks(GuildUnion $union): array
    {
        $unionTitle = $union->display_title;
        $today = jalali_date(now());

        return [
            'members' => collect([
                ['name' => $union->manager_name ?: 'مدیر اتحادیه', 'position' => 'رییس اتحادیه', 'description' => 'اطلاعات اعضای هیئت مدیره هنوز در بانک اطلاعاتی تکمیل نشده است.'],
                ['name' => 'عضو هیئت مدیره', 'position' => 'عضو هیئت مدیره', 'description' => 'پس از ثبت اعضا، اطلاعات کامل از پایگاه داده نمایش داده می‌شود.'],
            ]),
            'commissions' => collect([
                ['title' => 'کمیسیون نظارت و بازرسی', 'description' => 'نظارت بر واحدهای صنفی و رسیدگی اولیه به تخلفات.', 'tasks' => collect(['بازرسی دوره‌ای', 'ثبت گزارش تخلف', 'ارجاع پرونده به مراجع مربوطه'])],
                ['title' => 'کمیسیون آموزش', 'description' => 'برگزاری دوره‌ها و آموزش‌های تخصصی اعضای اتحادیه.', 'tasks' => collect(['برنامه‌ریزی دوره‌ها', 'اطلاع‌رسانی آموزشی', 'ارزیابی نیازهای آموزشی'])],
                ['title' => 'کمیسیون حل اختلاف', 'description' => 'رسیدگی به اختلافات صنفی و تلاش برای صلح و سازش.', 'tasks' => collect(['دریافت درخواست', 'برگزاری جلسه', 'تنظیم گزارش'])],
            ]),
            'rules' => collect([
                ['title' => 'دستورالعمل فعالیت واحدهای صنفی', 'excerpt' => 'ضوابط عمومی فعالیت اعضای '.$unionTitle, 'url' => route('announcements.index')],
                ['title' => 'راهنمای صدور و تمدید پروانه کسب', 'excerpt' => 'مدارک و مراحل اداری مورد نیاز', 'url' => route('electronic-services.index')],
                ['title' => 'قانون نظام صنفی', 'excerpt' => 'حقوق و تکالیف واحدهای صنفی', 'url' => route('announcements.index')],
            ]),
            'slider' => collect([
                ['title' => 'آخرین اطلاع‌رسانی‌های '.$unionTitle, 'date' => $today, 'url' => route('posts.index'), 'image' => asset('assets/img/asnaf-gorgan-default.jpg')],
                ['title' => 'خدمات و آموزش‌های ویژه اعضای اتحادیه', 'date' => $today, 'url' => route('electronic-services.index'), 'image' => asset('assets/img/asnaf-gorgan-default.jpg')],
            ]),
            'articles' => collect([
                ['title' => 'راهنمای خدمات صنفی اتحادیه', 'excerpt' => 'محتواهای آموزشی و مقاله‌های مرتبط پس از ثبت در پنل مدیریت نمایش داده می‌شود.', 'date' => $today, 'url' => route('posts.index'), 'image' => asset('assets/img/asnaf-gorgan-default.jpg')],
            ]),
            'prices' => collect([
                ['title' => 'قیمت هر گرم طلای ۱۸ عیار', 'amount' => '—', 'type' => 'gold', 'unit' => 'ریال', 'source' => 'fallback', 'date' => $today],
                ['title' => 'سکه امامی', 'amount' => '—', 'type' => 'coin', 'unit' => 'ریال', 'source' => 'fallback', 'date' => $today],
                ['title' => 'نقره', 'amount' => '—', 'type' => 'silver', 'unit' => 'ریال', 'source' => 'fallback', 'date' => $today],
                ['title' => 'دلار', 'amount' => '—', 'type' => 'currency', 'unit' => 'تومان', 'source' => 'fallback', 'date' => $today],
            ]),
            'trainings' => collect([
                ['icon' => '📚', 'title' => 'دوره احکام تجارت', 'description' => 'آموزش قوانین و مقررات صنفی', 'url' => route('electronic-services.index')],
                ['icon' => '🛡️', 'title' => 'حقوق مصرف‌کننده', 'description' => 'آشنایی با الزامات بازرسی و رسیدگی', 'url' => route('electronic-services.index')],
            ]),
            'announcements_empty' => 'اطلاعیه یا بخشنامه‌ای برای این اتحادیه ثبت نشده است.',
            'trainings_empty' => 'دوره آموزشی فعالی برای این اتحادیه ثبت نشده است.',
            'minutes_empty' => 'صورتجلسه‌ای برای نمایش ثبت نشده است.',
            'gallery_empty' => 'گالری یا ویدیویی برای این اتحادیه ثبت نشده است.',
        ];
    }
}
