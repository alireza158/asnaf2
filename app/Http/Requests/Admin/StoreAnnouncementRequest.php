<?php

namespace App\Http\Requests\Admin;

use App\Models\Announcement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        normalize_jalali_request_dates($this, ['starts_at', 'expires_at', 'published_at']);
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['required', 'string', 'max:190', 'alpha_dash:ascii', 'unique:announcements,slug'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'attachment' => ['nullable', 'file', 'max:10240'],
            'category_id' => ['nullable', 'exists:announcement_categories,id'],
            'union_id' => ['nullable', 'exists:unions,id'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', ...($this->filled('starts_at') ? ['after_or_equal:starts_at'] : [])],
            'is_important' => ['required', 'boolean'],
            'show_on_home' => ['required', 'boolean'],
            'status' => ['required', 'string', Rule::in($this->allowedStatuses())],
            'published_at' => ['nullable', 'date'],
            'rejected_reason' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /** @return array<int, string> */
    private function allowedStatuses(): array
    {
        $statuses = Announcement::LIMITED_STATUSES;

        if ($this->user()?->hasPermission('announcements.approve')) {
            $statuses = array_merge($statuses, ['approved', 'rejected', 'archived']);
        }

        if ($this->user()?->hasPermission('announcements.publish')) {
            $statuses[] = 'published';
        }

        return array_values(array_unique($statuses));
    }
}
