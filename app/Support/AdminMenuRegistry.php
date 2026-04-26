<?php

namespace App\Support;

use Illuminate\Support\Str;

class AdminMenuRegistry
{
    /**
     * @return array<int, array{name:string,slug:string,icon:string,color:string,menus:array<int,string>}>
     */
    public static function modules(): array
    {
        return [
            [
                'name' => 'Dashboard & Reporting',
                'slug' => 'dashboard-reporting',
                'icon' => '📊',
                'color' => '#059669',
                'menus' => ['KPI Dashboard', 'Custom Reports'],
            ],
            [
                'name' => 'Penerimaan Siswa',
                'slug' => 'penerimaan-siswa',
                'icon' => '🎓',
                'color' => '#2563EB',
                'menus' => ['Pendaftar Siswa', 'Tes Masuk', 'Daftar Ulang', 'ID Card & NISN'],
            ],
            [
                'name' => 'Akademik',
                'slug' => 'akademik',
                'icon' => '📚',
                'color' => '#7C3AED',
                'menus' => ['Kelas', 'Mata Pelajaran', 'Nilai Siswa', 'Rapor Siswa', 'Absensi Siswa'],
            ],
            [
                'name' => 'Keuangan & SPP',
                'slug' => 'keuangan-spp',
                'icon' => '💰',
                'color' => '#D97706',
                'menus' => ['Komposisi Biaya', 'Tagihan SPP', 'Pembayaran SPP', 'Bank Reconciliation', 'Laporan Keuangan'],
            ],
            [
                'name' => 'Kesiswaan',
                'slug' => 'kesiswaan',
                'icon' => '👥',
                'color' => '#16A34A',
                'menus' => ['Data Siswa', 'Ekstrakurikuler', 'Pelanggaran', 'Bimbingan Konseling', 'Prestasi Siswa'],
            ],
            [
                'name' => 'Kepegawaian',
                'slug' => 'kepegawaian',
                'icon' => '🧑‍🏫',
                'color' => '#DB2777',
                'menus' => ['Data Guru & Staff', 'Penugasan Guru', 'Absensi Guru', 'Penggajian', 'Pelatihan Guru', 'Penilaian Kinerja'],
            ],
            [
                'name' => 'Sarana & Prasarana',
                'slug' => 'sarana-prasarana',
                'icon' => '🏫',
                'color' => '#0891B2',
                'menus' => ['Ruangan', 'Inventaris Aset', 'Maintenance', 'Keamanan & Akses'],
            ],
            [
                'name' => 'Humas & Komunikasi',
                'slug' => 'humas-komunikasi',
                'icon' => '📢',
                'color' => '#EA580C',
                'menus' => ['Pengumuman', 'Event Sekolah', 'Media & Galeri', 'Komunikasi Ortu'],
            ],
            [
                'name' => 'Kelulusan & Alumni',
                'slug' => 'kelulusan-alumni',
                'icon' => '🏆',
                'color' => '#65A30D',
                'menus' => ['Eligibility Kelulusan', 'Ijazah', 'Data Alumni', 'Event Alumni'],
            ],
            [
                'name' => 'Sistem & Pengaturan',
                'slug' => 'sistem-pengaturan',
                'icon' => '⚙️',
                'color' => '#6B7280',
                'menus' => ['Tahun', 'Konfigurasi Sekolah', 'User Management', 'Role & Permission', 'Menu Management', 'Permission Management', 'Audit Trail', 'Backup & Recovery'],
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function leafMenuSlugs(): array
    {
        $slugs = [];

        foreach (self::modules() as $module) {
            foreach ($module['menus'] as $menuName) {
                $slugs[] = self::menuSlug($module['slug'], $menuName);
            }
        }

        return $slugs;
    }

    public static function menuSlug(string $moduleSlug, string $menuName): string
    {
        return $moduleSlug.'.'.Str::slug($menuName);
    }

    public static function tableNameForMenuSlug(string $menuSlug): string
    {
        return 'menu_data_'.str_replace(['.', '-'], '_', $menuSlug);
    }

    /**
     * @return array<string, array<int, array{key:string,label:string}>>
     */
    public static function customActions(): array
    {
        return [
            'Custom Reports' => [
                ['key' => 'export', 'label' => 'Export Report'],
                ['key' => 'schedule', 'label' => 'Schedule Report'],
            ],
            'Pendaftar Siswa' => [
                ['key' => 'verify', 'label' => 'Verify Applicant'],
                ['key' => 'approve', 'label' => 'Approve Applicant'],
            ],
            'Tes Masuk' => [
                ['key' => 'schedule', 'label' => 'Schedule Test'],
                ['key' => 'score', 'label' => 'Score Test'],
            ],
            'Rapor Siswa' => [
                ['key' => 'publish', 'label' => 'Publish Report Card'],
                ['key' => 'print', 'label' => 'Print Report Card'],
            ],
            'Pembayaran SPP' => [
                ['key' => 'verify', 'label' => 'Verify Payment'],
                ['key' => 'print-receipt', 'label' => 'Print Receipt'],
            ],
            'Prestasi Siswa' => [
                ['key' => 'approve', 'label' => 'Approve Achievement'],
            ],
            'Penggajian' => [
                ['key' => 'process', 'label' => 'Process Payroll'],
                ['key' => 'export-slip', 'label' => 'Export Salary Slip'],
            ],
            'Maintenance' => [
                ['key' => 'assign-technician', 'label' => 'Assign Technician'],
            ],
            'Pengumuman' => [
                ['key' => 'publish', 'label' => 'Publish Announcement'],
            ],
            'Media & Galeri' => [
                ['key' => 'publish', 'label' => 'Publish Media'],
            ],
            'Ijazah' => [
                ['key' => 'generate', 'label' => 'Generate Certificate'],
                ['key' => 'print', 'label' => 'Print Certificate'],
            ],
            'User Management' => [
                ['key' => 'assign-role', 'label' => 'Assign Role'],
                ['key' => 'reset-password', 'label' => 'Reset Password'],
            ],
            'Role & Permission' => [
                ['key' => 'assign-permission', 'label' => 'Assign Permission'],
                ['key' => 'sync-menu', 'label' => 'Sync Menu Permission'],
            ],
            'Menu Management' => [
                ['key' => 'sync-schema', 'label' => 'Sync Schema'],
            ],
            'Permission Management' => [
                ['key' => 'assign-menu', 'label' => 'Assign Menu'],
            ],
            'Audit Trail' => [
                ['key' => 'export', 'label' => 'Export Audit Log'],
            ],
            'Backup & Recovery' => [
                ['key' => 'restore', 'label' => 'Restore Backup'],
                ['key' => 'download', 'label' => 'Download Backup'],
            ],
        ];
    }
}
