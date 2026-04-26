<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminMenuCrudController extends Controller
{
    private function defaultUrlForSlug(string $slug): string
    {
        return '/admin?menu='.$slug;
    }

    public function index(): JsonResponse
    {
        $menus = Menu::query()
            ->with('parent')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Menu $menu): array => [
                'id' => $menu->id,
                'module_name' => $menu->parent?->name ?? $menu->name,
                'module_slug' => $menu->parent?->slug,
                'menu_name' => $menu->name,
                'slug' => $menu->slug,
                'url' => $menu->url ?: $this->defaultUrlForSlug($menu->slug),
                'status_aktif' => $menu->is_active,
                'parent_slug' => $menu->parent?->slug,
            ]);

        return response()->json([
            'data' => $menus,
            'meta' => [
                'modules' => Menu::query()->whereNull('parent_id')->orderBy('name')->get(['id', 'name', 'slug']),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'module_slug' => ['required', 'string', Rule::exists('menus', 'slug')],
            'menu_name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'status_aktif' => ['nullable', 'boolean'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $module = Menu::query()->where('slug', $validated['module_slug'])->whereNull('parent_id')->firstOrFail();
        $slug = $module->slug.'.'.Str::slug($validated['menu_name']);

        Menu::create([
            'parent_id' => $module->id,
            'name' => $validated['menu_name'],
            'slug' => $slug,
            'permission_prefix' => $slug,
            'url' => $validated['url'] ?: $this->defaultUrlForSlug($slug),
            'icon' => $validated['icon'] ?? null,
            'color' => $validated['color'] ?? $module->color,
            'sort_order' => ($module->children()->max('sort_order') ?? 0) + 1,
            'is_active' => $validated['status_aktif'] ?? true,
        ]);

        return response()->json(['message' => 'Menu berhasil dibuat.'], 201);
    }

    public function update(Request $request, Menu $menu): JsonResponse
    {
        $validated = $request->validate([
            'menu_name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'status_aktif' => ['nullable', 'boolean'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $menu->update([
            'name' => $validated['menu_name'],
            'url' => $validated['url'] ?: $this->defaultUrlForSlug($menu->slug),
            'icon' => $validated['icon'] ?? $menu->icon,
            'color' => $validated['color'] ?? $menu->color,
            'is_active' => $validated['status_aktif'] ?? false,
        ]);

        return response()->json(['message' => 'Menu berhasil diperbarui.']);
    }

    public function destroy(Menu $menu): JsonResponse
    {
        $menu->delete();

        return response()->json(['message' => 'Menu berhasil dihapus.']);
    }
}
