<div class="hero">
  <img class="hero-img" src="{{ $heroImage }}" alt="Gedung Sekolah">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-tag">{{ $tag }}</div>
    <h1>{!! $title !!}</h1>
    <p>{{ $subtitle }}</p>
    <div class="hero-actions">
      <a href="{{ $cta1['url'] }}" class="btn-gold">{{ $cta1['text'] }}</a>
      <a href="{{ $cta2['url'] }}" class="btn-ghost">{{ $cta2['text'] }}</a>
    </div>
  </div>
</div>
