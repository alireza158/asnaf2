<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use App\Models\TourismPlace;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourismController extends Controller
{
    public function index(Request $request): View
    {
        $category = trim((string) $request->query('category'));
        $search = trim((string) $request->query('search'));

        $places = TourismPlace::query()
            ->published()
            ->with('category')
            ->when($category !== '', fn ($query) => $query->whereHas('category', fn ($query) => $query
                ->where('slug', $category)
                ->when(ctype_digit($category), fn ($query) => $query->orWhere('id', (int) $category))))
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")))
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.tourism.index', [
            'places' => $places,
            'categories' => $this->categories(),
            'activeCategory' => $category,
            'search' => $search,
        ]);
    }

    public function show(string $slug): View
    {
        $place = TourismPlace::query()
            ->published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPlaces = TourismPlace::query()
            ->published()
            ->with('category')
            ->whereKeyNot($place->id)
            ->when($place->category_id, fn ($query) => $query->where('category_id', $place->category_id))
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(4)
            ->get();

        if ($relatedPlaces->isEmpty()) {
            $relatedPlaces = TourismPlace::query()
                ->published()
                ->with('category')
                ->whereKeyNot($place->id)
                ->orderBy('sort_order')
                ->latest('published_at')
                ->take(4)
                ->get();
        }

        return view('frontend.tourism.show', [
            'place' => $place,
            'relatedPlaces' => $relatedPlaces,
        ]);
    }

    private function categories()
    {
        return PostCategory::query()
            ->where('is_active', true)
            ->whereHas('tourismPlaces', fn ($query) => $query->published())
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
    }
}
