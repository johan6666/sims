<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Support\AdminMenuRegistry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuDataSeeder extends Seeder
{
    public function run(): void
    {
        $seedData = [
            'Dashboard & Reporting' => [
                'KPI Dashboard' => [
                    ['metric_name' => 'Tingkat Kehadiran Siswa', 'metric_type' => 'percentage', 'current_value' => '94.5', 'target_value' => '95', 'period' => '2026-04-01'],
                    ['metric_name' => 'Penerimaan SPP', 'metric_type' => 'currency', 'current_value' => '185000000', 'target_value' => '200000000', 'period' => '2026-04-01'],
                    ['metric_name' => 'Siswa Aktif', 'metric_type' => 'integer', 'current_value' => '1247', 'target_value' => '1300', 'period' => '2026-04-01'],
                ],
            ],
            'Penerimaan Siswa' => [
                'Pendaftar Siswa' => [
                    ['nama_lengkap' => 'Ahmad Fauzi', 'email' => 'fauzi@gmail.com', 'no_hp' => '081234567890', 'asal_sekolah' => 'SMP N 1 Kroya', 'tanggal_pendaftaran' => '2026-02-10', 'status_pendaftaran' => 'approved'],
                    ['nama_lengkap' => 'Siti Rahayu', 'email' => 'rahayu@gmail.com', 'no_hp' => '082345678901', 'asal_sekolah' => 'SMP N 2 Kroya', 'tanggal_pendaftaran' => '2026-02-11', 'status_pendaftaran' => 'verified'],
                    ['nama_lengkap' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'no_hp' => '083456789012', 'asal_sekolah' => 'MTs Kroya', 'tanggal_pendaftaran' => '2026-02-12', 'status_pendaftaran' => 'pending'],
                ],
            ],
            'Akademik' => [
                'Kelas' => [
                    ['nama_kelas' => 'X-A', 'tingkat' => 10, 'jurusan' => 'IPA', 'kapasitas' => 36, 'tahun_ajaran' => '2025/2026', 'ruangan' => 'R-101'],
                    ['nama_kelas' => 'X-B', 'tingkat' => 10, 'jurusan' => 'IPA', 'kapasitas' => 36, 'tahun_ajaran' => '2025/2026', 'ruangan' => 'R-102'],
                    ['nama_kelas' => 'XI-A', 'tingkat' => 11, 'jurusan' => 'IPS', 'kapasitas' => 34, 'tahun_ajaran' => '2025/2026', 'ruangan' => 'R-201'],
                ],
            ],
            'Kesiswaan' => [
                'Data Siswa' => [
                    ['nis' => '2026001', 'nisn' => '1234567890', 'nama_lengkap' => 'Ahmad Fauzi', 'class_name' => 'X-A', 'tempat_lahir' => 'Kroya', 'tanggal_lahir' => '2008-05-15', 'jenis_kelamin' => 'laki-laki', 'agama' => 'Islam', 'no_telepon' => '081234567890', 'status' => 'aktif'],
                    ['nis' => '2026002', 'nisn' => '0987654321', 'nama_lengkap' => 'Siti Rahayu', 'class_name' => 'X-B', 'tempat_lahir' => 'Cilacap', 'tanggal_lahir' => '2008-07-22', 'jenis_kelamin' => 'perempuan', 'agama' => 'Islam', 'no_telepon' => '082345678901', 'status' => 'aktif'],
                    ['nis' => '2026003', 'nisn' => '1122334455', 'nama_lengkap' => 'Budi Pratama', 'class_name' => 'XI-A', 'tempat_lahir' => 'Kroya', 'tanggal_lahir' => '2007-11-03', 'jenis_kelamin' => 'laki-laki', 'agama' => 'Islam', 'no_telepon' => '083456789012', 'status' => 'aktif'],
                ],
            ],
            'Kepegawaian' => [
                'Data Guru & Staff' => [
                    ['nip' => '198505122010011001', 'nama_lengkap' => 'Drs. Ahmad Kusuma', 'jenis_kelamin' => 'laki-laki', 'status_kepegawaian' => 'tetap', 'tanggal_bergabung' => '2010-01-12', 'email' => 'ahmad@smamaarif.sch.id'],
                    ['nip' => '199001052015012002', 'nama_lengkap' => 'Siti Nurhaliza, S.Pd', 'jenis_kelamin' => 'perempuan', 'status_kepegawaian' => 'tetap', 'tanggal_bergabung' => '2015-01-05', 'email' => 'siti@smamaarif.sch.id'],
                    ['nip' => '-', 'nama_lengkap' => 'Budi Setiawan, S.Kom', 'jenis_kelamin' => 'laki-laki', 'status_kepegawaian' => 'kontrak', 'tanggal_bergabung' => '2022-07-01', 'email' => 'budi@smamaarif.sch.id'],
                ],
            ],
            'Keuangan & SPP' => [
                'Tagihan SPP' => [
                    ['siswa_id' => '1234567890', 'nominal' => '350000', 'periode_bulan' => 4, 'tahun' => 2026, 'tanggal_jatuh_tempo' => '2026-04-10', 'status_tagihan' => 'lunas'],
                    ['siswa_id' => '0987654321', 'nominal' => '350000', 'periode_bulan' => 4, 'tahun' => 2026, 'tanggal_jatuh_tempo' => '2026-04-10', 'status_tagihan' => 'belum_dibayar'],
                    ['siswa_id' => '1122334455', 'nominal' => '350000', 'periode_bulan' => 3, 'tahun' => 2026, 'tanggal_jatuh_tempo' => '2026-03-10', 'status_tagihan' => 'tunggakan'],
                ],
            ],
            'Humas & Komunikasi' => [
                'Pengumuman' => [
                    ['judul_pengumuman' => 'Pengumuman Ujian Akhir Semester Genap 2025/2026', 'tipe_pengumuman' => 'akademik', 'tanggal_terbit' => '2026-04-15T08:00', 'status_publikasi' => 'published'],
                    ['judul_pengumuman' => 'Pembayaran SPP Bulan April 2026', 'tipe_pengumuman' => 'keuangan', 'tanggal_terbit' => '2026-04-01T07:00', 'status_publikasi' => 'published'],
                    ['judul_pengumuman' => 'Pendaftaran Ekskul Baru TA 2026/2027', 'tipe_pengumuman' => 'umum', 'tanggal_terbit' => '2026-04-20T09:00', 'status_publikasi' => 'draft'],
                ],
            ],
        ];

        foreach ($seedData as $moduleName => $menus) {
            $module = collect(AdminMenuRegistry::modules())->firstWhere('name', $moduleName);

            if (! $module) {
                continue;
            }

            foreach ($menus as $menuName => $rows) {
                $slug = AdminMenuRegistry::menuSlug($module['slug'], $menuName);
                $menu = Menu::query()->where('slug', $slug)->first();

                if (! $menu) {
                    continue;
                }

                $table = AdminMenuRegistry::tableNameForMenuSlug($menu->slug);
                DB::table($table)->truncate();

                foreach ($rows as $row) {
                    DB::table($table)->insert([
                        'payload' => json_encode($row, JSON_UNESCAPED_UNICODE),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
