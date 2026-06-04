<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\GuildUnion;
use App\Models\HomeSection;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sections = HomeSection::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $importantPosts = Post::query()
            ->published()
            ->important()
            ->with('category')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'important_news', 6))
            ->get();

        $heroPosts = Post::query()
            ->published()
            ->important()
            ->with('category')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'hero_slider', 6))
            ->get();

        $importantAnnouncements = Announcement::query()
            ->published()
            ->important()
            ->shownOnHome()
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'announcements', 5))
            ->get();

        $homeUnions = GuildUnion::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->take($this->sectionLimit($sections, 'unions', 8))
            ->get();

        $latestGalleries = Gallery::query()
            ->published()
            ->withCount('images')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'galleries', 3))
            ->get();

        return view('frontend.home', compact(
            'sections',
            'importantPosts',
            'heroPosts',
            'importantAnnouncements',
            'homeUnions',
            'latestGalleries'
        ));
    }

    private function sectionLimit($sections, string $key, int $default): int
    {
        $settings = $sections->firstWhere('key', $key)?->settings ?? [];

        return max(1, (int) ($settings['limit'] ?? $default));
    }
}
