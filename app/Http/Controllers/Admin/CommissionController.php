<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CommissionController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', '');

        $commissions = Commission::query()
            ->withCount('sessions')
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.commissions.index', ['commissions' => $commissions, 'search' => $search, 'status' => $status, 'statusLabels' => Commission::statusLabels()]);
    }

    public function create(): View
    {
        return view('admin.commissions.create', ['statusLabels' => Commission::statusLabels()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $commission = Commission::create([
            ...$this->commissionData($validated),
            'created_by' => $request->user()?->id,
            'image' => $request->hasFile('image') ? $request->file('image')->store('commissions/images', 'public') : null,
            'attachments' => $this->storeFiles($request, 'attachments', 'commissions/attachments'),
        ]);

        return redirect()->route('admin.commissions.show', $commission)->with('success', 'کمیسیون با موفقیت ایجاد شد.');
    }

    public function show(Commission $commission): View
    {
        $commission->load(['sessions' => fn ($query) => $query->latest('session_date')]);

        return view('admin.commissions.show', compact('commission'));
    }

    public function edit(Commission $commission): View
    {
        return view('admin.commissions.edit', ['commission' => $commission, 'statusLabels' => Commission::statusLabels()]);
    }

    public function update(Request $request, Commission $commission): RedirectResponse
    {
        $validated = $this->validatedData($request, $commission);
        $data = $this->commissionData($validated, $commission);

        if ($request->hasFile('image')) {
            if ($commission->image) {
                Storage::disk('public')->delete($commission->image);
            }
            $data['image'] = $request->file('image')->store('commissions/images', 'public');
        }

        $data['attachments'] = $this->syncAttachments($request, $commission);
        $commission->update($data);

        return redirect()->route('admin.commissions.show', $commission)->with('success', 'کمیسیون با موفقیت ویرایش شد.');
    }

    public function destroy(Commission $commission): RedirectResponse
    {
        if ($commission->image) {
            Storage::disk('public')->delete($commission->image);
        }
        foreach ($commission->attachments ?? [] as $file) {
            Storage::disk('public')->delete($file['path'] ?? '');
        }
        foreach ($commission->sessions as $session) {
            if ($session->minutes_file) {
                Storage::disk('public')->delete($session->minutes_file);
            }
            foreach (array_merge($session->attachments ?? [], $session->images ?? []) as $file) {
                Storage::disk('public')->delete($file['path'] ?? '');
            }
        }
        $commission->delete();

        return redirect()->route('admin.commissions.index')->with('success', 'کمیسیون با موفقیت حذف شد.');
    }

    private function validatedData(Request $request, ?Commission $commission = null): array
    {
        normalize_jalali_request_dates($request, ['published_at']);

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('commissions', 'slug')->ignore($commission?->id)],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'members' => ['nullable', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240'],
            'existing_attachments' => ['nullable', 'array'],
            'status' => ['required', Rule::in(app(\App\Services\ContentApprovalService::class)->allowedStatusesFor($request->user(), ['commissions.approve', 'commissions.publish']))],
            'published_at' => ['nullable', 'date'],
            'rejected_reason' => ['nullable', 'required_if:status,rejected', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', Rule::in(['0', '1'])],
        ]);
    }

    private function commissionData(array $validated, ?Commission $commission = null): array
    {
        return [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['slug'] ?: $validated['title'], $commission),
            'description' => $validated['description'] ?? null,
            'members' => $this->membersFromText($validated['members'] ?? ''),
            'status' => $validated['status'],
            'published_at' => ($validated['status'] === 'published' && empty($validated['published_at'])) ? now() : ($validated['published_at'] ?? null),
            'rejected_reason' => $validated['rejected_reason'] ?? null,
            'approved_by' => in_array($validated['status'], ['approved', 'published'], true) ? (auth()->id() ?: $commission?->approved_by) : $commission?->approved_by,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) $validated['is_active'],
        ];
    }

    private function membersFromText(string $text): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $text))->map(fn ($line) => trim($line))->filter()->map(fn ($line) => ['name' => $line])->values()->all();
    }

    private function storeFiles(Request $request, string $field, string $directory): array
    {
        if (! $request->hasFile($field)) {
            return [];
        }

        return collect($request->file($field))->map(fn ($file) => ['name' => $file->getClientOriginalName(), 'path' => $file->store($directory, 'public')])->values()->all();
    }

    private function syncAttachments(Request $request, Commission $commission): array
    {
        $existing = collect($commission->attachments ?? [])->map(function ($file, $index) use ($request) {
            $payload = $request->input("existing_attachments.{$index}", []);
            $file['delete'] = ($payload['delete'] ?? null) === '1';
            return $file;
        });
        $existing->where('delete', true)->each(fn ($file) => Storage::disk('public')->delete($file['path'] ?? ''));

        return $existing->reject(fn ($file) => $file['delete'])->map(fn ($file) => collect($file)->except('delete')->all())->values()
            ->merge($this->storeFiles($request, 'attachments', 'commissions/attachments'))->all();
    }

    private function uniqueSlug(string $value, ?Commission $commission = null): string
    {
        $baseSlug = Str::slug($value) ?: Str::random(8);
        $slug = $baseSlug;
        $counter = 2;
        while (Commission::query()->where('slug', $slug)->when($commission, fn ($query) => $query->whereKeyNot($commission->id))->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }
        return $slug;
    }
}
