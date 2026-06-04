<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeaderSettingController extends Controller
{
    public function edit(SettingService $settings): View
    {
        return view('admin.settings.header', ['settings' => $settings]);
    }

    public function update(Request $request, SettingService $settings): RedirectResponse
    {
        $validated = $request->validate([
            'header_logo' => ['nullable', 'image', 'max:4096'],
            'top_text' => ['nullable', 'string', 'max:255'],
            'top_date_enabled' => ['required', 'in:0,1'],
            'contact_button_text' => ['nullable', 'string', 'max:255'],
            'contact_button_link' => ['nullable', 'string', 'max:500'],
            'service_button_text' => ['nullable', 'string', 'max:255'],
            'service_button_link' => ['nullable', 'string', 'max:500'],
            'special_link_1_title' => ['nullable', 'string', 'max:255'],
            'special_link_1_url' => ['nullable', 'string', 'max:500'],
            'special_link_1_icon' => ['nullable', 'string', 'max:100'],
            'special_link_1_color' => ['nullable', 'string', 'max:50'],
            'special_link_1_active' => ['required', 'in:0,1'],
            'special_link_2_title' => ['nullable', 'string', 'max:255'],
            'special_link_2_url' => ['nullable', 'string', 'max:500'],
            'special_link_2_icon' => ['nullable', 'string', 'max:100'],
            'special_link_2_color' => ['nullable', 'string', 'max:50'],
            'special_link_2_active' => ['required', 'in:0,1'],
        ]);

        if ($request->hasFile('header_logo')) {
            if ($old = $settings->get('header.header_logo')) {
                Storage::disk('public')->delete($old);
            }
            $validated['header_logo'] = $request->file('header_logo')->store('settings/header', 'public');
        } else {
            unset($validated['header_logo']);
        }

        foreach (['top_date_enabled', 'special_link_1_active', 'special_link_2_active'] as $field) {
            $validated[$field] = (bool) $validated[$field];
        }

        $settings->setMany($validated, 'header');

        return back()->with('success', 'تنظیمات هدر ذخیره شد.');
    }
}
