<?php

namespace Database\Seeders;

use App\Models\RoleProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        DB::table('role_has_permissions')->delete();

        $superAdminRole = Role::findOrCreate('super_admin', 'web');
        $adminRole = Role::findOrCreate('admin', 'web');
        $guruRole = Role::findOrCreate('guru', 'web');
        $siswaRole = Role::findOrCreate('siswa', 'web');
        $staffRole = Role::findOrCreate('staff', 'web');

        $allPermissions = Permission::query()->pluck('name')->all();
        $superAdminRole->syncPermissions($allPermissions);
        $adminRole->syncPermissions($allPermissions);

        $guruRole->syncPermissions($this->permissionsByPrefix([
            'dashboard-reporting.',
            'akademik.',
            'kesiswaan.',
            'kepegawaian.absensi-guru.',
            'kepegawaian.penugasan-guru.list',
            'kepegawaian.penugasan-guru.detail',
            'humas-komunikasi.pengumuman.',
            'humas-komunikasi.event-sekolah.',
            'kelulusan-alumni.eligibility-kelulusan.',
        ]));

        $siswaRole->syncPermissions($this->permissionsByPrefix([
            'akademik.rapor-siswa.list',
            'akademik.rapor-siswa.detail',
            'akademik.absensi-siswa.list',
            'akademik.absensi-siswa.detail',
            'keuangan-spp.tagihan-spp.list',
            'keuangan-spp.tagihan-spp.detail',
            'kelulusan-alumni.ijazah.list',
            'kelulusan-alumni.ijazah.detail',
        ], false));

        $staffRole->syncPermissions($this->permissionsByPrefix([
            'penerimaan-siswa.',
            'keuangan-spp.',
            'sarana-prasarana.',
        ]));

        $this->syncRoleProfile($superAdminRole->id, 'Akses penuh ke seluruh sistem.', 'super_admin');
        $this->syncRoleProfile($adminRole->id, 'Administrator operasional utama.', 'admin');
        $this->syncRoleProfile($guruRole->id, 'Role pengajar untuk modul akademik dan kesiswaan.', 'guru');
        $this->syncRoleProfile($siswaRole->id, 'Role portal siswa dan akses informasi pribadi.', 'siswa');
        $this->syncRoleProfile($staffRole->id, 'Role staff administrasi dan operasional.', 'staff');

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@smamaarifkroya.sch.id'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'nip_nis' => 'ADM-001',
                'phone' => '(0282) 494-000',
                'is_active' => true,
            ]
        );
        $adminUser->syncRoles([$adminRole]);

        $guruUser = User::updateOrCreate(
            ['email' => 'guru@smamaarifkroya.sch.id'],
            [
                'name' => 'Guru',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'nip_nis' => '198001012010011001',
                'phone' => '(0282) 494-001',
                'is_active' => true,
            ]
        );
        $guruUser->syncRoles([$guruRole]);

        $siswaUser = User::updateOrCreate(
            ['email' => 'siswa@smamaarifkroya.sch.id'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'nip_nis' => '1234567890',
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
        $siswaUser->syncRoles([$siswaRole]);

        User::updateOrCreate(
            ['email' => 'superadmin@smamaarifkroya.sch.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'nip_nis' => 'SUPER-001',
                'phone' => '(0282) 494-999',
                'is_active' => true,
            ]
        )->syncRoles([$superAdminRole]);

        User::updateOrCreate(
            ['email' => 'staff@smamaarifkroya.sch.id'],
            [
                'name' => 'Staff Operasional',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'nip_nis' => 'STF-001',
                'phone' => '(0282) 494-002',
                'is_active' => true,
            ]
        )->syncRoles([$staffRole]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * @param  array<int, string>  $prefixes
     * @return array<int, string>
     */
    private function permissionsByPrefix(array $prefixes, bool $useWildcard = true): array
    {
        return Permission::query()
            ->pluck('name')
            ->filter(function (string $permission) use ($prefixes, $useWildcard): bool {
                foreach ($prefixes as $prefix) {
                    if ($useWildcard && str_starts_with($permission, $prefix)) {
                        return true;
                    }

                    if (! $useWildcard && $permission === $prefix) {
                        return true;
                    }
                }

                return false;
            })
            ->values()
            ->all();
    }

    private function syncRoleProfile(int $roleId, string $description, string $category): void
    {
        RoleProfile::updateOrCreate(
            ['role_id' => $roleId],
            [
                'description' => $description,
                'category' => $category,
            ]
        );
    }
}
