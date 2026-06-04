<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\GuildUnion;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', '');
        $type = (string) $request->query('type', '');

        $posts = Post::query()
            ->with(['category', 'union', 'author'])
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($type !== '', fn ($query) => $query->where('type', $type))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'search', 'status', 'type'));
    }

    public function create(): View
    {
        return view('admin.posts.create', $this->formData(null));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $this->postData($request->validated());
        $data['created_by'] = $request->user()?->id;
        $data['featured_image'] = $this->storeFeaturedImage($request);

        $post = Post::create($data);
        $this->storeGalleryImages($request, $post);

        return redirect()->route('admin.posts.show', $post)->with('success', 'خبر با موفقیت ایجاد شد.');
    }

    public function show(Post $post): View
    {
        $post->load(['category', 'union', 'author', 'approver', 'galleries']);

        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $post->load('galleries');

        return view('admin.posts.edit', $this->formData($post));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $this->postData($request->validated(), $post);

        if ($path = $this->storeFeaturedImage($request)) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $data['featured_image'] = $path;
        }

        $post->update($data);
        $this->deleteSelectedGalleryImages($request, $post);
        $this->storeGalleryImages($request, $post);

        return redirect()->route('admin.posts.show', $post)->with('success', 'خبر با موفقیت ویرایش شد.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        foreach ($post->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'خبر با موفقیت حذف شد.');
    }

    public function approve(Request $request, Post $post): RedirectResponse
    {
        $post->update([
            'status' => 'approved',
            'approved_by' => $request->user()?->id,
            'rejected_reason' => null,
        ]);

        return redirect()->route('admin.posts.show', $post)->with('success', 'خبر تایید شد.');
    }

    public function publish(Request $request, Post $post): RedirectResponse
    {
        $post->update([
            'status' => 'published',
            'approved_by' => $request->user()?->id,
            'published_at' => $post->published_at ?: now(),
            'rejected_reason' => null,
        ]);

        return redirect()->route('admin.posts.show', $post)->with('success', 'خبر منتشر شد.');
    }

    public function reject(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate(['rejected_reason' => ['required', 'string', 'max:1000']]);

        $post->update([
            'status' => 'rejected',
            'approved_by' => $request->user()?->id,
            'rejected_reason' => $validated['rejected_reason'],
        ]);

        return redirect()->route('admin.posts.show', $post)->with('success', 'خبر رد شد.');
    }

    /** @return array<string, mixed> */
    private function formData(?Post $post): array
    {
        return [
            'post' => $post,
            'statuses' => $this->allowedStatuses(),
            'types' => Post::TYPES,
            'categories' => PostCategory::query()->where('is_active', true)->orderBy('sort_order')->orderBy('title')->get(),
            'unions' => GuildUnion::query()->where('is_active', true)->orderBy('name')->get(),
        ];
    }

    /** @param array<string, mixed> $validated @return array<string, mixed> */
    private function postData(array $validated, ?Post $post = null): array
    {
        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'union_id' => $validated['union_id'] ?? null,
            'type' => $validated['type'],
            'is_important' => (bool) $validated['is_important'],
            'is_featured' => (bool) $validated['is_featured'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?: null,
            'rejected_reason' => $validated['rejected_reason'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) $validated['is_active'],
        ];

        if (in_array($data['status'], ['approved', 'published'], true)) {
            $data['approved_by'] = auth()->id() ?: $post?->approved_by;
            $data['rejected_reason'] = null;
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    private function storeFeaturedImage(Request $request): ?string
    {
        return $request->hasFile('featured_image')
            ? $request->file('featured_image')->store('posts/featured', 'public')
            : null;
    }

    private function storeGalleryImages(Request $request, Post $post): void
    {
        if (! $request->hasFile('gallery_images')) {
            return;
        }

        $captions = $request->input('gallery_captions', []);
        $nextSort = (int) $post->galleries()->max('sort_order') + 1;

        foreach ($request->file('gallery_images') as $index => $image) {
            $post->galleries()->create([
                'image' => $image->store('posts/gallery', 'public'),
                'caption' => $captions[$index] ?? null,
                'sort_order' => $nextSort + $index,
            ]);
        }
    }

    private function deleteSelectedGalleryImages(Request $request, Post $post): void
    {
        $ids = collect($request->input('delete_gallery', []))->filter()->values();

        if ($ids->isEmpty()) {
            return;
        }

        $post->galleries()->whereIn('id', $ids)->get()->each(function ($gallery) {
            Storage::disk('public')->delete($gallery->image);
            $gallery->delete();
        });
    }

    /** @return array<int, string> */
    private function allowedStatuses(): array
    {
        $statuses = Post::LIMITED_STATUSES;

        if (request()->user()?->hasPermission('posts.approve')) {
            $statuses = array_merge($statuses, ['approved', 'rejected', 'archived']);
        }

        if (request()->user()?->hasPermission('posts.publish')) {
            $statuses[] = 'published';
        }

        return array_values(array_unique($statuses));
    }
}
