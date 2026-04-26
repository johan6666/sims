# SMA MA'ARIF KROYA - HTML to Laravel Conversion
## 3-Phase Implementation Guide untuk Claude Sonnet CLI

---

# 📋 PROJECT CONTEXT

**Project Name**: SMA MA'ARIF KROYA - Sistem Informasi Sekolah  
**Tech Stack**: Laravel 11, Blade, MySQL, Vite  
**Design Source**: Complete HTML landing page (attached)  
**Developer**: Solo developer (Ark)  
**Timeline**: 3 phases sequential execution

**Color Scheme**:
- Primary Green: `#1B6B3A`
- Secondary Green: `#22854A`
- Accent Gold: `#C9932A`
- Gold 2: `#E5A830`
- Navy: `#0F1F14`
- Cream BG: `#F8F5EF`

**Fonts**:
- Headings: `Syne` (Google Fonts - weights: 400,600,700,800)
- Body: `Plus Jakarta Sans` (Google Fonts - weights: 300,400,500,600,700)

---

# 🎯 OVERALL OBJECTIVE

Convert complete HTML landing page menjadi Laravel 11 application dengan:
1. ✅ Proper Blade templating & component structure
2. ✅ Asset management (CSS/JS extracted & organized)
3. ✅ Data-driven content (no hardcoded values)
4. ✅ Foundation untuk 8 modul portal
5. ✅ Production-ready code quality

---

# 📂 TARGET DIRECTORY STRUCTURE

```
sma-maarif-kroya/
├── app/
│   └── Http/
│       └── Controllers/
│           └── LandingController.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── components/
│       │   ├── topbar.blade.php
│       │   ├── nav.blade.php
│       │   ├── hero.blade.php
│       │   ├── stats-bar.blade.php
│       │   ├── portal-card.blade.php
│       │   ├── gallery-item.blade.php
│       │   ├── news-card.blade.php
│       │   ├── cta-band.blade.php
│       │   └── footer.blade.php
│       └── landing.blade.php
├── public/
│   ├── css/
│   │   └── landing.css
│   ├── js/
│   │   └── landing.js
│   └── images/
│       ├── hero/
│       ├── gallery/
│       └── news/
└── routes/
    └── web.php
```

---

---

# 🔹 PHASE 1: STRUCTURE & LAYOUT FOUNDATION

## Phase 1 Objectives
- Setup master layout dengan proper HTML structure
- Extract CSS ke external file
- Extract JavaScript ke external file
- Create basic controller & route
- Setup landing page dengan layout extending

## Phase 1 Tasks

### Task 1.1: Master Layout (`resources/views/layouts/app.blade.php`)

**Requirements**:
- Complete HTML5 boilerplate dengan proper meta tags
- Link Google Fonts (Syne & Plus Jakarta Sans)
- Link external CSS file
- Setup @yield directives
- Setup @stack directives untuk additional CSS/JS
- Include external JS file di bottom

**Key Points**:
- Meta viewport untuk responsive
- Meta charset UTF-8
- Title dynamic dengan @yield('title', 'Default Title')
- CSS variables di :root tetap di layout (jangan pindah ke external CSS)
- @yield('content') untuk main content
- @stack('styles') sebelum </head>
- @stack('scripts') sebelum </body>

**Code Structure**:
```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMA MA\'ARIF KROYA — Sistem Informasi Sekolah')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    
    @stack('styles')
</head>
<body>
    <style>
        :root {
            --green: #1B6B3A;
            --green2: #22854A;
            --green-light: #2DAF60;
            --gold: #C9932A;
            --gold2: #E5A830;
            --navy: #0F1F14;
            --cream: #F8F5EF;
            --white: #FFFFFF;
            --text: #1A2E1F;
            --muted: #6B7E70;
            --border: rgba(27,107,58,0.15);
        }
    </style>

    @yield('content')

    <!-- Main JS -->
    <script src="{{ asset('js/landing.js') }}"></script>
    @stack('scripts')
</body>
</html>
```

### Task 1.2: Extract CSS (`public/css/landing.css`)

**Requirements**:
- Extract SEMUA CSS dari HTML kecuali :root variables
- Maintain exact styling, jangan ubah satupun
- Organize dengan comment sections
- Clean formatting, indented properly

**Sections to extract** (baris 24-681 dari HTML):
1. Base resets & typography
2. Topbar styles
3. Nav styles
4. Hero section
5. Stats bar
6. About section
7. Features grid
8. Portal cards
9. Gallery grid
10. News grid
11. CTA band
12. Footer
13. Animations (@keyframes)
14. Responsive media queries (jika ada)

### Task 1.3: Extract JavaScript (`public/js/landing.js`)

**Requirements**:
- Extract Intersection Observer logic
- Extract tweaks panel logic
- Clean, readable code dengan comment
- Remove inline script tags

**Code to extract** (baris 845-900):
```javascript
// Scroll reveal dengan Intersection Observer
// Tweaks panel untuk color customization
// PostMessage handlers
```

### Task 1.4: Landing Controller (`app/Http/Controllers/LandingController.php`)

**Requirements**:
- Simple controller dengan 1 method: `index()`
- Return view dengan empty data array (phase 2 akan populate)
- Follow Laravel naming conventions
- Add docblock comments

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display landing page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            // Phase 2: akan diisi dengan data stats, portals, gallery, news
        ];
        
        return view('landing', $data);
    }
}
```

### Task 1.5: Landing Page View (`resources/views/landing.blade.php`)

**Requirements**:
- Extend master layout: `@extends('layouts.app')`
- Set title: `@section('title', 'Beranda - SMA MA\'ARIF KROYA')`
- Wrap HTML body content dalam `@section('content')`
- Keep semua HTML structure intact untuk sementara (phase 2 akan componentize)

```blade
@extends('layouts.app')

@section('title', 'Beranda - SMA MA\'ARIF KROYA')

@section('content')
<!-- Copy ENTIRE body content dari HTML di sini -->
<!-- Baris 35-843 dari original HTML -->
@endsection
```

### Task 1.6: Routes (`routes/web.php`)

**Requirements**:
- Clean, simple route definition
- Use controller class import
- Named route untuk SEO-friendly URLs

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
```

## Phase 1 Validation Checklist

Sebelum proceed ke Phase 2, pastikan:
- ✅ `php artisan serve` running tanpa error
- ✅ Landing page tampil identical dengan HTML original
- ✅ CSS loaded correctly (inspect network tab)
- ✅ JS loaded correctly (scroll reveal animation works)
- ✅ No console errors di browser
- ✅ Responsive design maintained
- ✅ All images from Unsplash loaded (belum diganti local)

## Phase 1 Deliverables

1. `resources/views/layouts/app.blade.php` - COMPLETE CODE
2. `resources/views/landing.blade.php` - COMPLETE CODE
3. `public/css/landing.css` - COMPLETE CODE
4. `public/js/landing.js` - COMPLETE CODE
5. `app/Http/Controllers/LandingController.php` - COMPLETE CODE
6. `routes/web.php` - COMPLETE CODE

**CRITICAL**: Provide FULL CODE for each file, NO placeholders, NO "... rest of code here ...".

---

---

# 🔹 PHASE 2: COMPONENTIZATION & DATA BINDING

## Phase 2 Objectives
- Break down monolithic landing.blade.php into reusable Blade components
- Implement data binding untuk dynamic content
- Populate controller dengan structured data
- Replace hardcoded values dengan variables

## Phase 2 Tasks

### Task 2.1: Topbar Component (`resources/views/components/topbar.blade.php`)

**HTML Source**: Baris 36-45 dari original HTML

**Requirements**:
- Accept props: `$email`, `$phone`
- Blade directive untuk email/phone display
- Maintain exact styling classes

```blade
<!-- Topbar: Contact info bar di paling atas -->
<div class="topbar">
    <span>
        ✉️ {{ $email }}
    </span>
    <span>
        📞 {{ $phone }}
    </span>
</div>
```

**Usage di landing.blade.php**:
```blade
<x-topbar :email="$contact['email']" :phone="$contact['phone']" />
```

### Task 2.2: Navbar Component (`resources/views/components/nav.blade.php`)

**HTML Source**: Baris 48-105

**Requirements**:
- Accept props: `$logoText`, `$menuItems` (array), `$ctaText`, `$ctaLink`
- Dynamic menu generation dengan @foreach
- Logo emblem dengan initial dinamis
- Active state handling (opsional untuk phase ini)

```blade
<nav>
    <div class="nav-logo">
        <div class="logo-emblem">{{ $logoText['initial'] }}</div>
        <div class="logo-text">
            <strong>{{ $logoText['name'] }}</strong>
            <small>{{ $logoText['tagline'] }}</small>
        </div>
    </div>
    
    <ul class="nav-links">
        @foreach($menuItems as $item)
        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
        @endforeach
    </ul>
    
    <a href="{{ $ctaLink }}" class="nav-cta">{{ $ctaText }}</a>
</nav>
```

### Task 2.3: Hero Component (`resources/views/components/hero.blade.php`)

**HTML Source**: Baris 108-195

**Requirements**:
- Props: `$tag`, `$title`, `$titleAccent`, `$subtitle`, `$heroImage`, `$cta1`, `$cta2`
- Dynamic title dengan accent word highlighted
- Background image dari prop

```blade
<div class="hero">
    <img src="{{ $heroImage }}" alt="Hero" class="hero-img">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <span class="hero-tag">{{ $tag }}</span>
        <h1>{!! $title !!}</h1>
        <p>{{ $subtitle }}</p>
        <div class="hero-actions">
            <a href="{{ $cta1['url'] }}" class="btn-gold">{{ $cta1['text'] }}</a>
            <a href="{{ $cta2['url'] }}" class="btn-ghost">{{ $cta2['text'] }}</a>
        </div>
    </div>
</div>
```

### Task 2.4: Stats Bar Component (`resources/views/components/stats-bar.blade.php`)

**HTML Source**: Baris 197-226

**Requirements**:
- Props: `$stats` (array of objects)
- Each stat: icon, count, label
- 4 columns grid layout

```blade
<div class="stats-bar">
    @foreach($stats as $stat)
    <div class="stat-item">
        <div class="stat-icon">{{ $stat['icon'] }}</div>
        <div class="stat-info">
            <strong>{{ $stat['count'] }}</strong>
            <span>{{ $stat['label'] }}</span>
        </div>
    </div>
    @endforeach
</div>
```

### Task 2.5: Portal Card Component (`resources/views/components/portal-card.blade.php`)

**HTML Source**: Baris 665-726 (repeating cards)

**Requirements**:
- Props: `$icon`, `$title`, `$description`, `$link`, `$iconBg`
- Reusable untuk 8 modul portal

```blade
<div class="portal-card fade-in">
    <div class="portal-card-icon" style="background:{{ $iconBg }};">{{ $icon }}</div>
    <h3>{{ $title }}</h3>
    <p>{{ $description }}</p>
    <a href="{{ $link }}" class="card-link">{{ $linkText }} →</a>
</div>
```

### Task 2.6: Gallery Item Component (`resources/views/components/gallery-item.blade.php`)

**HTML Source**: Baris 738-757

**Requirements**:
- Props: `$image`, `$caption`
- Hover overlay effect

```blade
<div class="gallery-item">
    <img src="{{ $image }}" alt="{{ $caption }}">
    <div class="overlay"><span>{{ $caption }}</span></div>
</div>
```

### Task 2.7: News Card Component (`resources/views/components/news-card.blade.php`)

**HTML Source**: Baris 769-793

**Requirements**:
- Props: `$image`, `$category`, `$title`, `$date`, `$categoryColor` (opsional)

```blade
<div class="news-card fade-in">
    <img class="news-img" src="{{ $image }}" alt="{{ $title }}">
    <div class="news-body">
        <span class="news-cat" @if(isset($categoryColor)) style="background:{{ $categoryColor['bg'] }};color:{{ $categoryColor['text'] }};" @endif>
            {{ $category }}
        </span>
        <div class="news-title">{{ $title }}</div>
        <div class="news-date">{{ $date }}</div>
    </div>
</div>
```

### Task 2.8: CTA Band Component (`resources/views/components/cta-band.blade.php`)

**HTML Source**: Baris 798-802

**Requirements**:
- Props: `$title`, `$description`, `$ctaText`, `$ctaUrl`

```blade
<div class="cta-band" id="kontak">
    <h2>{{ $title }}</h2>
    <p>{{ $description }}</p>
    <a href="{{ $ctaUrl }}" class="btn-white">{{ $ctaText }} →</a>
</div>
```

### Task 2.9: Footer Component (`resources/views/components/footer.blade.php`)

**HTML Source**: Baris 805-843

**Requirements**:
- Props: `$brand`, `$columns` (array of menu sections)
- Dynamic column generation
- Footer bottom info

```blade
<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <div class="f-logo">{{ $brand['name'] }}</div>
            <p>{{ $brand['description'] }}</p>
        </div>
        
        @foreach($columns as $column)
        <div class="footer-col">
            <h5>{{ $column['title'] }}</h5>
            <ul>
                @foreach($column['links'] as $link)
                <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
    
    <div class="footer-bottom">
        <span>{{ $brand['copyright'] }}</span>
        <span>{{ $brand['address'] }}</span>
    </div>
</footer>
```

### Task 2.10: Update Landing Controller dengan Data

**File**: `app/Http/Controllers/LandingController.php`

**Requirements**:
- Structured data arrays untuk semua components
- Real data dari HTML original
- Organized, readable format

```php
public function index()
{
    $data = [
        'contact' => [
            'email' => 'info@smamaarifkroya.sch.id',
            'phone' => '(0282) 494-000'
        ],
        
        'logo' => [
            'initial' => 'SM',
            'name' => 'SMA MA\'ARIF KROYA',
            'tagline' => 'SISTEM INFORMASI SEKOLAH'
        ],
        
        'menu' => [
            ['label' => 'Beranda', 'url' => route('landing')],
            ['label' => 'Tentang', 'url' => '#tentang'],
            ['label' => 'Portal', 'url' => '#portal'],
            ['label' => 'Galeri', 'url' => '#galeri'],
            ['label' => 'Berita', 'url' => '#berita'],
            ['label' => 'Kontak', 'url' => '#kontak']
        ],
        
        'navCta' => [
            'text' => 'Daftar PPDB',
            'url' => '#'
        ],
        
        'hero' => [
            'tag' => '🎓 TERAKREDITASI A',
            'title' => 'Membangun Generasi <em>Berilmu, Beriman, dan Berprestasi</em>',
            'subtitle' => 'Sistem Informasi Sekolah terintegrasi untuk siswa, guru, dan orang tua. Akses nilai, absensi, pembayaran SPP, dan informasi akademik secara real-time.',
            'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1400&auto=format&fit=crop&q=80',
            'cta1' => ['text' => 'Masuk Portal Siswa', 'url' => '#'],
            'cta2' => ['text' => 'Lihat Panduan', 'url' => '#']
        ],
        
        'stats' => [
            ['icon' => '👥', 'count' => '840+', 'label' => 'Siswa Aktif'],
            ['icon' => '👨‍🏫', 'count' => '54', 'label' => 'Guru Bersertifikat'],
            ['icon' => '🔬', 'count' => '12', 'label' => 'Lab & Fasilitas'],
            ['icon' => '🏆', 'count' => '28', 'label' => 'Ekstrakurikuler']
        ],
        
        'portals' => [
            [
                'icon' => '📚',
                'iconBg' => 'rgba(34,197,94,0.15)',
                'title' => 'Akademik & Kurikulum',
                'description' => 'Jadwal pelajaran, silabus, RPP, materi pembelajaran digital, dan kalender akademik terintegrasi.',
                'linkText' => 'Lihat Jadwal',
                'link' => '#'
            ],
            [
                'icon' => '📊',
                'iconBg' => 'rgba(59,130,246,0.15)',
                'title' => 'Nilai & Rapor Digital',
                'description' => 'Cek nilai harian, UTS, UAS, rapor digital ber-QR code, analisis perkembangan belajar siswa.',
                'linkText' => 'Lihat Nilai',
                'link' => '#'
            ],
            [
                'icon' => '💰',
                'iconBg' => 'rgba(245,166,35,0.15)',
                'title' => 'Keuangan & SPP',
                'description' => 'Cek tagihan SPP, pembayaran online via transfer bank & e-wallet, riwayat pembayaran, dan pengajuan keringanan.',
                'linkText' => 'Bayar SPP',
                'link' => '#'
            ],
            [
                'icon' => '👥',
                'iconBg' => 'rgba(236,72,153,0.15)',
                'title' => 'Data Siswa & Kesiswaan',
                'description' => 'Profil siswa, ekstrakurikuler & OSIS, pencatatan disiplin, bimbingan konseling, dan recording prestasi.',
                'linkText' => 'Profil Siswa',
                'link' => '#'
            ],
            [
                'icon' => '📱',
                'iconBg' => 'rgba(6,182,212,0.15)',
                'title' => 'Portal Orang Tua',
                'description' => 'Monitor nilai, absensi, pembayaran, dan perkembangan anak secara real-time. Komunikasi langsung dengan guru via aplikasi.',
                'linkText' => 'Masuk Portal',
                'link' => '#'
            ],
            [
                'icon' => '👨‍🏫',
                'iconBg' => 'rgba(249,115,22,0.15)',
                'title' => 'Kepegawaian',
                'description' => 'Data guru & staff, jadwal mengajar, absensi, slip gaji digital, dan pengajuan izin/cuti secara online.',
                'linkText' => 'Portal Guru',
                'link' => '#'
            ],
            [
                'icon' => '🏫',
                'iconBg' => 'rgba(132,204,22,0.15)',
                'title' => 'Sarana & Prasarana',
                'description' => 'Booking ruangan, pengajuan maintenance, daftar inventaris aset, dan laporan kondisi fasilitas sekolah.',
                'linkText' => 'Booking Ruangan',
                'link' => '#'
            ],
            [
                'icon' => '🏆',
                'iconBg' => 'rgba(201,147,42,0.15)',
                'title' => 'Kelulusan & Alumni',
                'description' => 'Cek eligibility kelulusan, download ijazah digital ber-QR code, alumni portal, dan career tracking pasca lulus.',
                'linkText' => 'Portal Alumni',
                'link' => '#'
            ]
        ],
        
        'gallery' => [
            ['image' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=700&auto=format&fit=crop&q=80', 'caption' => 'Kegiatan Kelas'],
            ['image' => 'https://images.unsplash.com/photo-1562564055-71e051d33c19?w=600&auto=format&fit=crop&q=80', 'caption' => 'Upacara Bendera'],
            ['image' => 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600&auto=format&fit=crop&q=80', 'caption' => 'Laboratorium IPA'],
            ['image' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=600&auto=format&fit=crop&q=80', 'caption' => 'Kegiatan Olahraga'],
            ['image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80', 'caption' => 'Perpustakaan']
        ],
        
        'news' => [
            [
                'image' => 'https://images.unsplash.com/photo-1567168544813-cc03465b4fa8?w=500&auto=format&fit=crop&q=80',
                'category' => 'Prestasi',
                'title' => 'Siswa MA\'ARIF Raih Juara 1 Olimpiade Matematika Tingkat Kabupaten Cilacap',
                'date' => '15 April 2026'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1529390079861-591de354faf5?w=500&auto=format&fit=crop&q=80',
                'category' => 'PPDB 2026',
                'categoryColor' => ['bg' => 'rgba(201,147,42,0.1)', 'text' => 'var(--gold)'],
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2026/2027 Resmi Dibuka',
                'date' => '1 April 2026'
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=500&auto=format&fit=crop&q=80',
                'category' => 'Kegiatan',
                'title' => 'Bakti Sosial Ramadan: Siswa MA\'ARIF Berbagi dengan Masyarakat Sekitar',
                'date' => '28 Maret 2026'
            ]
        ],
        
        'cta' => [
            'title' => 'Daftarkan Putra-Putri Anda',
            'description' => 'Pendaftaran siswa baru tahun ajaran 2026/2027 sudah dibuka. Bergabunglah dengan keluarga besar SMA MA\'ARIF KROYA.',
            'ctaText' => 'Daftar Online Sekarang',
            'ctaUrl' => '#'
        ],
        
        'footer' => [
            'brand' => [
                'name' => 'SMA MA\'ARIF KROYA',
                'description' => 'Sekolah Menengah Atas berbasis Islam di bawah naungan LP Ma\'arif NU Kabupaten Cilacap. Berilmu, Beriman, Berprestasi.',
                'copyright' => '© 2026 SMA MA\'ARIF KROYA. Hak cipta dilindungi.',
                'address' => 'Jl. Masjid No.1, Kroya, Cilacap, Jawa Tengah · (0282) 494-000'
            ],
            'columns' => [
                [
                    'title' => 'Portal',
                    'links' => [
                        ['label' => 'Login Siswa', 'url' => '#'],
                        ['label' => 'Login Guru', 'url' => '#'],
                        ['label' => 'Portal Orang Tua', 'url' => '#'],
                        ['label' => 'Portal Alumni', 'url' => '#']
                    ]
                ],
                [
                    'title' => 'Akademik',
                    'links' => [
                        ['label' => 'Jadwal Pelajaran', 'url' => '#'],
                        ['label' => 'Kalender Akademik', 'url' => '#'],
                        ['label' => 'Ekstrakurikuler', 'url' => '#'],
                        ['label' => 'Perpustakaan', 'url' => '#']
                    ]
                ],
                [
                    'title' => 'Info',
                    'links' => [
                        ['label' => 'Tentang Sekolah', 'url' => '#'],
                        ['label' => 'Berita & Pengumuman', 'url' => '#'],
                        ['label' => 'Galeri', 'url' => '#'],
                        ['label' => 'Hubungi Kami', 'url' => '#']
                    ]
                ]
            ]
        ]
    ];
    
    return view('landing', $data);
}
```

### Task 2.11: Update Landing View dengan Components

**File**: `resources/views/landing.blade.php`

Replace monolithic HTML dengan component calls:

```blade
@extends('layouts.app')

@section('title', 'Beranda - SMA MA\'ARIF KROYA')

@section('content')

<x-topbar :email="$contact['email']" :phone="$contact['phone']" />

<x-nav 
    :logoText="$logo"
    :menuItems="$menu"
    :ctaText="$navCta['text']"
    :ctaLink="$navCta['url']"
/>

<x-hero
    :tag="$hero['tag']"
    :title="$hero['title']"
    :subtitle="$hero['subtitle']"
    :heroImage="$hero['image']"
    :cta1="$hero['cta1']"
    :cta2="$hero['cta2']"
/>

<x-stats-bar :stats="$stats" />

<!-- About Section (keep as is untuk Phase ini, nanti bisa di-componentize juga) -->
<div class="section" id="tentang">
    <!-- ... existing about section HTML ... -->
</div>

<!-- Features Section (keep as is) -->
<div class="features-grid">
    <!-- ... existing features HTML ... -->
</div>

<!-- Portal Cards Section -->
<div class="section" id="portal">
    <div class="section-label">Portal Terintegrasi</div>
    <h2>Sistem Informasi Terpadu</h2>
    <p class="section-desc">Akses semua kebutuhan akademik dan administrasi dalam satu platform digital.</p>
    
    <div class="portal-grid">
        @foreach($portals as $portal)
        <x-portal-card
            :icon="$portal['icon']"
            :iconBg="$portal['iconBg']"
            :title="$portal['title']"
            :description="$portal['description']"
            :linkText="$portal['linkText']"
            :link="$portal['link']"
        />
        @endforeach
    </div>
</div>

<!-- Gallery Section -->
<div class="section" id="galeri">
    <div class="section-label">Galeri</div>
    <h2>Kehidupan di SMA MA'ARIF KROYA</h2>
    <p class="section-desc">Momen berharga kegiatan belajar mengajar, ekstrakurikuler, dan prestasi siswa kami.</p>
    
    <div class="gallery-grid fade-in">
        @foreach($gallery as $item)
        <x-gallery-item
            :image="$item['image']"
            :caption="$item['caption']"
        />
        @endforeach
    </div>
</div>

<!-- News Section -->
<div style="background:white; padding:80px 0;" id="berita">
    <div class="section" style="padding-top:0;padding-bottom:0;">
        <div class="section-label">Berita & Pengumuman</div>
        <h2>Info Terbaru Sekolah</h2>
        <p class="section-desc">Ikuti perkembangan terbaru kegiatan, prestasi, dan pengumuman resmi SMA MA'ARIF KROYA.</p>
        
        <div class="news-grid">
            @foreach($news as $item)
            <x-news-card
                :image="$item['image']"
                :category="$item['category']"
                :title="$item['title']"
                :date="$item['date']"
                :categoryColor="$item['categoryColor'] ?? null"
            />
            @endforeach
        </div>
    </div>
</div>

<x-cta-band
    :title="$cta['title']"
    :description="$cta['description']"
    :ctaText="$cta['ctaText']"
    :ctaUrl="$cta['ctaUrl']"
/>

<x-footer
    :brand="$footer['brand']"
    :columns="$footer['columns']"
/>

@endsection
```

## Phase 2 Validation Checklist

- ✅ All components render correctly
- ✅ Data passing works (no undefined variable errors)
- ✅ Visual output identical to Phase 1
- ✅ No hardcoded text left di landing.blade.php
- ✅ Components reusable (bisa dipanggil di halaman lain)
- ✅ Console no errors
- ✅ Blade syntax valid

## Phase 2 Deliverables

1. 9 Component files (topbar, nav, hero, stats-bar, portal-card, gallery-item, news-card, cta-band, footer)
2. Updated `LandingController.php` dengan full data
3. Updated `landing.blade.php` dengan component calls
4. All code COMPLETE, NO placeholders

---

---

# 🔹 PHASE 3: OPTIMIZATION & PRODUCTION READINESS

## Phase 3 Objectives
- Asset optimization (minify CSS/JS)
- Environment configuration
- Database schema planning (migrations)
- SEO meta tags
- Error handling
- Documentation

## Phase 3 Tasks

### Task 3.1: Environment Setup (`.env.example`)

**Requirements**:
- Complete .env template
- DB credentials placeholder
- App settings
- Mail settings placeholder

```env
APP_NAME="SMA MA'ARIF KROYA"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sma_maarif_kroya
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Mail Configuration (untuk notifikasi)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@smamaarifkroya.sch.id"
MAIL_FROM_NAME="${APP_NAME}"

# App Settings
SCHOOL_NAME="SMA MA'ARIF KROYA"
SCHOOL_EMAIL="info@smamaarifkroya.sch.id"
SCHOOL_PHONE="(0282) 494-000"
SCHOOL_ADDRESS="Jl. Masjid No.1, Kroya, Cilacap, Jawa Tengah"
```

### Task 3.2: Config File (`config/school.php`)

**Purpose**: Centralized school info configuration

```php
<?php

return [
    'name' => env('SCHOOL_NAME', 'SMA MA\'ARIF KROYA'),
    'email' => env('SCHOOL_EMAIL', 'info@smamaarifkroya.sch.id'),
    'phone' => env('SCHOOL_PHONE', '(0282) 494-000'),
    'address' => env('SCHOOL_ADDRESS', 'Jl. Masjid No.1, Kroya, Cilacap, Jawa Tengah'),
    
    'social_media' => [
        'facebook' => '#',
        'instagram' => '#',
        'youtube' => '#',
        'twitter' => '#'
    ],
    
    'meta' => [
        'description' => 'Sistem Informasi Sekolah SMA MA\'ARIF KROYA - Akses nilai, absensi, SPP, dan informasi akademik secara real-time.',
        'keywords' => 'SMA MA\'ARIF KROYA, Sekolah Islam Cilacap, PPDB Online, Sistem Informasi Sekolah',
        'author' => 'SMA MA\'ARIF KROYA IT Team'
    ]
];
```

### Task 3.3: Update Controller untuk Config

**File**: `app/Http/Controllers/LandingController.php`

Replace hardcoded school info dengan config:

```php
$data = [
    'contact' => [
        'email' => config('school.email'),
        'phone' => config('school.phone')
    ],
    // ... rest unchanged ...
];
```

### Task 3.4: SEO Meta Tags di Layout

**File**: `resources/views/layouts/app.blade.php`

Add di `<head>`:

```blade
<!-- SEO Meta Tags -->
<meta name="description" content="@yield('meta_description', config('school.meta.description'))">
<meta name="keywords" content="@yield('meta_keywords', config('school.meta.keywords'))">
<meta name="author" content="{{ config('school.meta.author') }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', config('school.name'))">
<meta property="og:description" content="@yield('meta_description', config('school.meta.description'))">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="@yield('title', config('school.name'))">
<meta property="twitter:description" content="@yield('meta_description', config('school.meta.description'))">
<meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
```

### Task 3.5: Database Migrations Planning

**Requirements**:
- Schema blueprint untuk future development
- Gunakan command: `php artisan make:migration create_xxx_table`
- Relationship annotations

#### Migration 1: Users Table Enhancement

```php
// database/migrations/xxxx_enhance_users_table.php
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['admin', 'guru', 'siswa', 'orang_tua', 'alumni'])->after('email');
    $table->string('nip_nis')->nullable()->unique()->after('role'); // NIP untuk guru, NIS untuk siswa
    $table->string('phone', 20)->nullable();
    $table->string('avatar')->nullable();
    $table->boolean('is_active')->default(true);
});
```

#### Migration 2: Students Table

```php
Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('nis', 20)->unique();
    $table->string('nisn', 20)->unique();
    $table->string('name');
    $table->enum('gender', ['L', 'P']);
    $table->string('tempat_lahir');
    $table->date('tanggal_lahir');
    $table->text('alamat');
    $table->string('phone', 20)->nullable();
    $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
    $table->enum('status', ['aktif', 'lulus', 'pindah', 'keluar'])->default('aktif');
    $table->timestamps();
    $table->softDeletes();
});
```

#### Migration 3: Teachers Table

```php
Schema::create('teachers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('nip', 30)->unique();
    $table->string('name');
    $table->enum('gender', ['L', 'P']);
    $table->string('tempat_lahir');
    $table->date('tanggal_lahir');
    $table->text('alamat');
    $table->string('phone', 20);
    $table->string('pendidikan_terakhir', 10); // S1, S2, S3
    $table->string('mata_pelajaran')->nullable();
    $table->enum('status_kepegawaian', ['PNS', 'CPNS', 'GTY', 'GTT'])->default('GTT');
    $table->date('tmt')->nullable(); // Tanggal Mulai Tugas
    $table->timestamps();
    $table->softDeletes();
});
```

#### Migration 4: Classes Table

```php
Schema::create('classes', function (Blueprint $table) {
    $table->id();
    $table->string('name', 50); // X IPA 1, XI IPS 2, dll
    $table->integer('tingkat'); // 10, 11, 12
    $table->enum('jurusan', ['IPA', 'IPS']);
    $table->foreignId('wali_kelas_id')->nullable()->constrained('teachers')->onDelete('set null');
    $table->integer('kapasitas')->default(36);
    $table->string('ruang_kelas')->nullable();
    $table->enum('tahun_ajaran', ['2025/2026', '2026/2027'])->default('2026/2027');
    $table->timestamps();
});
```

#### Migration 5: Subjects Table

```php
Schema::create('subjects', function (Blueprint $table) {
    $table->id();
    $table->string('kode', 10)->unique(); // MTK, FIS, BIO, dll
    $table->string('nama');
    $table->enum('kelompok', ['A', 'B', 'C']); // A: Umum, B: Peminatan, C: Lintas Minat
    $table->integer('kkm')->default(70);
    $table->timestamps();
});
```

#### Migration 6: Grades Table

```php
Schema::create('grades', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('subject_id')->constrained()->onDelete('cascade');
    $table->foreignId('class_id')->constrained()->onDelete('cascade');
    $table->string('semester', 10); // Ganjil, Genap
    $table->string('tahun_ajaran', 20); // 2026/2027
    $table->integer('nilai_harian')->nullable();
    $table->integer('nilai_uts')->nullable();
    $table->integer('nilai_uas')->nullable();
    $table->integer('nilai_akhir')->nullable();
    $table->string('predikat', 1)->nullable(); // A, B, C, D
    $table->text('catatan')->nullable();
    $table->timestamps();
    
    $table->unique(['student_id', 'subject_id', 'semester', 'tahun_ajaran']);
});
```

#### Migration 7: Attendance Table

```php
Schema::create('attendances', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('class_id')->constrained()->onDelete('cascade');
    $table->date('tanggal');
    $table->enum('status', ['hadir', 'sakit', 'izin', 'alpa'])->default('hadir');
    $table->text('keterangan')->nullable();
    $table->time('waktu_masuk')->nullable();
    $table->time('waktu_keluar')->nullable();
    $table->timestamps();
    
    $table->unique(['student_id', 'tanggal']);
});
```

#### Migration 8: Payments Table

```php
Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->enum('jenis', ['spp', 'uang_gedung', 'seragam', 'buku', 'kegiatan', 'lainnya']);
    $table->string('bulan', 20)->nullable(); // Untuk SPP: Januari, Februari, dst
    $table->integer('tahun')->nullable();
    $table->integer('jumlah');
    $table->date('tanggal_bayar')->nullable();
    $table->enum('status', ['belum_bayar', 'lunas', 'cicilan'])->default('belum_bayar');
    $table->enum('metode', ['tunai', 'transfer', 'ewallet'])->nullable();
    $table->string('bukti_bayar')->nullable();
    $table->text('keterangan')->nullable();
    $table->timestamps();
});
```

#### Migration 9: News Table

```php
Schema::create('news', function (Blueprint $table) {
    $table->id();
    $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('excerpt')->nullable();
    $table->longText('content');
    $table->string('featured_image')->nullable();
    $table->enum('category', ['prestasi', 'ppdb', 'kegiatan', 'pengumuman'])->default('pengumuman');
    $table->enum('status', ['draft', 'published'])->default('draft');
    $table->timestamp('published_at')->nullable();
    $table->integer('views')->default(0);
    $table->timestamps();
    $table->softDeletes();
});
```

#### Migration 10: Gallery Table

```php
Schema::create('galleries', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('image');
    $table->enum('category', ['kelas', 'upacara', 'lab', 'olahraga', 'perpustakaan', 'lainnya']);
    $table->integer('order')->default(0);
    $table->timestamps();
});
```

### Task 3.6: Asset Optimization Notes

**File**: Create `ASSET_OPTIMIZATION.md` di project root

```markdown
# Asset Optimization Guide

## CSS Minification
Setelah development selesai, minify CSS:
```bash
# Install clean-css-cli
npm install -g clean-css-cli

# Minify
cleancss -o public/css/landing.min.css public/css/landing.css
```

Update di layout: `<link rel="stylesheet" href="{{ asset('css/landing.min.css') }}">`

## JavaScript Minification
```bash
# Install terser
npm install -g terser

# Minify
terser public/js/landing.js -o public/js/landing.min.js -c -m
```

Update di layout: `<script src="{{ asset('js/landing.min.js') }}"></script>`

## Image Optimization
1. Replace Unsplash URLs dengan local images
2. Compress dengan TinyPNG atau ImageOptim
3. Use WebP format untuk modern browsers
4. Lazy loading untuk gallery images

## Fonts
Consider self-hosting Google Fonts:
- Download dari google-webfonts-helper.herokuapp.com
- Place di `public/fonts/`
- Update CSS font-face declarations
```

### Task 3.7: README.md

**File**: Create/Update `README.md`

```markdown
# SMA MA'ARIF KROYA - Sistem Informasi Sekolah

Aplikasi web-based School Management System untuk SMA MA'ARIF KROYA, Cilacap.

## 🚀 Features

### Public Portal
- ✅ Landing page dengan informasi sekolah
- ✅ Berita & pengumuman
- ✅ Galeri kegiatan
- ✅ PPDB online registration

### Student Portal
- 📊 Nilai & Rapor Digital
- 📅 Jadwal Pelajaran
- 📋 Absensi Real-time
- 💰 Pembayaran SPP Online

### Teacher Portal
- 👨‍🏫 Input Nilai Siswa
- 📊 Rekap Absensi
- 📚 Upload Materi Pembelajaran
- 💵 Slip Gaji Digital

### Parent Portal
- 👁️ Monitor Nilai & Absensi Anak
- 💬 Komunikasi dengan Guru
- 💳 History Pembayaran

### Admin Portal
- 🏫 Manajemen Data Siswa & Guru
- 📊 Reporting & Analytics
- ⚙️ System Configuration
- 🗄️ Backup & Restore

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **Frontend**: Blade, Vanilla JS
- **Database**: MySQL
- **Styling**: Custom CSS (Green-Gold Theme)
- **Fonts**: Syne, Plus Jakarta Sans

## 📦 Installation

```bash
# Clone repository
git clone https://github.com/yourusername/sma-maarif-kroya.git
cd sma-maarif-kroya

# Install dependencies
composer install

# Copy environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database di .env
DB_DATABASE=sma_maarif_kroya
DB_USERNAME=root
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# (Optional) Seed dummy data
php artisan db:seed

# Serve application
php artisan serve
```

Access: `http://localhost:8000`

## 📁 Project Structure

```
├── app/
│   └── Http/Controllers/
│       └── LandingController.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── components/
│   └── landing.blade.php
├── public/
│   ├── css/landing.css
│   ├── js/landing.js
│   └── images/
└── routes/web.php
```

## 🎨 Design System

**Color Palette**:
- Primary: `#1B6B3A` (Green)
- Accent: `#C9932A` (Gold)
- Background: `#F8F5EF` (Cream)

**Typography**:
- Display: Syne (800, 700, 600)
- Body: Plus Jakarta Sans (400, 500, 600, 700)

## 🚧 Development Roadmap

- [x] Phase 1: Landing Page Structure
- [x] Phase 2: Componentization & Data Binding
- [x] Phase 3: Optimization & Documentation
- [ ] Phase 4: Authentication & Authorization
- [ ] Phase 5: Student Module
- [ ] Phase 6: Teacher Module
- [ ] Phase 7: Parent Module
- [ ] Phase 8: Admin Dashboard

## 📄 License

Proprietary - SMA MA'ARIF KROYA © 2026

## 👨‍💻 Developer

**Ark (Joan Wijanarko)**  
Solo Full-Stack Developer  
Jakarta, Indonesia
```

### Task 3.8: Error Handling Enhancement

**File**: `app/Exceptions/Handler.php`

Optional enhancement untuk custom error pages:

```php
public function render($request, Throwable $exception)
{
    if ($this->isHttpException($exception)) {
        if ($exception->getStatusCode() == 404) {
            return response()->view('errors.404', [], 404);
        }
        
        if ($exception->getStatusCode() == 500) {
            return response()->view('errors.500', [], 500);
        }
    }
    
    return parent::render($request, $exception);
}
```

Create `resources/views/errors/404.blade.php` & `500.blade.php` with school branding.

### Task 3.9: Route Optimization

**File**: `routes/web.php`

Add route caching recommendation:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Production: php artisan route:cache untuk optimize routing
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Future Portal Routes
Route::prefix('portal')->name('portal.')->group(function() {
    // Route::get('/akademik', [AkademikController::class, 'index'])->name('akademik');
    // Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai');
    // dst...
});

// Future Auth Routes (akan di-uncomment setelah auth module ready)
// Auth::routes();
// Route::middleware(['auth'])->group(function() {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });
```

## Phase 3 Validation Checklist

- ✅ `.env.example` complete
- ✅ `config/school.php` created
- ✅ SEO meta tags implemented
- ✅ Database migrations planned (10 migrations)
- ✅ README.md comprehensive
- ✅ ASSET_OPTIMIZATION.md created
- ✅ Error handling enhanced (optional)
- ✅ Routes documented
- ✅ Project siap production deployment

## Phase 3 Deliverables

1. `.env.example` - COMPLETE
2. `config/school.php` - COMPLETE
3. Updated `resources/views/layouts/app.blade.php` dengan SEO meta
4. 10 Migration files (blueprint only, belum run)
5. `README.md` - COMPLETE
6. `ASSET_OPTIMIZATION.md` - COMPLETE
7. Updated `app/Exceptions/Handler.php` (optional)
8. Updated `routes/web.php` dengan documentation

---

---

# ✅ EXECUTION INSTRUCTIONS

## For Developer (Ark):

### Step 1: Setup Laravel Project
```bash
# Download Laravel 11
composer create-project laravel/laravel sma-maarif-kroya
cd sma-maarif-kroya

# Create necessary directories
mkdir -p public/css public/js public/images/hero public/images/gallery public/images/news
mkdir -p resources/views/components resources/views/layouts
```

### Step 2: Copy Prompt File
- Save file ini sebagai `SMA_MAARIF_CONVERSION_PROMPT.md`
- Copy file `index.html` yang sudah Anda upload
- Taruh keduanya di project root folder

### Step 3: Execute dengan Claude Sonnet CLI

**Phase 1**:
```bash
claude-code --file SMA_MAARIF_CONVERSION_PROMPT.md --section "PHASE 1"
```

Tunggu sampai selesai, test dengan `php artisan serve`, pastikan tampil OK.

**Phase 2**:
```bash
claude-code --file SMA_MAARIF_CONVERSION_PROMPT.md --section "PHASE 2"
```

Test lagi, pastikan components render correctly.

**Phase 3**:
```bash
claude-code --file SMA_MAARIF_CONVERSION_PROMPT.md --section "PHASE 3"
```

Final check, production-ready.

---

## 🎯 CRITICAL RULES FOR CLAUDE SONNET

1. **NO PLACEHOLDERS**: Provide complete code untuk every file
2. **NO SHORTCUTS**: Jangan skip bagian manapun dengan comment "... rest of code ..."
3. **EXACT STYLING**: Jangan ubah design/colors yang sudah ada
4. **BLADE SYNTAX**: Ensure valid Blade directives
5. **DATA STRUCTURE**: Maintain exact array structure dari controller
6. **COMPONENT PROPS**: Props harus match dengan usage
7. **FILE PATHS**: Asset paths harus benar (asset() helper)
8. **CLEAN CODE**: PSR-12, readable, production-quality

---

## 📊 TOKEN OPTIMIZATION STRATEGY

**Why 3 Phases?**
- Phase 1: ~15K tokens (structure & extraction)
- Phase 2: ~25K tokens (componentization, largest phase)
- Phase 3: ~10K tokens (optimization & docs)
- **Total**: ~50K tokens vs 80K+ jika 1 phase

**Benefits**:
- ✅ Incremental testing after each phase
- ✅ Easier debugging
- ✅ Hemat ~30-40% tokens
- ✅ Claude focus lebih baik per phase

---

**END OF PROMPT FILE**
