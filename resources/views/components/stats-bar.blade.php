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
