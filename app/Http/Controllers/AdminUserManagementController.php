<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminUserManagementController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()
            ->with('roles')
            ->orderBy('name')
            ->get()
            ->map(fn (User $user): array => [
                'id' => $user->id,
                'email' => $user->email,
                'nama_lengkap' => $user->name,
                'role_id' => $user->roles->first()?->name ?? $user->role,
                'status_aktif' => $user->is_active,
                'mfa_enabled' => false,
                'nip_nis' => $user->nip_nis,
                'phone' => $user->phone,
            ]);

        return response()->json([
            'data' => $users,
            'meta' => [
                'roles' => Role::query()->orderBy('name')->pluck('name'),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'string', Rule::exists('roles', 'name')],
            'status_aktif' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
            'nip_nis' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $roleName = $validated['role_id'];

        $user = User::create([
            'email' => $validated['email'],
            'name' => $validated['nama_lengkap'],
            'role' => $roleName,
            'is_active' => $validated['status_aktif'] ?? true,
            'password' => Hash::make($validated['password'] ?? 'password123'),
            'nip_nis' => $validated['nip_nis'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        $user->syncRoles([$roleName]);

        return response()->json(['message' => 'User berhasil dibuat.'], 201);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'string', Rule::exists('roles', 'name')],
            'status_aktif' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
            'nip_nis' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->fill([
            'email' => $validated['email'],
            'name' => $validated['nama_lengkap'],
            'role' => $validated['role_id'],
            'is_active' => $validated['status_aktif'] ?? false,
            'nip_nis' => $validated['nip_nis'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles([$validated['role_id']]);

        return response()->json(['message' => 'User berhasil diperbarui.']);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}
