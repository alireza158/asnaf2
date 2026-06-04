<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\View\View;

class CommissionController extends Controller
{
    public function index(): View
    {
        $commissions = Commission::query()
            ->published()
            ->withCount(['publishedSessions as sessions_count'])
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12);

        return view('frontend.commissions.index', compact('commissions'));
    }

    public function show(string $slug): View
    {
        $commission = Commission::query()
            ->published()
            ->with(['publishedSessions' => fn ($query) => $query->orderByDesc('session_date')])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.commissions.show', compact('commission'));
    }
}
