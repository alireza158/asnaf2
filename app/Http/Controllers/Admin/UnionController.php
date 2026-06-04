<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUnionRequest;
use App\Http\Requests\Admin\UpdateUnionRequest;
use App\Models\GuildUnion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UnionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $unions = GuildUnion::query()
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('manager_name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('mobile', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.unions.index', compact('unions', 'search'));
    }

    public function create(): View
    {
        return view('admin.unions.create', ['union' => null]);
    }

    public function store(StoreUnionRequest $request): RedirectResponse
    {
        $data = $this->unionData($request->validated());
        $data['logo'] = $this->storeImage($request, 'logo', 'unions/logos');
        $data['cover_image'] = $this->storeImage($request, 'cover_image', 'unions/covers');
        $data['manager_image'] = $this->storeImage($request, 'manager_image', 'unions/managers');

        $union = GuildUnion::create($data);

        return redirect()->route('admin.unions.show', $union)->with('success', 'اتحادیه با موفقیت ایجاد شد.');
    }

    public function show(GuildUnion $union): View
    {
        $union->loadCount(['posts', 'announcements', 'users']);

        return view('admin.unions.show', compact('union'));
    }

    public function edit(GuildUnion $union): View
    {
        return view('admin.unions.edit', compact('union'));
    }

    public function update(UpdateUnionRequest $request, GuildUnion $union): RedirectResponse
    {
        $data = $this->unionData($request->validated());

        foreach (['logo' => 'unions/logos', 'cover_image' => 'unions/covers', 'manager_image' => 'unions/managers'] as $field => $directory) {
            if ($path = $this->storeImage($request, $field, $directory)) {
                if ($union->{$field}) {
                    Storage::disk('public')->delete($union->{$field});
                }

                $data[$field] = $path;
            }
        }

        $union->update($data);

        return redirect()->route('admin.unions.show', $union)->with('success', 'اتحادیه با موفقیت ویرایش شد.');
    }

    public function destroy(GuildUnion $union): RedirectResponse
    {
        foreach (['logo', 'cover_image', 'manager_image'] as $field) {
            if ($union->{$field}) {
                Storage::disk('public')->delete($union->{$field});
            }
        }

        $union->delete();

        return redirect()->route('admin.unions.index')->with('success', 'اتحادیه با موفقیت حذف شد.');
    }

    /** @param array<string, mixed> $validated @return array<string, mixed> */
    private function unionData(array $validated): array
    {
        $socialLinks = collect($validated['social_links'] ?? [])
            ->filter(fn ($url) => filled($url))
            ->all();

        return [
            'name' => $validated['title'],
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'mobile' => $validated['mobile'] ?? null,
            'email' => $validated['email'] ?? null,
            'website' => $validated['website'] ?? null,
            'manager_name' => $validated['manager_name'] ?? null,
            'working_hours' => $validated['working_hours'] ?? null,
            'social_links' => $socialLinks === [] ? null : $socialLinks,
            'complaint_enabled' => (bool) $validated['complaint_enabled'],
            'congratulations_enabled' => (bool) $validated['congratulations_enabled'],
            'news_enabled' => (bool) $validated['news_enabled'],
            'announcements_enabled' => (bool) $validated['announcements_enabled'],
            'gallery_enabled' => (bool) $validated['gallery_enabled'],
            'videos_enabled' => (bool) $validated['videos_enabled'],
            'members_enabled' => (bool) $validated['members_enabled'],
            'services_enabled' => (bool) $validated['services_enabled'],
            'is_active' => (bool) $validated['is_active'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
        ];
    }

    private function storeImage(Request $request, string $field, string $directory): ?string
    {
        return $request->hasFile($field)
            ? $request->file($field)->store($directory, 'public')
            : null;
    }
}
