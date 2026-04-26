<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    /**
     * Display landing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'contact' => [
                'email' => config('school.email'),
                'phone' => config('school.phone'),
            ],

            'logo' => [
                'initial' => 'MA',
                'name' => 'SMA MA\'ARIF KROYA',
                'tagline' => 'Sistem Informasi Sekolah',
            ],

            'menu' => [
                ['label' => 'Tentang', 'url' => '#tentang'],
                ['label' => 'Portal Akademik', 'url' => '#portal'],
                ['label' => 'Galeri', 'url' => '#galeri'],
                ['label' => 'Berita', 'url' => '#berita'],
                ['label' => 'Kontak', 'url' => '#kontak'],
            ],

            'navCta' => [
                'text' => 'Daftar PPDB',
                'url' => route('ppdb.index'),
            ],

            'hero' => [
                'tag' => '🌿 Terakreditasi A · Cilacap, Jawa Tengah',
                'title' => "Selamat Datang di<br><em>SMA MA'ARIF</em><br>KROYA",
                'subtitle' => 'Membentuk generasi berkarakter, berprestasi, dan berakhlak mulia melalui pendidikan Islam yang modern dan terpadu.',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1800&auto=format&fit=crop&q=80',
                'cta1' => ['text' => 'Masuk Portal Siswa →', 'url' => route('portal.index')],
                'cta2' => ['text' => 'Tentang Sekolah', 'url' => '#tentang'],
            ],

            'stats' => [
                ['icon' => '🎓', 'count' => '1.200+', 'label' => 'Siswa Aktif'],
                ['icon' => '👨‍🏫', 'count' => '85', 'label' => 'Tenaga Pengajar'],
                ['icon' => '🏆', 'count' => '200+', 'label' => 'Prestasi Diraih'],
                ['icon' => '🗓️', 'count' => '1987', 'label' => 'Tahun Berdiri'],
            ],

            'portals' => [
                [
                    'icon' => '📊',
                    'iconBg' => 'rgba(34,197,94,0.15)',
                    'title' => 'Dashboard & Laporan',
                    'description' => 'Pantau KPI sekolah, grafik kehadiran, dan rekap prestasi secara real-time dari satu dashboard terpusat.',
                    'linkText' => 'Buka Dashboard',
                    'link' => '#',
                ],
                [
                    'icon' => '🎓',
                    'iconBg' => 'rgba(59,130,246,0.15)',
                    'title' => 'Penerimaan Siswa Baru',
                    'description' => 'Pendaftaran online 24/7, Computer-Based Testing (CBT), validasi dokumen otomatis, dan pengumuman hasil digital.',
                    'linkText' => 'Daftar Sekarang',
                    'link' => '#',
                ],
                [
                    'icon' => '📚',
                    'iconBg' => 'rgba(139,92,246,0.15)',
                    'title' => 'Akademik & Nilai',
                    'description' => 'Input nilai, generate rapor sesuai format Kemendikbud, absensi per mapel, dan tracking remedial siswa.',
                    'linkText' => 'Lihat Nilai',
                    'link' => '#',
                ],
                [
                    'icon' => '💰',
                    'iconBg' => 'rgba(245,166,35,0.15)',
                    'title' => 'Keuangan & SPP',
                    'description' => 'Cek tagihan SPP, pembayaran online via transfer bank & e-wallet, riwayat pembayaran, dan pengajuan keringanan.',
                    'linkText' => 'Bayar SPP',
                    'link' => '#',
                ],
                [
                    'icon' => '👥',
                    'iconBg' => 'rgba(236,72,153,0.15)',
                    'title' => 'Data Siswa & Kesiswaan',
                    'description' => 'Profil siswa, ekstrakurikuler & OSIS, pencatatan disiplin, bimbingan konseling, dan recording prestasi.',
                    'linkText' => 'Profil Siswa',
                    'link' => '#',
                ],
                [
                    'icon' => '📱',
                    'iconBg' => 'rgba(6,182,212,0.15)',
                    'title' => 'Portal Orang Tua',
                    'description' => 'Monitor nilai, absensi, pembayaran, dan perkembangan anak secara real-time. Komunikasi langsung dengan guru via aplikasi.',
                    'linkText' => 'Masuk Portal',
                    'link' => '#',
                ],
                [
                    'icon' => '👨‍🏫',
                    'iconBg' => 'rgba(249,115,22,0.15)',
                    'title' => 'Kepegawaian',
                    'description' => 'Data guru & staff, jadwal mengajar, absensi, slip gaji digital, dan pengajuan izin/cuti secara online.',
                    'linkText' => 'Portal Guru',
                    'link' => '#',
                ],
                [
                    'icon' => '🏫',
                    'iconBg' => 'rgba(132,204,22,0.15)',
                    'title' => 'Sarana & Prasarana',
                    'description' => 'Booking ruangan, pengajuan maintenance, daftar inventaris aset, dan laporan kondisi fasilitas sekolah.',
                    'linkText' => 'Booking Ruangan',
                    'link' => '#',
                ],
                [
                    'icon' => '🏆',
                    'iconBg' => 'rgba(201,147,42,0.15)',
                    'title' => 'Kelulusan & Alumni',
                    'description' => 'Cek eligibility kelulusan, download ijazah digital ber-QR code, alumni portal, dan career tracking pasca lulus.',
                    'linkText' => 'Portal Alumni',
                    'link' => '#',
                ],
            ],

            'gallery' => [
                ['image' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=700&auto=format&fit=crop&q=80', 'caption' => 'Kegiatan Kelas'],
                ['image' => 'https://images.unsplash.com/photo-1562564055-71e051d33c19?w=600&auto=format&fit=crop&q=80', 'caption' => 'Upacara Bendera'],
                ['image' => 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600&auto=format&fit=crop&q=80', 'caption' => 'Laboratorium IPA'],
                ['image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=600&auto=format&fit=crop&q=80', 'caption' => 'Kegiatan Olahraga'],
                ['image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80', 'caption' => 'Perpustakaan'],
            ],

            'news' => [
                [
                    'image' => 'https://images.unsplash.com/photo-1567168544813-cc03465b4fa8?w=500&auto=format&fit=crop&q=80',
                    'category' => 'Prestasi',
                    'title' => 'Siswa MA\'ARIF Raih Juara 1 Olimpiade Matematika Tingkat Kabupaten Cilacap',
                    'date' => '15 April 2026',
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1529390079861-591de354faf5?w=500&auto=format&fit=crop&q=80',
                    'category' => 'PPDB 2026',
                    'categoryColor' => ['bg' => 'rgba(201,147,42,0.1)', 'text' => 'var(--gold)'],
                    'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2026/2027 Resmi Dibuka',
                    'date' => '1 April 2026',
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=500&auto=format&fit=crop&q=80',
                    'category' => 'Kegiatan',
                    'title' => 'Bakti Sosial Ramadan: Siswa MA\'ARIF Berbagi dengan Masyarakat Sekitar',
                    'date' => '28 Maret 2026',
                ],
            ],

            'cta' => [
                'title' => 'Daftarkan Putra-Putri Anda',
                'description' => 'Pendaftaran siswa baru tahun ajaran 2026/2027 sudah dibuka. Bergabunglah dengan keluarga besar SMA MA\'ARIF KROYA.',
                'ctaText' => 'Daftar Online Sekarang',
                'ctaUrl' => '#',
            ],

            'footer' => [
                'brand' => [
                    'name' => 'SMA MA\'ARIF KROYA',
                    'description' => 'Sekolah Menengah Atas berbasis Islam di bawah naungan LP Ma\'arif NU Kabupaten Cilacap. Berilmu, Beriman, Berprestasi.',
                    'copyright' => '© 2026 SMA MA\'ARIF KROYA. Hak cipta dilindungi.',
                    'address' => 'Jl. Masjid No.1, Kroya, Cilacap, Jawa Tengah · (0282) 494-000',
                ],
                'columns' => [
                    [
                        'title' => 'Portal',
                        'links' => [
                            ['label' => 'Login Siswa', 'url' => '#'],
                            ['label' => 'Login Guru', 'url' => '#'],
                            ['label' => 'Portal Orang Tua', 'url' => '#'],
                            ['label' => 'Portal Alumni', 'url' => '#'],
                        ],
                    ],
                    [
                        'title' => 'Akademik',
                        'links' => [
                            ['label' => 'Jadwal Pelajaran', 'url' => '#'],
                            ['label' => 'Kalender Akademik', 'url' => '#'],
                            ['label' => 'Ekstrakurikuler', 'url' => '#'],
                            ['label' => 'Perpustakaan', 'url' => '#'],
                        ],
                    ],
                    [
                        'title' => 'Info',
                        'links' => [
                            ['label' => 'Tentang Sekolah', 'url' => '#'],
                            ['label' => 'Berita & Pengumuman', 'url' => '#'],
                            ['label' => 'Galeri', 'url' => '#'],
                            ['label' => 'Hubungi Kami', 'url' => '#'],
                        ],
                    ],
                ],
            ],
        ];

        return view('landing', $data);
    }
}
