<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\CongratulationMessage;
use App\Models\Gallery;
use App\Models\GuildUnion;
use App\Models\Post;
use App\Models\UnionMember;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $unions = $this->searchQuery($search)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.guilds.index', compact('unions', 'search'));
    }

    public function search(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('q', ''));
        $type = trim((string) $request->query('type', ''));
        $allowedTypes = array_keys(GuildUnion::typeLabels());

        $unions = $this->searchQuery($search)
            ->when(in_array($type, $allowedTypes, true), fn (Builder $query) => $query->where('union_type', $type))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->take(10)
            ->get();

        return response()->json([
            'items' => $unions->values()->map(fn (GuildUnion $union, int $index) => [
                'title' => $union->display_title,
                'description' => $union->short_description ?: $union->manager_name ?: $union->union_type_label,
                'url' => route('guilds.show', $union->slug),
                'avatar_class' => 'avatar-'.(($index % 6) + 1),
            ]),
        ]);
    }

    public function show(string $slug): View
    {
        $union = GuildUnion::query()->active()->where('slug', $slug)->firstOrFail();
        $posts = $union->news_enabled ? Post::query()->published()->where('union_id', $union->id)->latest('published_at')->take(6)->get() : collect();
        $announcements = $union->announcements_enabled ? Announcement::query()->published()->where('union_id', $union->id)->latest('published_at')->take(6)->get() : collect();
        $members = $union->members_enabled ? UnionMember::query()->where('union_id', $union->id)->where('is_active', true)->orderBy('full_name')->take(12)->get() : collect();
        $galleries = $union->gallery_enabled ? Gallery::query()->published()->withCount('images')->where('union_id', $union->id)->latest('published_at')->take(6)->get() : collect();
        $videos = $union->videos_enabled ? Video::query()->published()->where('union_id', $union->id)->latest('published_at')->take(6)->get() : collect();
        $congratulationMessages = $union->congratulations_enabled ? CongratulationMessage::query()->forUnionPage()->where('union_id', $union->id)->orderBy('sort_order')->latest('published_at')->take(3)->get() : collect();

        return view('frontend.guilds.show', compact('union', 'posts', 'announcements', 'members', 'galleries', 'videos', 'congratulationMessages'));
    }

    private function searchQuery(string $search): Builder
    {
        return GuildUnion::query()
            ->active()
            ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('manager_name', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")));
    }
}
