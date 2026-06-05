<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $galleries = Gallery::query()
            ->published()
            ->with('union')
            ->withCount('images')
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")))
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.galleries.index', compact('galleries', 'search'));
    }

    public function show(string $slug): View
    {
        $gallery = Gallery::query()
            ->published()
            ->with(['union', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedGalleries = Gallery::query()
            ->published()
            ->whereKeyNot($gallery->id)
            ->withCount('images')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('frontend.galleries.show', compact('gallery', 'relatedGalleries'));
    }
}
