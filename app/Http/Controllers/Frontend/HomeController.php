<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Commission;
use App\Models\CongratulationMessage;
use App\Models\ElectronicService;
use App\Models\Gallery;
use App\Models\GuildUnion;
use App\Models\HomeSection;
use App\Models\Post;
use App\Models\System;
use App\Models\TourismPlace;
use App\Models\Video;
use App\Services\AdvertisementService;
use App\Services\MenuService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(AdvertisementService $advertisements, MenuService $menus): View
    {
        $sections = HomeSection::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $importantPosts = $this->hasSection($sections, 'important_news')
            ? Post::query()
                ->published()
                ->important()
                ->with(['category', 'union', 'galleries'])
                ->withCount('galleries')
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'important_news', 6))
                ->get()
            : collect();

        $heroPosts = $this->hasSection($sections, 'hero_slider')
            ? Post::query()
                ->published()
                ->important()
                ->with(['category', 'union', 'galleries'])
                ->withCount('galleries')
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'hero_slider', 6))
                ->get()
            : collect();

        $importantAnnouncements = $this->hasSection($sections, 'announcements')
            ? Announcement::query()
                ->published()
                ->important()
                ->shownOnHome()
                ->with(['category', 'union'])
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'announcements', 5))
                ->get()
            : collect();

        $homeUnions = $this->hasSection($sections, 'unions')
            ? GuildUnion::query()
                ->active()
                ->withCount(['posts as published_posts_count' => fn ($query) => $query->published()])
                ->orderBy('sort_order')
                ->orderBy('title')
                ->take($this->sectionLimit($sections, 'unions', 8))
                ->get()
            : collect();

        $electronicServices = $this->hasSection($sections, 'electronic_services')
            ? ElectronicService::query()
                ->published()
                ->with('category')
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'electronic_services', 6))
                ->get()
            : collect();

        $galleries = $this->hasSection($sections, 'galleries')
            ? Gallery::query()
                ->published()
                ->with('union')
                ->withCount('images')
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'galleries', 6))
                ->get()
            : collect();
        $latestGalleries = $galleries;

        $latestVideos = $this->hasSection($sections, 'videos')
            ? Video::query()
                ->published()
                ->with('union')
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'videos', 3))
                ->get()
            : collect();

        $tourismLimit = $this->sectionLimit($sections, 'tourism', 4);
        $tourismNature = $this->tourismPlacesByType($sections, 'nature', $tourismLimit);
        $tourismHistoric = $this->tourismPlacesByType($sections, 'historic', $tourismLimit);
        $tourismShop = $this->tourismPlacesByType($sections, 'shop', $tourismLimit);
        $tourismPlaces = $tourismNature->concat($tourismHistoric)->concat($tourismShop);

        $systems = $this->hasSection($sections, 'systems')
            ? System::query()
                ->published()
                ->with('category')
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'systems', 6))
                ->get()
            : collect();

        $commissions = $this->hasSection($sections, 'commissions')
            ? Commission::query()
                ->published()
                ->withCount(['publishedSessions as sessions_count'])
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'commissions', 8))
                ->get()
            : collect();

        $congratulationMessages = $this->hasSection($sections, 'congratulation_messages')
            ? CongratulationMessage::query()
                ->forHome()
                ->with('union')
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'congratulation_messages', 3))
                ->get()
            : collect();

        $homeAdvertisements = $this->hasSection($sections, 'advertisements')
            ? $advertisements->getByPosition(
                (string) data_get($sections->firstWhere('key', 'advertisements')?->settings, 'position', 'home_top'),
                $this->sectionLimit($sections, 'advertisements', 2)
            )
            : collect();

        $quickMenuItems = $this->hasSection($sections, 'quick_menu') ? $menus->items('quick') : collect();

        return view('frontend.home', compact(
            'sections',
            'importantPosts',
            'heroPosts',
            'importantAnnouncements',
            'homeUnions',
            'electronicServices',
            'galleries',
            'latestGalleries',
            'latestVideos',
            'tourismPlaces',
            'tourismNature',
            'tourismHistoric',
            'tourismShop',
            'systems',
            'commissions',
            'congratulationMessages',
            'homeAdvertisements',
            'quickMenuItems'
        ));
    }

    private function tourismPlacesByType(Collection $sections, string $type, int $limit): Collection
    {
        if (! $this->hasSection($sections, 'tourism')) {
            return collect();
        }

        return TourismPlace::query()
            ->published()
            ->where('type', $type)
            ->with('category')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    private function sectionLimit(Collection $sections, string $key, int $default): int
    {
        $settings = $sections->firstWhere('key', $key)?->settings ?? [];

        return max(1, (int) ($settings['limit'] ?? $default));
    }

    private function hasSection(Collection $sections, string $key): bool
    {
        return $sections->contains('key', $key);
    }
}
