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

---

---

# 🔹 PHASE 4: PPDB ONLINE & PORTAL SISWA INTEGRATION

## Phase 4 Objectives
- Integrate PPDB Online system (React SPA)
- Integrate Student Portal (Nilai, Absensi, Tagihan, Profil)
- Setup routes untuk PPDB & Portal
- Connect landing page buttons ke fitur baru
- Prepare for authentication integration

## Phase 4 Context

File `index__2_.html` berisi React Single Page Application dengan 4 halaman:
1. **Home** - Hero PPDB + alur pendaftaran 4 langkah
2. **Daftar** - Form pendaftaran siswa baru dengan validasi
3. **Cek Status** - Check pendaftaran by ID/Email
4. **Portal Siswa** - Dashboard dengan 4 tabs (Nilai, Absensi, Tagihan SPP, Profil)

**Current Tech**: React 18 standalone dengan localStorage
**Target**: Convert ke Laravel Blade + optional Vue/Livewire

## Phase 4 Tasks

### Task 4.1: Create PPDB Controller (`app/Http/Controllers/PpdbController.php`)

**Requirements**:
- Handle PPDB landing page
- Handle form submission (future)
- Handle status checking

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpdbController extends Controller
{
    /**
     * Display PPDB landing page
     */
    public function index()
    {
        $data = [
            'periode' => [
                'tahun_ajaran' => '2026/2027',
                'pendaftaran_mulai' => '1 Maret 2026',
                'pendaftaran_selesai' => '30 April 2026',
                'tes_cbt_mulai' => '5 Mei 2026',
                'tes_cbt_selesai' => '10 Mei 2026',
                'pengumuman' => '15 Mei 2026'
            ],
            
            'steps' => [
                [
                    'number' => '01',
                    'icon' => '📝',
                    'title' => 'Isi Formulir',
                    'description' => 'Lengkapi data diri dan dokumen pendukung secara online'
                ],
                [
                    'number' => '02',
                    'icon' => '💻',
                    'title' => 'Tes Seleksi',
                    'description' => 'Ikuti Computer-Based Testing (CBT) sesuai jadwal yang ditentukan'
                ],
                [
                    'number' => '03',
                    'icon' => '📢',
                    'title' => 'Pengumuman',
                    'description' => 'Cek hasil seleksi secara online menggunakan nomor pendaftaran'
                ],
                [
                    'number' => '04',
                    'icon' => '✅',
                    'title' => 'Daftar Ulang',
                    'description' => 'Lakukan daftar ulang dan lengkapi administrasi sekolah'
                ]
            ],
            
            'persyaratan' => [
                'Ijazah SMP/MTs (fotocopy dilegalisir)',
                'SKHUN SMP/MTs (fotocopy dilegalisir)',
                'Kartu Keluarga (fotocopy)',
                'Akta Kelahiran (fotocopy)',
                'Pas Foto 3x4 (4 lembar background merah)',
                'Surat Keterangan Sehat dari Dokter',
                'Rapor SMP/MTs Kelas 7-9 (fotocopy)'
            ],
            
            'biaya' => [
                'Formulir Pendaftaran' => 'Gratis',
                'Tes Seleksi' => 'Gratis',
                'Uang Gedung (jika diterima)' => 'Rp 3.500.000',
                'SPP per Bulan' => 'Rp 350.000',
                'Seragam & Buku (perkiraan)' => 'Rp 2.000.000'
            ]
        ];
        
        return view('ppdb.index', $data);
    }
    
    /**
     * Show registration form
     */
    public function daftar()
    {
        return view('ppdb.daftar');
    }
    
    /**
     * Handle registration submission
     */
    public function storeDaftar(Request $request)
    {
        // TODO Phase 5: Validate & save to database
        // For now, just redirect
        return redirect()->route('ppdb.cek')->with('success', 'Pendaftaran berhasil!');
    }
    
    /**
     * Check registration status
     */
    public function cek()
    {
        return view('ppdb.cek');
    }
}
```

### Task 4.2: Create Student Portal Controller (`app/Http/Controllers/PortalController.php`)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    /**
     * Display student portal
     * TODO: Add auth middleware setelah Phase 5
     */
    public function index()
    {
        // Dummy data untuk Phase 4
        // Phase 5: Replace dengan real data dari database
        
        $data = [
            'siswa' => [
                'nama' => 'Ahmad Fauzi',
                'nisn' => '1234567890',
                'kelas' => 'X-A IPA',
                'wali_kelas' => 'Drs. Ahmad Kusuma',
                'foto' => asset('images/avatar-placeholder.png')
            ],
            
            'nilai' => [
                ['mapel' => 'Matematika', 'uh1' => 80, 'uh2' => 85, 'uts' => 88, 'uas' => 90, 'akhir' => 86, 'predikat' => 'A'],
                ['mapel' => 'Bahasa Indonesia', 'uh1' => 85, 'uh2' => 82, 'uts' => 87, 'uas' => 88, 'akhir' => 85, 'predikat' => 'A'],
                ['mapel' => 'Bahasa Inggris', 'uh1' => 78, 'uh2' => 80, 'uts' => 82, 'uas' => 85, 'akhir' => 81, 'predikat' => 'B'],
                ['mapel' => 'Fisika', 'uh1' => 75, 'uh2' => 78, 'uts' => 80, 'uas' => 82, 'akhir' => 79, 'predikat' => 'B'],
                ['mapel' => 'Kimia', 'uh1' => 82, 'uh2' => 84, 'uts' => 86, 'uas' => 88, 'akhir' => 85, 'predikat' => 'A'],
                ['mapel' => 'Biologi', 'uh1' => 80, 'uh2' => 83, 'uts' => 85, 'uas' => 87, 'akhir' => 84, 'predikat' => 'A']
            ],
            
            'absensi' => [
                ['bulan' => 'Januari', 'hadir' => 20, 'sakit' => 1, 'izin' => 0, 'bolos' => 0, 'total' => 21],
                ['bulan' => 'Februari', 'hadir' => 19, 'sakit' => 0, 'izin' => 1, 'bolos' => 0, 'total' => 20],
                ['bulan' => 'Maret', 'hadir' => 21, 'sakit' => 1, 'izin' => 0, 'bolos' => 0, 'total' => 22],
                ['bulan' => 'April', 'hadir' => 18, 'sakit' => 0, 'izin' => 0, 'bolos' => 0, 'total' => 18]
            ],
            
            'tagihan' => [
                ['bulan' => 'Januari', 'nominal' => 350000, 'status' => 'lunas', 'tanggal_bayar' => '5 Jan 2026'],
                ['bulan' => 'Februari', 'nominal' => 350000, 'status' => 'lunas', 'tanggal_bayar' => '3 Feb 2026'],
                ['bulan' => 'Maret', 'nominal' => 350000, 'status' => 'lunas', 'tanggal_bayar' => '2 Mar 2026'],
                ['bulan' => 'April', 'nominal' => 350000, 'status' => 'belum_dibayar', 'tanggal_bayar' => null]
            ],
            
            'profil' => [
                'nama_lengkap' => 'Ahmad Fauzi',
                'nisn' => '1234567890',
                'tempat_lahir' => 'Kroya',
                'tanggal_lahir' => '15 Mei 2010',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'kelas' => 'X-A IPA',
                'wali_kelas' => 'Drs. Ahmad Kusuma',
                'tahun_ajaran' => '2025/2026',
                'nama_ayah' => 'Bapak Fauzi',
                'no_hp_ayah' => '081298765432'
            ]
        ];
        
        return view('portal.index', $data);
    }
}
```

### Task 4.3: Update Routes (`routes/web.php`)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\PortalController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// PPDB Routes
Route::prefix('ppdb')->name('ppdb.')->group(function() {
    Route::get('/', [PpdbController::class, 'index'])->name('index');
    Route::get('/daftar', [PpdbController::class, 'daftar'])->name('daftar');
    Route::post('/daftar', [PpdbController::class, 'storeDaftar'])->name('daftar.store');
    Route::get('/cek-status', [PpdbController::class, 'cek'])->name('cek');
});

// Portal Siswa Routes
Route::prefix('portal')->name('portal.')->group(function() {
    Route::get('/', [PortalController::class, 'index'])->name('index');
    // TODO Phase 5: Add middleware auth
    // Route::middleware(['auth', 'role:siswa'])->group(function() {
    //     Route::get('/', [PortalController::class, 'index'])->name('index');
    // });
});
```

### Task 4.4: PPDB Landing Page View (`resources/views/ppdb/index.blade.php`)

**Requirements**:
- Extend dari layout master yang sama
- Hero section PPDB
- Info bar (tanggal penting)
- 4 steps alur pendaftaran
- Persyaratan & Biaya
- CTA buttons ke daftar & cek status

```blade
@extends('layouts.app')

@section('title', 'PPDB Online - SMA MA\'ARIF KROYA')

@section('content')

<!-- Topbar -->
<div class="topbar">
    <span>✉️ {{ config('school.email') }}</span>
    <span>📞 {{ config('school.phone') }}</span>
</div>

<!-- Nav PPDB -->
<nav style="background:white;border-bottom:2px solid #E8F5EE;padding:0 5vw;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
    <a href="{{ route('landing') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
        <div style="width:36px;height:36px;border-radius:8px;background:#1B6B3A;display:flex;align-items:center;justify-content:center;font-weight:800;color:white;font-size:0.9rem;">MA</div>
        <div>
            <div style="font-size:0.85rem;font-weight:800;color:#1B6B3A;line-height:1;">SMA MA'ARIF KROYA</div>
            <div style="font-size:0.65rem;color:#6B7280;">PPDB & Portal Siswa {{ $periode['tahun_ajaran'] }}</div>
        </div>
    </a>
    <div style="display:flex;gap:4px;">
        <a href="{{ route('ppdb.index') }}" style="padding:7px 14px;border-radius:8px;background:#1B6B3A;color:white;text-decoration:none;font-size:0.8rem;font-weight:600;">🏠 Beranda</a>
        <a href="{{ route('ppdb.daftar') }}" style="padding:7px 14px;border-radius:8px;color:#374151;text-decoration:none;font-size:0.8rem;font-weight:600;">📝 Daftar</a>
        <a href="{{ route('ppdb.cek') }}" style="padding:7px 14px;border-radius:8px;color:#374151;text-decoration:none;font-size:0.8rem;font-weight:600;">🔍 Cek Status</a>
        <a href="{{ route('portal.index') }}" style="padding:7px 14px;border-radius:8px;color:#374151;text-decoration:none;font-size:0.8rem;font-weight:600;">👤 Portal Siswa</a>
    </div>
</nav>

<!-- Hero PPDB -->
<div style="background:linear-gradient(135deg,#0D4A26 0%,#1B6B3A 60%,#22854A 100%);padding:70px 5vw;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:0.04;background-image:url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23fff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E');"></div>
    <div style="position:relative;">
        <div style="display:inline-block;background:rgba(201,147,42,0.2);border:1px solid rgba(201,147,42,0.4);color:#E5A830;padding:5px 16px;border-radius:100px;font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:1.5rem;">
            🎓 PPDB Tahun Ajaran {{ $periode['tahun_ajaran'] }}
        </div>
        <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;letter-spacing:-0.03em;line-height:1.1;margin-bottom:1rem;font-family:'Syne',sans-serif;">
            Penerimaan Peserta Didik Baru<br/>
            <span style="color:#4ADE80;">SMA MA'ARIF KROYA</span>
        </h1>
        <p style="color:rgba(255,255,255,0.75);max-width:500px;margin:0 auto 2.5rem;font-size:1rem;">
            Daftarkan diri sekarang dan jadilah bagian dari keluarga besar SMA MA'ARIF KROYA. Pendaftaran online 24 jam.
        </p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('ppdb.daftar') }}" style="padding:12px 28px;border-radius:10px;border:none;background:linear-gradient(135deg,#C9932A,#E5A830);color:white;font-weight:800;font-size:1rem;box-shadow:0 6px 24px rgba(201,147,42,0.4);text-decoration:none;">
                📝 Daftar Sekarang
            </a>
            <a href="{{ route('ppdb.cek') }}" style="padding:12px 28px;border-radius:10px;border:1px solid rgba(255,255,255,0.3);background:rgba(255,255,255,0.1);color:white;font-weight:700;font-size:1rem;backdrop-filter:blur(8px);text-decoration:none;">
                🔍 Cek Status Pendaftaran
            </a>
        </div>
    </div>
</div>

<!-- Info Bar -->
<div style="background:#C9932A;padding:1rem 5vw;display:grid;grid-template-columns:repeat(3,1fr);gap:1px;">
    <div style="text-align:center;padding:4px 0;">
        <div style="font-size:0.8rem;font-weight:700;color:white;">📅 Pendaftaran</div>
        <div style="font-size:0.78rem;color:rgba(255,255,255,0.75);">{{ $periode['pendaftaran_mulai'] }} – {{ $periode['pendaftaran_selesai'] }}</div>
    </div>
    <div style="text-align:center;padding:4px 0;">
        <div style="font-size:0.8rem;font-weight:700;color:white;">💻 Tes CBT</div>
        <div style="font-size:0.78rem;color:rgba(255,255,255,0.75);">{{ $periode['tes_cbt_mulai'] }} – {{ $periode['tes_cbt_selesai'] }}</div>
    </div>
    <div style="text-align:center;padding:4px 0;">
        <div style="font-size:0.8rem;font-weight:700;color:white;">📢 Pengumuman</div>
        <div style="font-size:0.78rem;color:rgba(255,255,255,0.75);">{{ $periode['pengumuman'] }}</div>
    </div>
</div>

<!-- Steps Section -->
<div style="max-width:1100px;margin:0 auto;padding:60px 5vw;">
    <div style="text-align:center;margin-bottom:2.5rem;">
        <div style="font-size:0.75rem;font-weight:700;color:#1B6B3A;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:8px;">Alur Pendaftaran</div>
        <h2 style="font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;color:#111827;letter-spacing:-0.02em;font-family:'Syne',sans-serif;">4 Langkah Mudah</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;">
        @foreach($steps as $step)
        <div style="background:white;border-radius:16px;padding:24px 20px;border:1px solid #E8F5EE;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
            <div style="width:48px;height:48px;border-radius:12px;background:#E8F5EE;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.4rem;">
                {{ $step['icon'] }}
            </div>
            <div style="font-size:0.7rem;font-weight:800;color:#C9932A;letter-spacing:0.1em;margin-bottom:6px;">STEP {{ $step['number'] }}</div>
            <h3 style="font-size:1rem;font-weight:800;color:#111827;margin-bottom:8px;">{{ $step['title'] }}</h3>
            <p style="font-size:0.8rem;color:#6B7280;line-height:1.5;">{{ $step['description'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<!-- Persyaratan & Biaya -->
<div style="background:white;padding:60px 5vw;">
    <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:40px;">
        <!-- Persyaratan -->
        <div>
            <h3 style="font-size:1.5rem;font-weight:800;color:#111827;margin-bottom:1.5rem;font-family:'Syne',sans-serif;">📋 Persyaratan Pendaftaran</h3>
            <ul style="list-style:none;padding:0;">
                @foreach($persyaratan as $item)
                <li style="padding:10px 0;border-bottom:1px solid #F3F4F6;font-size:0.875rem;color:#374151;">
                    <span style="color:#16A34A;margin-right:8px;">✓</span>{{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
        
        <!-- Biaya -->
        <div>
            <h3 style="font-size:1.5rem;font-weight:800;color:#111827;margin-bottom:1.5rem;font-family:'Syne',sans-serif;">💰 Rincian Biaya</h3>
            <div style="background:#F9FAFB;border-radius:12px;padding:20px;">
                @foreach($biaya as $item => $harga)
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #E5E7EB;font-size:0.875rem;">
                    <span style="color:#6B7280;">{{ $item }}</span>
                    <span style="font-weight:700;color:#111827;">{{ $harga }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="background:#1B6B3A;padding:50px 5vw;text-align:center;">
    <h2 style="font-size:2rem;font-weight:800;color:white;margin-bottom:1rem;font-family:'Syne',sans-serif;">Siap Bergabung?</h2>
    <p style="color:rgba(255,255,255,0.75);margin-bottom:2rem;font-size:1rem;">Daftar sekarang dan raih masa depan cemerlang bersama SMA MA'ARIF KROYA</p>
    <a href="{{ route('ppdb.daftar') }}" style="padding:14px 32px;border-radius:10px;background:linear-gradient(135deg,#C9932A,#E5A830);color:white;font-weight:800;font-size:1.1rem;text-decoration:none;display:inline-block;box-shadow:0 6px 24px rgba(201,147,42,0.4);">
        📝 Mulai Pendaftaran
    </a>
</div>

@endsection
```

### Task 4.5: Form Pendaftaran (`resources/views/ppdb/daftar.blade.php`)

**Requirements**:
- Multi-step form atau single page form
- Validation fields
- File upload placeholder
- Submit button

```blade
@extends('layouts.app')

@section('title', 'Formulir Pendaftaran - PPDB SMA MA\'ARIF KROYA')

@section('content')

<!-- Nav (sama seperti ppdb.index) -->
<nav style="background:white;border-bottom:2px solid #E8F5EE;padding:0 5vw;height:64px;display:flex;align-items:center;justify-content:space-between;">
    <!-- ... copy dari ppdb.index ... -->
</nav>

<div style="max-width:800px;margin:60px auto;padding:0 5vw;">
    <div style="text-align:center;margin-bottom:2.5rem;">
        <h1 style="font-size:2rem;font-weight:800;color:#111827;font-family:'Syne',sans-serif;">Formulir Pendaftaran</h1>
        <p style="color:#6B7280;">Lengkapi data berikut dengan benar dan lengkap</p>
    </div>
    
    <form method="POST" action="{{ route('ppdb.daftar.store') }}" style="background:white;border-radius:16px;padding:32px;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
        @csrf
        
        <!-- Data Pribadi -->
        <div style="margin-bottom:2rem;">
            <h3 style="font-size:1.1rem;font-weight:700;color:#111827;margin-bottom:1rem;padding-bottom:10px;border-bottom:2px solid #E8F5EE;">📝 Data Pribadi</h3>
            
            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
            </div>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:1rem;">
                <div>
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">Email *</label>
                    <input type="email" name="email" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
                </div>
                <div>
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">No. HP *</label>
                    <input type="tel" name="no_hp" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
                </div>
            </div>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:1rem;">
                <div>
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
                </div>
                <div>
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
                        <option value="">Pilih</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">Asal Sekolah *</label>
                <input type="text" name="asal_sekolah" required placeholder="Contoh: SMP N 1 Kroya" style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
            </div>
        </div>
        
        <!-- Data Orang Tua -->
        <div style="margin-bottom:2rem;">
            <h3 style="font-size:1.1rem;font-weight:700;color:#111827;margin-bottom:1rem;padding-bottom:10px;border-bottom:2px solid #E8F5EE;">👨‍👩‍👦 Data Orang Tua</h3>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:1rem;">
                <div>
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">Nama Ayah *</label>
                    <input type="text" name="nama_ayah" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
                </div>
                <div>
                    <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">No. HP Ayah *</label>
                    <input type="tel" name="no_hp_ayah" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
                </div>
            </div>
        </div>
        
        <!-- Pilihan Jurusan -->
        <div style="margin-bottom:2rem;">
            <h3 style="font-size:1.1rem;font-weight:700;color:#111827;margin-bottom:1rem;padding-bottom:10px;border-bottom:2px solid #E8F5EE;">🎯 Pilihan Jurusan</h3>
            
            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">Jurusan yang Diminati *</label>
                <select name="pilihan_jurusan" required style="width:100%;padding:10px 14px;border:1px solid #E5E7EB;border-radius:8px;font-size:0.9rem;">
                    <option value="">Pilih Jurusan</option>
                    <option value="IPA">IPA (Ilmu Pengetahuan Alam)</option>
                    <option value="IPS">IPS (Ilmu Pengetahuan Sosial)</option>
                </select>
            </div>
        </div>
        
        <!-- Submit -->
        <div style="text-align:center;padding-top:1rem;border-top:1px solid #E5E7EB;">
            <button type="submit" style="padding:12px 40px;border-radius:10px;border:none;background:#1B6B3A;color:white;font-weight:700;font-size:1rem;cursor:pointer;">
                ✅ Kirim Pendaftaran
            </button>
            <p style="font-size:0.75rem;color:#6B7280;margin-top:12px;">Dengan mendaftar, Anda menyetujui syarat dan ketentuan yang berlaku</p>
        </div>
    </form>
</div>

@endsection
```

### Task 4.6: Cek Status Page (`resources/views/ppdb/cek.blade.php`)

Simple page dengan form input ID/Email untuk cek status.

### Task 4.7: Portal Siswa Page (`resources/views/portal/index.blade.php`)

Portal dengan 4 tabs: Nilai, Absensi, Tagihan, Profil.

### Task 4.8: Update Landing Page Buttons

**File**: `resources/views/landing.blade.php`

Update CTA button di hero section:

```blade
<!-- Ganti href="#" jadi route ke PPDB -->
<a href="{{ route('ppdb.daftar') }}" class="btn-gold">Masuk Portal Siswa</a>
<a href="{{ route('ppdb.index') }}" class="btn-ghost">Lihat Panduan PPDB</a>
```

Update nav CTA:
```blade
<a href="{{ route('ppdb.index') }}" class="nav-cta">Daftar PPDB</a>
```

Update portal card links:
```blade
<!-- Di portal cards section -->
@foreach($portals as $portal)
<x-portal-card
    ...
    :link="$portal['link']" <!-- Ganti # dengan route yang sesuai -->
/>
@endforeach
```

## Phase 4 Validation Checklist

- ✅ Routes `/ppdb`, `/ppdb/daftar`, `/ppdb/cek-status`, `/portal` accessible
- ✅ PPDB landing page tampil dengan benar
- ✅ Form pendaftaran functional (submit redirect)
- ✅ Portal siswa tampil dengan dummy data
- ✅ Buttons di landing page mengarah ke route yang benar
- ✅ Navigation consistent across pages
- ✅ No console errors
- ✅ Styling consistent dengan landing page

## Phase 4 Deliverables

1. `app/Http/Controllers/PpdbController.php` - COMPLETE
2. `app/Http/Controllers/PortalController.php` - COMPLETE
3. `resources/views/ppdb/index.blade.php` - COMPLETE
4. `resources/views/ppdb/daftar.blade.php` - COMPLETE
5. `resources/views/ppdb/cek.blade.php` - COMPLETE (simplified version)
6. `resources/views/portal/index.blade.php` - COMPLETE
7. Updated `routes/web.php` - COMPLETE
8. Updated `resources/views/landing.blade.php` (buttons) - COMPLETE

---

---

# 🔹 PHASE 5: ADMIN PANEL with FILAMENT

## Phase 5 Objectives
- Install & configure Filament Admin Panel
- Setup multi-panel architecture (public vs admin)
- Generate database migrations from schema
- Create Filament Resources for CRUD operations
- Implement RBAC (Role-Based Access Control)
- Dashboard with KPI widgets

## Phase 5 Context

Admin panel HTML berisi **35+ CRUD modules** dengan kompleksitas tinggi:
- Dashboard & Reporting (2 modules)
- Penerimaan Siswa (4 modules)
- Akademik (5 modules)
- Keuangan & SPP (5 modules)
- Kesiswaan (4 modules)
- Kepegawaian (6 modules)
- Sarana & Prasarana (4 modules)
- Humas & Komunikasi (3+ modules)

**Strategy**: Gunakan Filament PHP untuk auto-generate CRUD → hemat 70% effort vs manual coding.

## Phase 5 Prerequisites

```bash
# Laravel 11 already installed from Phase 1-4
# Composer & PHP 8.2+ ready
```

## Phase 5 Tasks

### Task 5.1: Install Filament

```bash
# Install Filament v3
composer require filament/filament:"^3.0"

# Install admin panel
php artisan filament:install --panels

# Publish config (optional)
php artisan vendor:publish --tag=filament-config
```

### Task 5.2: Configure Multi-Panel Architecture

**File**: `config/filament.php`

Setup 2 panels:
1. **admin** → `/admin` (backend CRUD)
2. **default** → public routes tetap di root

```php
// config/filament.php
return [
    'path' => env('FILAMENT_PATH', 'admin'),
    'domain' => env('FILAMENT_DOMAIN'),
    // ... other config
];
```

### Task 5.3: Create Admin User

```bash
php artisan make:filament-user

# Input:
# Name: Admin
# Email: admin@smamaarifkroya.sch.id
# Password: (secure password)
```

### Task 5.4: Database Migrations (Priority Modules)

Generate migrations untuk **modul inti** dulu (Phase 3 sudah ada 10 migrations).

**Additional Migrations Needed**:

#### Migration: Pendaftar PPDB
```bash
php artisan make:migration create_ppdb_pendaftar_table
```

```php
Schema::create('ppdb_pendaftar', function (Blueprint $table) {
    $table->id();
    $table->string('no_pendaftaran')->unique(); // PPDB-2026-001
    $table->string('nama_lengkap');
    $table->string('email')->unique();
    $table->string('no_hp', 20);
    $table->string('asal_sekolah');
    $table->date('tanggal_lahir');
    $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
    $table->enum('pilihan_jurusan', ['IPA', 'IPS']);
    $table->string('nama_ayah');
    $table->string('no_hp_ayah', 20);
    $table->enum('status', ['pending', 'submitted', 'verified', 'approved', 'rejected'])->default('pending');
    $table->decimal('nilai_tes', 5, 2)->nullable();
    $table->timestamp('tanggal_daftar')->useCurrent();
    $table->timestamps();
    $table->softDeletes();
});
```

#### Migration: Tes Masuk
```php
Schema::create('tes_masuk', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pendaftar_id')->constrained('ppdb_pendaftar')->onDelete('cascade');
    $table->dateTime('jadwal_tes');
    $table->enum('metode_tes', ['CBT', 'tertulis', 'interview'])->default('CBT');
    $table->string('ruangan', 50)->nullable();
    $table->decimal('nilai_tes', 5, 2)->nullable();
    $table->integer('durasi_tes')->default(90); // menit
    $table->enum('status_tes', ['belum_dimulai', 'berjalan', 'selesai', 'absent'])->default('belum_dimulai');
    $table->enum('hasil', ['lulus', 'tidak_lulus'])->nullable();
    $table->timestamps();
});
```

#### Migration: Nilai Siswa (extends dari Phase 3)
```php
// Already exists in Phase 3 as 'grades' table
// No additional migration needed
```

#### Migration: Tagihan & Pembayaran (extends dari Phase 3)
```php
// Already exists in Phase 3 as 'payments' table
// Add additional fields if needed
```

#### Migration: Mata Pelajaran (extends)
```php
Schema::create('subjects', function (Blueprint $table) {
    $table->id();
    $table->string('kode_mapel', 10)->unique();
    $table->string('nama_mapel');
    $table->enum('kategori', ['umum', 'keahlian', 'kejuruan'])->default('umum');
    $table->integer('jam_pelajaran')->default(2); // JP per minggu
    $table->enum('kurikulum', ['Merdeka', '2013'])->default('Merdeka');
    $table->timestamps();
});
```

#### Migration: Penugasan Guru
```php
Schema::create('penugasan_guru', function (Blueprint $table) {
    $table->id();
    $table->foreignId('guru_id')->constrained('teachers')->onDelete('cascade');
    $table->foreignId('mapel_id')->nullable()->constrained('subjects')->onDelete('set null');
    $table->foreignId('kelas_id')->nullable()->constrained('classes')->onDelete('set null');
    $table->string('tugas_khusus')->nullable(); // Wali Kelas, Pembina OSIS
    $table->integer('beban_kerja_jam')->default(24);
    $table->string('tahun_ajaran', 20);
    $table->enum('status', ['aktif', 'nonaktif', 'diganti'])->default('aktif');
    $table->timestamps();
});
```

#### Migration: Inventaris Aset
```php
Schema::create('inventaris_aset', function (Blueprint $table) {
    $table->id();
    $table->string('kode_aset')->unique();
    $table->string('nama_aset');
    $table->string('kategori_aset'); // mebel, elektronik, kendaraan
    $table->string('merk')->nullable();
    $table->year('tahun_perolehan');
    $table->decimal('nilai_perolehan', 15, 2);
    $table->enum('kondisi', ['baik', 'sedang', 'rusak', 'hilang'])->default('baik');
    $table->enum('status_aset', ['aktif', 'tidak_aktif', 'dihapuskan'])->default('aktif');
    $table->timestamps();
    $table->softDeletes();
});
```

**Run Migrations**:
```bash
php artisan migrate
```

### Task 5.5: Generate Filament Resources

Filament auto-generate CRUD dari migrations!

```bash
# Generate Resources untuk modul priority
php artisan make:filament-resource PpdbPendaftar --generate
php artisan make:filament-resource Student --generate
php artisan make:filament-resource Teacher --generate
php artisan make:filament-resource Class --generate
php artisan make:filament-resource Subject --generate
php artisan make:filament-resource Grade --generate
php artisan make:filament-resource Attendance --generate
php artisan make:filament-resource Payment --generate
php artisan make:filament-resource TesMasuk --generate
php artisan make:filament-resource PenugasanGuru --generate
php artisan make:filament-resource InventarisAset --generate
```

**What This Does**:
- Auto-create `app/Filament/Resources/StudentResource.php`
- Auto-create `app/Filament/Resources/StudentResource/Pages/`
- Auto-generate Table columns from migration
- Auto-generate Form fields from migration
- CRUD routes auto-registered!

### Task 5.6: Customize Filament Resources (Example: Student)

**File**: `app/Filament/Resources/StudentResource.php`

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationGroup = 'Kesiswaan';
    
    protected static ?string $navigationLabel = 'Data Siswa';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nis')
                            ->label('NIS')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Kontak & Alamat')
                    ->schema([
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('phone')
                            ->label('No. HP')
                            ->tel()
                            ->maxLength(20),
                    ]),
                    
                Forms\Components\Section::make('Status Akademik')
                    ->schema([
                        Forms\Components\Select::make('class_id')
                            ->label('Kelas')
                            ->relationship('class', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'aktif' => 'Aktif',
                                'lulus' => 'Lulus',
                                'pindah' => 'Pindah',
                                'keluar' => 'Keluar',
                            ])
                            ->default('aktif')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('class.name')
                    ->label('Kelas')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'warning' => 'pindah',
                        'danger' => 'keluar',
                        'primary' => 'lulus',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class')
                    ->relationship('class', 'name')
                    ->label('Kelas'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'lulus' => 'Lulus',
                        'pindah' => 'Pindah',
                        'keluar' => 'Keluar',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
```

### Task 5.7: Navigation Grouping

**File**: Customize each Resource's `$navigationGroup`

```php
// Grouping structure:
protected static ?string $navigationGroup = 'Penerimaan Siswa'; // PPDB modules
protected static ?string $navigationGroup = 'Akademik'; // Kelas, Mapel, Nilai
protected static ?string $navigationGroup = 'Keuangan'; // SPP, Tagihan
protected static ?string $navigationGroup = 'Kesiswaan'; // Data Siswa, Prestasi
protected static ?string $navigationGroup = 'Kepegawaian'; // Guru, Penggajian
protected static ?string $navigationGroup = 'Sarana'; // Ruangan, Inventaris
protected static ?string $navigationGroup = 'Humas'; // Pengumuman, Event
```

### Task 5.8: Dashboard Widgets

**File**: `app/Filament/Widgets/StatsOverview.php`

```bash
php artisan make:filament-widget StatsOverview --stats-overview
```

```php
<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Siswa Aktif', Student::where('status', 'aktif')->count())
                ->description('Siswa terdaftar tahun ini')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
                
            Stat::make('Total Guru', Teacher::count())
                ->description('Tenaga pengajar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
                
            Stat::make('Tagihan Belum Dibayar', 'Rp ' . number_format(
                Payment::where('status', 'belum_bayar')->sum('jumlah'), 0, ',', '.'
            ))
                ->description('Total tunggakan SPP')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
                
            Stat::make('Pendaftar PPDB', \App\Models\PpdbPendaftar::where('status', 'pending')->count())
                ->description('Menunggu verifikasi')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info'),
        ];
    }
}
```

### Task 5.9: Role & Permissions (Spatie)

```bash
composer require spatie/laravel-permission

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

php artisan migrate
```

**Seeder**: `database/seeders/RolePermissionSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view_students',
            'create_students',
            'edit_students',
            'delete_students',
            'view_teachers',
            'create_teachers',
            'edit_teachers',
            'delete_teachers',
            'view_payments',
            'create_payments',
            'verify_payments',
            'view_grades',
            'input_grades',
            'view_ppdb',
            'approve_ppdb',
            // ... add more as needed
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_students', 'create_students', 'edit_students',
            'view_teachers', 'view_payments', 'view_grades'
        ]);

        $guru = Role::create(['name' => 'guru']);
        $guru->givePermissionTo(['view_students', 'view_grades', 'input_grades']);

        $keuangan = Role::create(['name' => 'keuangan']);
        $keuangan->givePermissionTo(['view_payments', 'create_payments', 'verify_payments']);
    }
}
```

**Run Seeder**:
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Task 5.10: Protect Filament with Roles

**File**: `app/Filament/Resources/StudentResource.php`

```php
public static function canViewAny(): bool
{
    return auth()->user()->can('view_students');
}

public static function canCreate(): bool
{
    return auth()->user()->can('create_students');
}

public static function canEdit(Model $record): bool
{
    return auth()->user()->can('edit_students');
}

public static function canDelete(Model $record): bool
{
    return auth()->user()->can('delete_students');
}
```

### Task 5.11: Update Routes

**File**: `routes/web.php`

Filament auto-register routes di `/admin`, jadi routes manual tidak perlu diubah.

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\PortalController;

// Public routes (Phase 1-4)
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::prefix('ppdb')->name('ppdb.')->group(function() {
    Route::get('/', [PpdbController::class, 'index'])->name('index');
    Route::get('/daftar', [PpdbController::class, 'daftar'])->name('daftar');
    Route::post('/daftar', [PpdbController::class, 'storeDaftar'])->name('daftar.store');
    Route::get('/cek-status', [PpdbController::class, 'cek'])->name('cek');
});

Route::prefix('portal')->name('portal.')->group(function() {
    Route::get('/', [PortalController::class, 'index'])->name('index');
});

// Filament admin routes auto-registered at /admin
// Access: http://localhost:8000/admin
```

## Phase 5 Validation Checklist

- ✅ Filament installed successfully
- ✅ Admin user created, can login at `/admin`
- ✅ Migrations run without errors
- ✅ At least 5 Resources generated (Student, Teacher, Payment, etc)
- ✅ Dashboard widgets showing stats
- ✅ Navigation grouped properly
- ✅ Table columns & filters working
- ✅ Form validation working
- ✅ CRUD operations functional
- ✅ Role & permissions seeded
- ✅ Public routes (/, /ppdb, /portal) still accessible

## Phase 5 Deliverables

1. **Composer packages installed**:
   - filament/filament
   - spatie/laravel-permission

2. **Migrations** (10+ files):
   - ppdb_pendaftar
   - tes_masuk
   - subjects (extended)
   - penugasan_guru
   - inventaris_aset
   - (use Phase 3 migrations for students, teachers, payments, etc)

3. **Filament Resources** (11+ files):
   - StudentResource.php
   - TeacherResource.php
   - PaymentResource.php
   - PpdbPendaftarResource.php
   - TesMasukResource.php
   - SubjectResource.php
   - GradeResource.php
   - AttendanceResource.php
   - ClassResource.php
   - PenugasanGuruResource.php
   - InventarisAsetResource.php

4. **Widgets**:
   - StatsOverview.php

5. **Seeders**:
   - RolePermissionSeeder.php

6. **Config**:
   - config/filament.php (published & configured)

## Phase 5 Notes

**Token Optimization**:
- Gunakan `--generate` flag → Filament auto-create form & table
- Copy-paste pattern dari StudentResource ke resources lain
- Sesuaikan field labels & validation per resource
- JANGAN generate semua 35 resources sekaligus!
- Priority: 10-12 core resources dulu (Phase 5)
- Sisanya bisa di Phase 6 atau on-demand

**Next Steps** (Phase 6 - Optional):
- Generate remaining 20+ resources
- Add custom actions (export Excel, print rapor, etc)
- Relation managers (Siswa → Nilai, Guru → Penugasan)
- Advanced filters & search
- Custom pages (e.g., Rapor generator, Slip gaji)

---

**END OF PROMPT FILE**
