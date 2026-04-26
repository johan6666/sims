<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminPermissionManagementController extends Controller
{
    public function index(): JsonResponse
    {
        $permissions = Permission::query()
            ->with('roles')
            ->orderBy('name')
            ->get()
            ->map(function (Permission $permission): array {
                $mapping = MenuPermission::query()->where('permission_id', $permission->id)->with('menu')->first();

                return [
                    'id' => $permission->id,
                    'permission_name' => $permission->name,
                    'label' => $mapping?->label ?? Str::headline(last(explode('.', $permission->name))),
                    'menu_slug' => $mapping?->menu?->slug,
                    'menu_name' => $mapping?->menu?->name,
                    'action_key' => $mapping?->action_key ?? last(explode('.', $permission->name)),
                    'is_default' => $mapping?->is_default ?? false,
                    'roles' => $permission->roles->pluck('name')->values(),
                ];
            });

        return response()->json([
            'data' => $permissions,
            'meta' => [
                'menus' => Menu::query()->whereNotNull('parent_id')->orderBy('name')->get(['id', 'name', 'slug']),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'menu_slug' => ['required', 'string', Rule::exists('menus', 'slug')],
            'action_key' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9\-]+$/'],
            'label' => ['required', 'string', 'max:255'],
        ]);

        $menu = Menu::query()->where('slug', $validated['menu_slug'])->firstOrFail();
        $permissionName = $menu->permission_prefix.'.'.$validated['action_key'];

        DB::transaction(function () use ($menu, $validated, $permissionName): void {
            $permission = Permission::findOrCreate($permissionName, 'web');

            MenuPermission::updateOrCreate(
                ['permission_id' => $permission->id],
                [
                    'menu_id' => $menu->id,
                    'action_key' => $validated['action_key'],
                    'label' => $validated['label'],
                    'is_default' => false,
                    'sort_order' => ($menu->permissionMappings()->max('sort_order') ?? 0) + 1,
                ]
            );
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['message' => 'Permission berhasil dibuat.'], 201);
    }

    public function update(Request $request, Permission $permission): JsonResponse
    {
        $mapping = MenuPermission::query()->where('permission_id', $permission->id)->firstOrFail();

        $validated = $request->validate([
            'menu_slug' => ['required', 'string', Rule::exists('menus', 'slug')],
            'action_key' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9\-]+$/'],
            'label' => ['required', 'string', 'max:255'],
        ]);

        $menu = Menu::query()->where('slug', $validated['menu_slug'])->firstOrFail();
        $permissionName = $menu->permission_prefix.'.'.$validated['action_key'];

        DB::transaction(function () use ($permission, $mapping, $menu, $validated, $permissionName): void {
            $permission->update(['name' => $permissionName]);

            $mapping->update([
                'menu_id' => $menu->id,
                'action_key' => $validated['action_key'],
                'label' => $validated['label'],
            ]);
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['message' => 'Permission berhasil diperbarui.']);
    }

    public function destroy(Permission $permission): JsonResponse
    {
        MenuPermission::query()->where('permission_id', $permission->id)->delete();
        $permission->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['message' => 'Permission berhasil dihapus.']);
    }
}
