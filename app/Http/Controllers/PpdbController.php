<?php

namespace App\Http\Controllers;

use App\Models\PpdbPendaftar;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index()
    {
        $data = [
            'periode' => [
                'tahun_ajaran'        => '2026/2027',
                'pendaftaran_mulai'   => '1 Maret 2026',
                'pendaftaran_selesai' => '30 April 2026',
                'tes_cbt_mulai'       => '5 Mei 2026',
                'tes_cbt_selesai'     => '10 Mei 2026',
                'pengumuman'          => '15 Mei 2026',
            ],

            'steps' => [
                ['number' => '01', 'icon' => '📝', 'title' => 'Isi Formulir',   'description' => 'Lengkapi data diri dan dokumen pendukung secara online'],
                ['number' => '02', 'icon' => '💻', 'title' => 'Tes Seleksi',    'description' => 'Ikuti Computer-Based Testing (CBT) sesuai jadwal yang ditentukan'],
                ['number' => '03', 'icon' => '📢', 'title' => 'Pengumuman',     'description' => 'Cek hasil seleksi secara online menggunakan nomor pendaftaran'],
                ['number' => '04', 'icon' => '✅', 'title' => 'Daftar Ulang',   'description' => 'Lakukan daftar ulang dan lengkapi administrasi sekolah'],
            ],

            'persyaratan' => [
                'Ijazah SMP/MTs (fotocopy dilegalisir)',
                'SKHUN SMP/MTs (fotocopy dilegalisir)',
                'Kartu Keluarga (fotocopy)',
                'Akta Kelahiran (fotocopy)',
                'Pas Foto 3x4 (4 lembar background merah)',
                'Surat Keterangan Sehat dari Dokter',
                'Rapor SMP/MTs Kelas 7-9 (fotocopy)',
            ],

            'biaya' => [
                'Formulir Pendaftaran'          => 'Gratis',
                'Tes Seleksi'                   => 'Gratis',
                'Uang Gedung (jika diterima)'   => 'Rp 3.500.000',
                'SPP per Bulan'                 => 'Rp 350.000',
                'Seragam & Buku (perkiraan)'    => 'Rp 2.000.000',
            ],
        ];

        return view('ppdb.index', $data);
    }

    public function daftar()
    {
        return view('ppdb.daftar');
    }

    public function storeDaftar(Request $request)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:100',
            'email'           => 'required|email',
            'no_hp'           => 'required|string|max:15',
            'tanggal_lahir'   => 'required|date',
            'tempat_lahir'    => 'required|string|max:50',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'alamat'          => 'required|string',
            'asal_sekolah'    => 'required|string|max:100',
            'pilihan_jurusan' => 'required|in:IPA,IPS',
            'nama_ayah'       => 'required|string|max:100',
            'no_hp_ayah'      => 'required|string|max:15',
            'alasan'          => 'required|string',
        ]);

        $latest = PpdbPendaftar::query()->count() + 1;
        $noPendaftaran = 'PPDB-2026-' . str_pad((string) $latest, 3, '0', STR_PAD_LEFT);

        PpdbPendaftar::create([
            'no_pendaftaran'   => $noPendaftaran,
            'nama_lengkap'     => $request->nama_lengkap,
            'email'            => $request->email,
            'no_hp'            => $request->no_hp,
            'asal_sekolah'     => $request->asal_sekolah,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'pilihan_jurusan'  => $request->pilihan_jurusan,
            'nama_ayah'        => $request->nama_ayah,
            'no_hp_ayah'       => $request->no_hp_ayah,
            'status'           => 'pending',
            'tanggal_daftar'   => now(),
        ]);

        return redirect()->route('ppdb.cek')
            ->with('success', 'Pendaftaran berhasil!')
            ->with('no_pendaftaran', $noPendaftaran)
            ->with('email_daftar', $request->email);
    }

    public function cek()
    {
        return view('ppdb.cek');
    }
}
