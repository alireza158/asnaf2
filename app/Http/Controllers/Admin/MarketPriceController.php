<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketPrice;
use App\Services\MarketPriceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class MarketPriceController extends Controller
{
    public function index(): View
    {
        $marketPrices = MarketPrice::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.market_prices.index', compact('marketPrices'));
    }

    public function edit(MarketPrice $marketPrice): View
    {
        return view('admin.market_prices.edit', compact('marketPrice'));
    }

    public function update(Request $request, MarketPrice $marketPrice): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'change_amount' => ['nullable', 'numeric'],
            'change_percent' => ['nullable', 'numeric', 'between:-999999.99,999999.99'],
            'currency' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:255'],
            'source_name' => ['nullable', 'string', 'max:255'],
            'source_url' => ['nullable', 'url', 'max:1000'],
            'is_active' => ['required', Rule::in(['0', '1'])],
            'sort_order' => ['required', 'integer', 'min:0'],
        ], [], [
            'title' => 'عنوان',
            'category' => 'دسته‌بندی',
            'price' => 'قیمت',
            'change_amount' => 'مقدار تغییر',
            'change_percent' => 'درصد تغییر',
            'currency' => 'واحد پول',
            'unit' => 'واحد',
            'source_name' => 'نام منبع',
            'source_url' => 'نشانی منبع',
            'is_active' => 'وضعیت نمایش',
            'sort_order' => 'ترتیب نمایش',
        ]);

        $marketPrice->update([
            ...$validated,
            'is_active' => (bool) $validated['is_active'],
        ]);

        return redirect()->route('admin.market_prices.index')->with('success', 'قیمت با موفقیت ویرایش شد.');
    }

    public function fetch(MarketPriceService $marketPriceService): RedirectResponse
    {
        try {
            $marketPriceService->fetchAndUpdate();

            return redirect()->route('admin.market_prices.index')->with('success', 'درخواست به‌روزرسانی قیمت‌ها با موفقیت اجرا شد.');
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('admin.market_prices.index')->with('error', $e->getMessage());
        }
    }
}
