<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['required', 'string', 'max:190', 'alpha_dash:ascii', 'unique:posts,slug'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'union_id' => ['nullable', 'exists:unions,id'],
            'type' => ['required', 'string', Rule::in(Post::TYPES)],
            'is_important' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'is_top' => ['required', 'boolean'],
            'status' => ['required', 'string', Rule::in($this->allowedStatuses())],
            'published_at' => ['nullable', 'date'],
            'rejected_reason' => ['nullable', 'string', 'max:1000'],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:4096'],
            'gallery_captions' => ['nullable', 'array'],
            'gallery_captions.*' => ['nullable', 'string', 'max:190'],
        ];
    }

    /** @return array<int, string> */
    private function allowedStatuses(): array
    {
        $statuses = Post::LIMITED_STATUSES;

        if ($this->user()?->hasPermission('posts.approve')) {
            $statuses = array_merge($statuses, ['approved', 'rejected', 'archived']);
        }

        if ($this->user()?->hasPermission('posts.publish')) {
            $statuses[] = 'published';
        }

        return array_values(array_unique($statuses));
    }
}
