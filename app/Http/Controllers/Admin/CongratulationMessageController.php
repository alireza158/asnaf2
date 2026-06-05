<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CongratulationMessage;
use App\Models\GuildUnion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CongratulationMessageController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $unionId = $request->query('union_id');
        $status = (string) $request->query('status', '');

        $messages = CongratulationMessage::query()
            ->with('union')
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%")
                ->orWhere('manager_name', 'like', "%{$search}%")))
            ->when($unionId, fn ($query) => $query->where('union_id', $unionId))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.congratulation_messages.index', [
            'messages' => $messages,
            'unions' => $this->unions(),
            'statusLabels' => CongratulationMessage::statusLabels(),
            'search' => $search,
            'unionId' => $unionId,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.congratulation_messages.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $message = CongratulationMessage::create([
            ...$this->messageData($validated),
            'created_by' => $request->user()?->id,
            'manager_image' => $request->hasFile('manager_image') ? $request->file('manager_image')->store('congratulation-messages/managers', 'public') : null,
        ]);

        return redirect()->route('admin.congratulation_messages.show', $message)->with('success', 'پیام تبریک با موفقیت ایجاد شد.');
    }

    public function show(CongratulationMessage $congratulationMessage): View
    {
        $congratulationMessage->load(['union', 'creator', 'approver']);

        return view('admin.congratulation_messages.show', ['message' => $congratulationMessage]);
    }

    public function edit(CongratulationMessage $congratulationMessage): View
    {
        return view('admin.congratulation_messages.edit', [
            ...$this->formData(),
            'message' => $congratulationMessage,
        ]);
    }

    public function update(Request $request, CongratulationMessage $congratulationMessage): RedirectResponse
    {
        $validated = $this->validatedData($request, $congratulationMessage);
        $data = $this->messageData($validated, $congratulationMessage);

        if ($request->hasFile('manager_image')) {
            if ($congratulationMessage->manager_image) {
                Storage::disk('public')->delete($congratulationMessage->manager_image);
            }

            $data['manager_image'] = $request->file('manager_image')->store('congratulation-messages/managers', 'public');
        }

        $congratulationMessage->update($data);

        return redirect()->route('admin.congratulation_messages.show', $congratulationMessage)->with('success', 'پیام تبریک با موفقیت ویرایش شد.');
    }

    public function destroy(CongratulationMessage $congratulationMessage): RedirectResponse
    {
        if ($congratulationMessage->manager_image) {
            Storage::disk('public')->delete($congratulationMessage->manager_image);
        }

        $congratulationMessage->delete();

        return redirect()->route('admin.congratulation_messages.index')->with('success', 'پیام تبریک با موفقیت حذف شد.');
    }

    private function validatedData(Request $request, ?CongratulationMessage $message = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('congratulation_messages', 'slug')->ignore($message?->id)],
            'body' => ['nullable', 'string'],
            'manager_name' => ['nullable', 'string', 'max:255'],
            'manager_position' => ['nullable', 'string', 'max:255'],
            'manager_image' => ['nullable', 'image', 'max:4096'],
            'union_id' => ['nullable', 'exists:unions,id'],
            'show_on_home' => ['required', Rule::in(['0', '1'])],
            'show_on_union_page' => ['required', Rule::in(['0', '1'])],
            'status' => ['required', Rule::in(app(\App\Services\ContentApprovalService::class)->allowedStatusesFor($request->user(), ['congratulation_messages.approve', 'congratulation_messages.publish']))],
            'published_at' => ['nullable', 'date'],
            'rejected_reason' => ['nullable', 'required_if:status,rejected', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', Rule::in(['0', '1'])],
        ], [], [
            'title' => 'عنوان',
            'slug' => 'نامک',
            'body' => 'متن پیام',
            'manager_name' => 'نام مدیر',
            'manager_position' => 'سمت مدیر',
            'manager_image' => 'تصویر مدیر',
            'union_id' => 'اتحادیه',
            'show_on_home' => 'نمایش در صفحه اصلی',
            'show_on_union_page' => 'نمایش در صفحه اتحادیه',
            'status' => 'وضعیت',
            'published_at' => 'تاریخ انتشار',
            'rejected_reason' => 'دلیل رد',
            'sort_order' => 'ترتیب نمایش',
            'is_active' => 'فعال',
        ]);
    }

    private function messageData(array $validated, ?CongratulationMessage $message = null): array
    {
        return [
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['slug'] ?: $validated['title'], $message),
            'body' => $validated['body'] ?? null,
            'manager_name' => $validated['manager_name'] ?? null,
            'manager_position' => $validated['manager_position'] ?? null,
            'union_id' => $validated['union_id'] ?? null,
            'show_on_home' => (bool) $validated['show_on_home'],
            'show_on_union_page' => (bool) $validated['show_on_union_page'],
            'status' => $validated['status'],
            'published_at' => ($validated['status'] === 'published' && empty($validated['published_at'])) ? now() : ($validated['published_at'] ?? null),
            'rejected_reason' => $validated['rejected_reason'] ?? null,
            'approved_by' => in_array($validated['status'], ['approved', 'published'], true) ? (auth()->id() ?: $message?->approved_by) : $message?->approved_by,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) $validated['is_active'],
        ];
    }

    private function uniqueSlug(string $value, ?CongratulationMessage $message = null): string
    {
        $baseSlug = Str::slug($value) ?: Str::random(8);
        $slug = $baseSlug;
        $counter = 2;

        while (CongratulationMessage::query()->where('slug', $slug)->when($message, fn ($query) => $query->whereKeyNot($message->id))->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }

    private function unions()
    {
        return GuildUnion::query()->active()->orderBy('sort_order')->orderBy('title')->get();
    }

    private function formData(): array
    {
        return [
            'unions' => $this->unions(),
            'statusLabels' => CongratulationMessage::statusLabels(),
        ];
    }
}
