<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnionType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UnionTypeController extends Controller
{
    public function index(): View
    {
        $unionTypes = UnionType::query()->orderBy('sort_order')->orderBy('title')->paginate(20);

        return view('admin.union_types.index', compact('unionTypes'));
    }

    public function create(): View
    {
        return view('admin.union_types.create', ['unionType' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        UnionType::create($this->validatedData($request));

        return redirect()->route('admin.union-types.index')->with('success', 'نوع اتحادیه با موفقیت ایجاد شد.');
    }

    public function edit(UnionType $unionType): View
    {
        return view('admin.union_types.edit', compact('unionType'));
    }

    public function update(Request $request, UnionType $unionType): RedirectResponse
    {
        $unionType->update($this->validatedData($request, $unionType));

        return redirect()->route('admin.union-types.index')->with('success', 'نوع اتحادیه با موفقیت ویرایش شد.');
    }

    public function destroy(UnionType $unionType): RedirectResponse
    {
        $unionType->delete();

        return redirect()->route('admin.union-types.index')->with('success', 'نوع اتحادیه حذف شد.');
    }

    private function validatedData(Request $request, ?UnionType $unionType = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('union_types', 'slug')->ignore($unionType?->id)],
            'icon' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
