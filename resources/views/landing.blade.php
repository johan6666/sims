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

<!-- About Section -->
<div class="section" id="tentang">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;" class="about-grid">
    <div class="about-img-wrap fade-in">
      <img
        class="about-img"
        src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=900&auto=format&fit=crop&q=80"
        alt="Kegiatan Belajar"
      >
      <div class="about-badge">
        <strong>37+</strong>
        <span>Tahun Berpengalaman</span>
      </div>
    </div>
    <div class="fade-in">
      <div class="section-label">Tentang Kami</div>
      <h2>Pendidikan Islami yang Berakar, Berprestasi yang Merata</h2>
      <p class="section-desc">SMA MA'ARIF KROYA adalah sekolah menengah atas berbasis Islam di bawah naungan LP Ma'arif NU Kabupaten Cilacap, berkomitmen menghadirkan pendidikan berkualitas yang mengintegrasikan ilmu umum dan nilai-nilai Islam.</p>
      <div class="vm-cards">
        <div class="vm-card">
          <h4>🎯 Visi</h4>
          <p>Terwujudnya lulusan yang berilmu, beriman, bertaqwa, berakhlak mulia, dan berdaya saing di era global.</p>
        </div>
        <div class="vm-card" style="border-left-color:var(--gold);">
          <h4>🚀 Misi</h4>
          <p>Menyelenggarakan pembelajaran yang inovatif, mengembangkan potensi siswa secara holistik, dan membentuk karakter islami yang kuat.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Portal Section -->
<div class="portal-section" id="portal">
  <div class="portal-inner">
    <div class="section-label">Portal Digital</div>
    <h2 style="color:white;">Sistem Informasi<br>Akademik Sekolah</h2>
    <p class="section-desc">Akses mudah untuk siswa, orang tua, guru, dan staf — semua layanan sekolah tersedia dalam satu platform terintegrasi.</p>

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
</div>

<!-- Gallery Section -->
<div class="section" id="galeri">
  <div class="section-label">Galeri</div>
  <h2>Kehidupan di SMA MA'ARIF KROYA</h2>
  <p class="section-desc">Momen berharga kegiatan belajar mengajar, ekstrakurikuler, dan prestasi siswa kami.</p>

  <div class="gallery-grid fade-in">
    @foreach($gallery as $item)
    <x-gallery-item :image="$item['image']" :caption="$item['caption']" />
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

<x-footer :brand="$footer['brand']" :columns="$footer['columns']" />

@endsection
