<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    /**
     * Display student portal with dummy data.
     */
    public function index()
    {
        $data = [
            'siswa' => [
                'nama'       => 'Ahmad Fauzi',
                'nisn'       => '1234567890',
                'kelas'      => 'X-A IPA',
                'wali_kelas' => 'Drs. Ahmad Kusuma',
                'ta'         => '2025/2026',
            ],

            'nilai' => [
                ['mapel' => 'Matematika',         'uh1' => 82, 'uh2' => 85, 'uts' => 80, 'uas' => 88, 'akhir' => 84.5, 'predikat' => 'B'],
                ['mapel' => 'Bahasa Indonesia',   'uh1' => 90, 'uh2' => 88, 'uts' => 85, 'uas' => 92, 'akhir' => 89.5, 'predikat' => 'A'],
                ['mapel' => 'Bahasa Inggris',     'uh1' => 78, 'uh2' => 82, 'uts' => 80, 'uas' => 84, 'akhir' => 81.0, 'predikat' => 'B'],
                ['mapel' => 'Fisika',             'uh1' => 75, 'uh2' => 78, 'uts' => 72, 'uas' => 80, 'akhir' => 76.5, 'predikat' => 'C'],
                ['mapel' => 'Kimia',              'uh1' => 80, 'uh2' => 83, 'uts' => 78, 'uas' => 85, 'akhir' => 81.5, 'predikat' => 'B'],
                ['mapel' => 'Biologi',            'uh1' => 88, 'uh2' => 85, 'uts' => 84, 'uas' => 90, 'akhir' => 86.8, 'predikat' => 'A'],
                ['mapel' => 'Pendidikan Agama',   'uh1' => 92, 'uh2' => 94, 'uts' => 90, 'uas' => 95, 'akhir' => 92.5, 'predikat' => 'A'],
            ],

            'absensi' => [
                ['bulan' => 'Januari 2026',  'hadir' => 22, 'sakit' => 0, 'izin' => 0, 'bolos' => 0, 'total' => 22],
                ['bulan' => 'Februari 2026', 'hadir' => 19, 'sakit' => 1, 'izin' => 0, 'bolos' => 0, 'total' => 20],
                ['bulan' => 'Maret 2026',    'hadir' => 20, 'sakit' => 0, 'izin' => 1, 'bolos' => 0, 'total' => 21],
                ['bulan' => 'April 2026',    'hadir' => 16, 'sakit' => 0, 'izin' => 0, 'bolos' => 0, 'total' => 16],
            ],

            'tagihan' => [
                ['bulan' => 'Januari 2026',  'nominal' => 350000, 'status' => 'lunas',        'tanggal_bayar' => '2026-01-08'],
                ['bulan' => 'Februari 2026', 'nominal' => 350000, 'status' => 'lunas',        'tanggal_bayar' => '2026-02-05'],
                ['bulan' => 'Maret 2026',    'nominal' => 350000, 'status' => 'lunas',        'tanggal_bayar' => '2026-03-07'],
                ['bulan' => 'April 2026',    'nominal' => 350000, 'status' => 'belum_dibayar','tanggal_bayar' => null],
            ],

            'profil' => [
                ['label' => 'Nama Lengkap',       'value' => 'Ahmad Fauzi'],
                ['label' => 'NISN',               'value' => '1234567890'],
                ['label' => 'Tempat, Tgl Lahir',  'value' => 'Kroya, 15 Mei 2010'],
                ['label' => 'Jenis Kelamin',      'value' => 'Laki-laki'],
                ['label' => 'Agama',              'value' => 'Islam'],
                ['label' => 'Kelas',              'value' => 'X-A IPA'],
                ['label' => 'Wali Kelas',         'value' => 'Drs. Ahmad Kusuma'],
                ['label' => 'Tahun Ajaran',       'value' => '2025/2026'],
                ['label' => 'Nama Ayah',          'value' => 'Bapak Fauzi'],
                ['label' => 'No. HP Ayah',        'value' => '081298765432'],
            ],
        ];

        return view('portal.index', $data);
    }
}
