<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GuildUnion;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->query('category_id');
        $unionId = $request->query('union_id');

        $posts = Post::query()
            ->published()
            ->with(['category', 'union', 'galleries'])
            ->withCount('galleries')
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%")))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($unionId, fn ($query) => $query->where('union_id', $unionId))
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.posts.index', [
            'posts' => $posts,
            'categories' => PostCategory::query()->where('is_active', true)->orderBy('title')->orderBy('name')->get(),
            'unions' => GuildUnion::query()->where('is_active', true)->orderBy('title')->orderBy('name')->get(),
            'search' => $search,
            'categoryId' => $categoryId,
            'unionId' => $unionId,
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->where('slug', $slug)
            ->with(['category', 'union', 'author', 'galleries'])
            ->withCount('galleries')
            ->firstOrFail();

        $post->increment('views_count');
        $post->views_count++;

        $relatedPosts = Post::query()
            ->published()
            ->whereKeyNot($post->id)
            ->with(['category', 'galleries'])
            ->withCount('galleries')
            ->when($post->category_id, fn ($query) => $query->where('category_id', $post->category_id))
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        $previousPost = Post::query()
            ->published()
            ->where('published_at', '<', $post->published_at)
            ->orderByDesc('published_at')
            ->first();

        $nextPost = Post::query()
            ->published()
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at')
            ->first();

        return view('frontend.posts.show', compact('post', 'relatedPosts', 'previousPost', 'nextPost'));
    }
}
