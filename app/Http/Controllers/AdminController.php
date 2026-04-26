<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        $modules = Menu::query()
            ->whereNull('parent_id')
            ->with(['children.permissionMappings.permission'])
            ->orderBy('sort_order')
            ->get()
            ->map(function (Menu $module) use ($user): array {
                return [
                    'name' => $module->name,
                    'slug' => $module->slug,
                    'icon' => $module->icon,
                    'color' => $module->color,
                    'menus' => $module->children
                        ->map(function (Menu $menu) use ($user): ?array {
                            $allowedMappings = $menu->permissionMappings
                                ->filter(fn ($mapping) => $mapping->permission && $user && $user->can($mapping->permission->name))
                                ->values();

                            if ($allowedMappings->isEmpty()) {
                                return null;
                            }

                            return [
                                'name' => $menu->name,
                                'slug' => $menu->slug,
                                'url' => $menu->url,
                                'permissions' => $allowedMappings
                                    ->mapWithKeys(fn ($mapping) => [$mapping->action_key => true])
                                    ->all(),
                                'permission_list' => $allowedMappings
                                    ->map(fn ($mapping) => [
                                        'key' => $mapping->action_key,
                                        'label' => $mapping->label,
                                        'permission' => $mapping->permission->name,
                                    ])
                                    ->values()
                                    ->all(),
                            ];
                        })
                        ->filter()
                        ->values()
                        ->all(),
                ];
            })
            ->filter(fn (array $module): bool => count($module['menus']) > 0)
            ->values()
            ->all();

        return view('admin.index', [
            'adminRbac' => [
                'user' => [
                    'name' => $user?->name,
                    'roles' => $user?->getRoleNames()->values()->all() ?? [],
                ],
                'modules' => $modules,
            ],
        ]);
    }
}
