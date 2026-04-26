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
