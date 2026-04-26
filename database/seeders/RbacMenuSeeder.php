<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuPermission;
use App\Support\AdminMenuRegistry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RbacMenuSeeder extends Seeder
{
    /**
     * @var array<int, array{key:string,label:string}>
     */
    private array $defaultActions = [
        ['key' => 'list', 'label' => 'List'],
        ['key' => 'detail', 'label' => 'Detail'],
        ['key' => 'create', 'label' => 'Create'],
        ['key' => 'update', 'label' => 'Update'],
        ['key' => 'delete', 'label' => 'Delete'],
    ];

    /**
     * Seed current hardcoded admin menus into the RBAC tables.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $menuTree = AdminMenuRegistry::modules();
        $customActions = AdminMenuRegistry::customActions();

        foreach ($menuTree as $moduleIndex => $moduleData) {
            $module = Menu::updateOrCreate(
                ['slug' => $moduleData['slug']],
                [
                    'parent_id' => null,
                    'name' => $moduleData['name'],
                    'permission_prefix' => $moduleData['slug'],
                    'icon' => $moduleData['icon'],
                    'color' => $moduleData['color'],
                    'url' => null,
                    'description' => 'Modul utama admin panel.',
                    'sort_order' => $moduleIndex + 1,
                    'is_active' => true,
                ]
            );

            $validMenuSlugs = collect($moduleData['menus'])
                ->map(fn (string $menuName): string => AdminMenuRegistry::menuSlug($moduleData['slug'], $menuName));

            $this->deleteStaleMenus($module, $validMenuSlugs);

            foreach ($moduleData['menus'] as $menuIndex => $menuName) {
                $menuSlug = AdminMenuRegistry::menuSlug($moduleData['slug'], $menuName);

                $menu = Menu::updateOrCreate(
                    ['slug' => $menuSlug],
                    [
                        'parent_id' => $module->id,
                        'name' => $menuName,
                        'permission_prefix' => $menuSlug,
                        'icon' => null,
                        'color' => $moduleData['color'],
                        'url' => '/admin?menu='.$menuSlug,
                        'description' => 'Menu admin hasil import dari schema hardcode.',
                        'sort_order' => $menuIndex + 1,
                        'is_active' => true,
                    ]
                );

                $actions = array_merge(
                    $this->defaultActions,
                    $customActions[$menuName] ?? []
                );

                foreach ($actions as $actionIndex => $action) {
                    $permission = Permission::findOrCreate(
                        $menu->permission_prefix.'.'.$action['key'],
                        'web'
                    );

                    MenuPermission::updateOrCreate(
                        ['permission_id' => $permission->id],
                        [
                            'menu_id' => $menu->id,
                            'action_key' => $action['key'],
                            'label' => $action['label'],
                            'is_default' => $actionIndex < count($this->defaultActions),
                            'sort_order' => $actionIndex + 1,
                        ]
                    );
                }
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function deleteStaleMenus(Menu $module, Collection $validMenuSlugs): void
    {
        Menu::query()
            ->where('parent_id', $module->id)
            ->whereNotIn('slug', $validMenuSlugs->all())
            ->get()
            ->each(function (Menu $menu): void {
                $permissionIds = $menu->permissionMappings()->pluck('permission_id');

                if ($permissionIds->isNotEmpty()) {
                    Permission::query()->whereIn('id', $permissionIds)->delete();
                }

                $menu->delete();
            });
    }
}
