<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(SettingService $settings): View
    {
        return view('admin.settings.site', ['settings' => $settings]);
    }

    public function update(Request $request, SettingService $settings): RedirectResponse
    {
        $validated = $request->validate([
            'site_title' => ['nullable', 'string', 'max:255'],
            'site_description' => ['nullable', 'string'],
            'site_logo' => ['nullable', 'image', 'max:4096'],
            'site_favicon' => ['nullable', 'image', 'max:1024'],
            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'map_url' => ['nullable', 'url', 'max:500'],
            'social_links' => ['nullable', 'json'],
        ]);

        foreach (['site_logo', 'site_favicon'] as $field) {
            if ($request->hasFile($field)) {
                if ($old = $settings->get('site.'.$field)) {
                    Storage::disk('public')->delete($old);
                }
                $validated[$field] = $request->file($field)->store('settings/site', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        $validated['social_links'] = $this->jsonArray($validated['social_links'] ?? null);
        $settings->setMany($validated, 'site');

        return back()->with('success', 'تنظیمات سایت ذخیره شد.');
    }

    private function jsonArray(?string $value): array
    {
        if (! $value) {
            return [];
        }
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }
}
