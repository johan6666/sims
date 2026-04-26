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
