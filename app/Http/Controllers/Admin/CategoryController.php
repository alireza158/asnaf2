<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $type = (string) $request->query('type', '');

        $categories = Category::query()
            ->when($type !== '', fn ($query) => $query->where('type', $type))
            ->orderBy('type')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(20)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => $categories,
            'types' => $this->typeLabels(),
            'type' => $type,
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', ['category' => null, 'types' => $this->typeLabels()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Category::create($this->validatedData($request));

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', ['category' => $category, 'types' => $this->typeLabels()]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($this->validatedData($request, $category));

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت ویرایش شد.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی حذف شد.');
    }

    private function validatedData(Request $request, ?Category $category = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('categories', 'slug')->ignore($category?->id)],
            'type' => ['required', Rule::in(array_keys($this->typeLabels()))],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']).'-'.$validated['type'];
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }

    private function typeLabels(): array
    {
        return [
            'news' => 'اخبار',
            'tourism' => 'گردشگری',
            'gallery' => 'گالری',
            'video' => 'ویدیو',
            'service' => 'خدمات',
            'system' => 'سامانه‌ها',
            'union' => 'اتحادیه‌ها',
        ];
    }
}
