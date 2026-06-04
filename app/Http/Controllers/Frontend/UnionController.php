<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GuildUnion;
use App\Models\Post;
use App\Models\Announcement;
use Illuminate\Http\Request;
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
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.guilds.index', compact('unions', 'search'));
    }

    public function show(string $slug): View
    {
        $union = GuildUnion::query()
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $posts = $union->news_enabled
            ? Post::query()->published()->where('union_id', $union->id)->latest('published_at')->take(6)->get()
            : collect();

        $announcements = $union->announcements_enabled
            ? Announcement::query()->published()->where('union_id', $union->id)->latest('published_at')->take(6)->get()
            : collect();

        return view('frontend.guilds.show', compact('union', 'posts', 'announcements'));
    }
}
