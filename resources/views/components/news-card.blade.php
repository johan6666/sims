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
