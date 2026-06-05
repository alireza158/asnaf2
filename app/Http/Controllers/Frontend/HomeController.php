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
use App\Models\OrgLink;
use App\Models\Post;
use App\Models\System;
use App\Models\TourismPlace;
use App\Models\Video;
use App\Services\AdvertisementService;
use App\Services\MenuService;
use App\Services\SettingService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(AdvertisementService $advertisementService, MenuService $menus, SettingService $settings): View
    {
        $sections = HomeSection::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $latestPosts = Post::query()
            ->published()
            ->with(['category', 'union', 'galleries'])
            ->withCount('galleries')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $importantPosts = Post::query()
            ->published()
            ->important()
            ->with(['category', 'union', 'galleries'])
            ->withCount('galleries')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'important_news', 6))
            ->get();

        $heroPosts = Post::query()
            ->published()
            ->where(fn ($query) => $query->where('is_top', true)->orWhere('is_important', true)->orWhere('is_featured', true))
            ->with(['category', 'union', 'galleries'])
            ->withCount('galleries')
            ->orderByDesc('is_top')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'hero_slider', 6))
            ->get();

        if ($heroPosts->isEmpty()) {
            $heroPosts = $latestPosts->take($this->sectionLimit($sections, 'hero_slider', 6));
        }

        $announcements = Announcement::query()
            ->published()
            ->shownOnHome()
            ->with(['category', 'union'])
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'announcements', 5))
            ->get();

        if ($announcements->isEmpty()) {
            $announcements = Announcement::query()
                ->published()
                ->with(['category', 'union'])
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take($this->sectionLimit($sections, 'announcements', 5))
                ->get();
        }

        $importantAnnouncements = $announcements->where('is_important', true)->values();
        if ($importantAnnouncements->isEmpty()) {
            $importantAnnouncements = $announcements;
        }

        $homeUnions = GuildUnion::query()
            ->active()
            ->withCount(['posts as published_posts_count' => fn ($query) => $query->published()])
            ->orderBy('title')
            ->take($this->sectionLimit($sections, 'unions', 24))
            ->get();

        $productionUnions = $this->unionsByType(GuildUnion::TYPE_PRODUCTION);
        $distributionUnions = $this->unionsByType(GuildUnion::TYPE_DISTRIBUTION);
        $serviceUnions = $this->unionsByType(GuildUnion::TYPE_SERVICE);

        $electronicServices = ElectronicService::query()
            ->published()
            ->with('category')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'electronic_services', 6))
            ->get();

        $systems = System::query()
            ->published()
            ->with('category')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'systems', 6))
            ->get();

        $galleries = Gallery::query()
            ->published()
            ->with('union')
            ->withCount('images')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'galleries', 8))
            ->get();
        $latestGalleries = $galleries;

        $latestVideos = Video::query()
            ->published()
            ->with('union')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'videos', 5))
            ->get();

        $tourismLimit = $this->sectionLimit($sections, 'tourism', 4);
        $tourismNature = $this->tourismPlacesByType('nature', $tourismLimit);
        $tourismHistoric = $this->tourismPlacesByType('historic', $tourismLimit);
        $tourismShop = $this->tourismPlacesByType('shop', $tourismLimit);
        $tourismPlaces = $tourismNature->concat($tourismHistoric)->concat($tourismShop)->values();

        $commissions = Commission::query()
            ->published()
            ->with(['activeTasks'])
            ->withCount(['publishedSessions as sessions_count'])
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'commissions', 8))
            ->get();

        $congratulationMessages = CongratulationMessage::query()
            ->forHome()
            ->with('union')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($this->sectionLimit($sections, 'congratulation_messages', 3))
            ->get();

        $orgLinks = OrgLink::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $homeAdvertisements = $advertisementService->getByPosition(
            (string) (data_get($sections->firstWhere('key', 'advertisements')?->settings, 'position') ?: 'home_top'),
            $this->sectionLimit($sections, 'advertisements', 2)
        );

        if ($homeAdvertisements->isEmpty()) {
            $homeAdvertisements = $advertisementService->getByPosition('home_middle', 2);
        }

        $quickMenuItems = $menus->items('quick');
        $quickMenu = $quickMenuItems;
        $mainMenu = $menus->items('main');
        $footerMenu = $menus->items('footer');
        $priceItems = $this->priceItems($settings);
        $siteSettings = $settings->all();
        $homeSections = $sections;
        $unions = $homeUnions;
        $videos = $latestVideos;
        $advertisements = $homeAdvertisements;

        return view('frontend.home', compact(
            'sections',
            'importantPosts',
            'latestPosts',
            'heroPosts',
            'importantAnnouncements',
            'announcements',
            'homeUnions',
            'unions',
            'productionUnions',
            'distributionUnions',
            'serviceUnions',
            'electronicServices',
            'galleries',
            'latestGalleries',
            'latestVideos',
            'videos',
            'tourismPlaces',
            'tourismNature',
            'tourismHistoric',
            'tourismShop',
            'systems',
            'commissions',
            'congratulationMessages',
            'orgLinks',
            'homeAdvertisements',
            'advertisements',
            'quickMenuItems',
            'quickMenu',
            'mainMenu',
            'footerMenu',
            'siteSettings',
            'homeSections',
            'priceItems'
        ));
    }

    private function unionsByType(string $type): Collection
    {
        return GuildUnion::query()
            ->active()
            ->where('union_type', $type)
            ->orderBy('title')
            ->take(10)
            ->get();
    }

    private function tourismPlacesByType(string $type, int $limit): Collection
    {
        return TourismPlace::query()
            ->published()
            ->where('type', $type)
            ->with('category')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    private function priceItems(SettingService $settings): Collection
    {
        $defaults = [
            'gold' => ['label' => 'طلا ۱۸ عیار', 'value' => '—', 'unit' => 'تومان', 'trend' => ''],
            'coin' => ['label' => 'سکه امامی', 'value' => '—', 'unit' => 'تومان', 'trend' => ''],
            'silver' => ['label' => 'نقره', 'value' => '—', 'unit' => 'تومان', 'trend' => ''],
            'usd' => ['label' => 'دلار', 'value' => '—', 'unit' => 'تومان', 'trend' => ''],
        ];

        return collect($defaults)->map(function (array $fallback, string $key) use ($settings) {
            $item = (array) $settings->get("prices.{$key}", []);

            return array_merge($fallback, array_filter($item, fn ($value) => filled($value)));
        })->values();
    }

    private function sectionLimit(Collection $sections, string $key, int $default): int
    {
        $settings = $sections->firstWhere('key', $key)?->settings ?? [];

        return max(1, (int) ($settings['limit'] ?? $default));
    }
}
