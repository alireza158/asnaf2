<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FooterSettingController extends Controller
{
    public function edit(SettingService $settings): View
    {
        return view('admin.settings.footer', ['settings' => $settings]);
    }

    public function update(Request $request, SettingService $settings): RedirectResponse
    {
        $validated = $request->validate([
            'footer_logo' => ['nullable', 'image', 'max:4096'],
            'footer_description' => ['nullable', 'string'],
            'copyright_text' => ['nullable', 'string', 'max:500'],
            'footer_columns' => ['nullable', 'json'],
            'footer_contact_info' => ['nullable', 'json'],
            'footer_social_links' => ['nullable', 'json'],
        ]);

        if ($request->hasFile('footer_logo')) {
            if ($old = $settings->get('footer.footer_logo')) {
                Storage::disk('public')->delete($old);
            }
            $validated['footer_logo'] = $request->file('footer_logo')->store('settings/footer', 'public');
        } else {
            unset($validated['footer_logo']);
        }

        foreach (['footer_columns', 'footer_contact_info', 'footer_social_links'] as $field) {
            $validated[$field] = $this->jsonArray($validated[$field] ?? null);
        }

        $settings->setMany($validated, 'footer');

        return back()->with('success', 'تنظیمات فوتر ذخیره شد.');
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
