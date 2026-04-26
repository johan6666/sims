<?php

namespace App\Http\Controllers;

use App\Models\RoleProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminRoleManagementController extends Controller
{
    public function index(): JsonResponse
    {
        $profiles = RoleProfile::query()->get()->keyBy('role_id');

        $roles = Role::query()
            ->with('permissions')
            ->orderBy('name')
            ->get()
            ->map(function (Role $role) use ($profiles): array {
                $profile = $profiles->get($role->id);

                return [
                    'id' => $role->id,
                    'nama_role' => $role->name,
                    'deskripsi' => $profile?->description,
                    'kategori_role' => $profile?->category ?? $role->name,
                    'permissions' => $role->permissions->pluck('name')->values(),
                ];
            });

        return response()->json([
            'data' => $roles,
            'meta' => [
                'permissions' => Permission::query()->orderBy('name')->pluck('name'),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_role' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'deskripsi' => ['nullable', 'string'],
            'kategori_role' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::exists('permissions', 'name')],
        ]);

        DB::transaction(function () use ($validated): void {
            $role = Role::create([
                'name' => $validated['nama_role'],
                'guard_name' => 'web',
            ]);

            RoleProfile::updateOrCreate(
                ['role_id' => $role->id],
                [
                    'description' => $validated['deskripsi'] ?? null,
                    'category' => $validated['kategori_role'] ?? $validated['nama_role'],
                ]
            );

            $role->syncPermissions($validated['permissions'] ?? []);
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['message' => 'Role berhasil dibuat.'], 201);
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'nama_role' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'deskripsi' => ['nullable', 'string'],
            'kategori_role' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::exists('permissions', 'name')],
        ]);

        DB::transaction(function () use ($role, $validated): void {
            $role->update(['name' => $validated['nama_role']]);

            RoleProfile::updateOrCreate(
                ['role_id' => $role->id],
                [
                    'description' => $validated['deskripsi'] ?? null,
                    'category' => $validated['kategori_role'] ?? $validated['nama_role'],
                ]
            );

            $role->syncPermissions($validated['permissions'] ?? []);
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['message' => 'Role berhasil diperbarui.']);
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['message' => 'Role berhasil dihapus.']);
    }
}
