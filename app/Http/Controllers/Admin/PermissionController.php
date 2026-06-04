<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(): View
    {
        $permissions = Permission::withCount('roles')->orderBy('group')->orderBy('name')->paginate(20);

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Permission::create($this->validatePermission($request));

        return redirect()->route('admin.permissions.index')->with('success', 'دسترسی با موفقیت ایجاد شد.');
    }

    public function edit(Permission $permission): View
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $permission->update($this->validatePermission($request, $permission));

        return redirect()->route('admin.permissions.index')->with('success', 'دسترسی با موفقیت ویرایش شد.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'دسترسی با موفقیت حذف شد.');
    }

    /**
     * @return array{name: string, label: string, group: string, description?: string|null}
     */
    private function validatePermission(Request $request, ?Permission $permission = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150', 'regex:/^[a-z0-9_]+\.[a-z0-9_]+$/', Rule::unique('permissions', 'name')->ignore($permission)],
            'label' => ['required', 'string', 'max:150'],
            'group' => ['required', 'string', 'max:80', 'alpha_dash:ascii'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
