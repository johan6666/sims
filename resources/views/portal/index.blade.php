@extends('layouts.app')

@section('title', 'Portal Siswa - SMA MA\'ARIF KROYA')

@section('content')

<x-ppdb-nav active="portal" />

<div style="background:#F0FDF4;min-height:100vh;padding:0;">

  <!-- Login Screen -->
  <div id="login-screen" style="min-height:90vh;display:flex;align-items:center;justify-content:center;padding:40px 5vw;">
    <div style="background:white;border-radius:20px;padding:40px;max-width:400px;width:100%;box-shadow:0 8px 40px rgba(0,0,0,0.08);border:1px solid #E5E7EB;">
      <div style="text-align:center;margin-bottom:28px;">
        <div style="width:56px;height:56px;border-radius:14px;background:#1B6B3A;display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 12px;">👤</div>
        <h3 style="font-weight:800;color:#111827;margin-bottom:4px;font-family:'Syne',sans-serif;">Portal Siswa</h3>
        <p style="font-size:0.82rem;color:#6B7280;">SMA MA'ARIF KROYA</p>
      </div>
      <div style="margin-bottom:14px;">
        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">NISN / Username</label>
        <input id="login-nisn" type="text" placeholder="Masukkan NISN Anda" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
      </div>
      <div style="margin-bottom:20px;">
        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Password</label>
        <input id="login-pass" type="password" placeholder="Password" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
      </div>
      <button onclick="doLogin()" style="width:100%;padding:11px;border-radius:10px;border:none;background:#1B6B3A;color:white;font-weight:700;cursor:pointer;font-size:0.925rem;">Masuk Portal</button>

      <!-- Demo hint -->
      <div style="margin-top:16px;background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;padding:12px 14px;">
        <div style="font-size:0.72rem;font-weight:700;color:#1B6B3A;margin-bottom:8px;">🧪 Akun Demo Tersedia:</div>
        <button onclick="demoLogin('1234567890','demo123')" style="width:100%;padding:9px 12px;border-radius:8px;border:1px dashed #1B6B3A;background:white;cursor:pointer;text-align:left;font-size:0.8rem;color:#374151;display:flex;justify-content:space-between;align-items:center;">
          <span>👨‍🎓 <strong>Ahmad Fauzi</strong> — X-A IPA</span>
          <span style="font-size:0.72rem;color:#1B6B3A;font-weight:700;">Klik untuk login →</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Portal Content -->
  <div id="portal-content" style="display:none;max-width:900px;margin:0 auto;padding:32px 5vw;">

    <!-- Header Siswa -->
    <div style="background:linear-gradient(135deg,#1B6B3A,#22854A);border-radius:16px;padding:24px;display:flex;align-items:center;gap:16px;margin-bottom:24px;color:white;">
      <div style="width:56px;height:56px;border-radius:14px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">🎓</div>
      <div style="flex:1;">
        <div style="font-weight:800;font-size:1.1rem;font-family:'Syne',sans-serif;">{{ $siswa['nama'] }}</div>
        <div style="font-size:0.8rem;color:rgba(255,255,255,0.75);">NISN: {{ $siswa['nisn'] }} · Kelas {{ $siswa['kelas'] }} · TA {{ $siswa['ta'] }}</div>
      </div>
      <button onclick="doLogout()" style="padding:7px 14px;border-radius:8px;border:1px solid rgba(255,255,255,0.3);background:rgba(255,255,255,0.1);color:white;cursor:pointer;font-size:0.8rem;font-weight:600;">Keluar</button>
    </div>

    <!-- Tabs -->
    <div style="display:flex;gap:4px;background:white;border-radius:12px;padding:4px;border:1px solid #E5E7EB;margin-bottom:20px;">
      @foreach([['nilai','📊 Nilai'],['absensi','📅 Absensi'],['tagihan','💰 Tagihan SPP'],['profil','👤 Profil']] as [$tabId, $tabLabel])
      <button class="tab-btn" data-tab="{{ $tabId }}" onclick="showTab('{{ $tabId }}')"
        style="flex:1;padding:9px;border-radius:8px;border:none;cursor:pointer;font-size:0.82rem;font-weight:600;transition:all 0.2s;{{ $tabId === 'nilai' ? 'background:#1B6B3A;color:white;' : 'background:none;color:#6B7280;' }}">
        {{ $tabLabel }}
      </button>
      @endforeach
    </div>

    <!-- Tab Contents -->
    <div style="background:white;border-radius:16px;border:1px solid #E5E7EB;overflow:hidden;">

      <!-- Nilai -->
      <div class="tab-content" id="tab-nilai">
        <div style="padding:16px 20px;border-bottom:1px solid #F3F4F6;font-weight:700;color:#111827;">Nilai Semester 2 — {{ $siswa['ta'] }}</div>
        <div style="overflow-x:auto;">
          <table style="width:100%;border-collapse:collapse;font-size:0.855rem;">
            <thead>
              <tr style="background:#F9FAFB;">
                @foreach(['Mata Pelajaran','UH 1','UH 2','UTS','UAS','Nilai Akhir','Predikat'] as $h)
                <th style="padding:10px 16px;text-align:left;font-size:0.72rem;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:0.05em;">{{ $h }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @foreach($nilai as $row)
              @php
                $pc = match($row['predikat']) { 'A' => ['#F0FDF4','#16A34A'], 'B' => ['#EFF6FF','#2563EB'], default => ['#FEF9C3','#CA8A04'] };
              @endphp
              <tr style="border-top:1px solid #F3F4F6;">
                <td style="padding:10px 16px;font-weight:600;color:#111827;">{{ $row['mapel'] }}</td>
                <td style="padding:10px 16px;color:#374151;">{{ $row['uh1'] }}</td>
                <td style="padding:10px 16px;color:#374151;">{{ $row['uh2'] }}</td>
                <td style="padding:10px 16px;color:#374151;">{{ $row['uts'] }}</td>
                <td style="padding:10px 16px;color:#374151;">{{ $row['uas'] }}</td>
                <td style="padding:10px 16px;font-weight:700;color:#1B6B3A;font-size:0.95rem;">{{ $row['akhir'] }}</td>
                <td style="padding:10px 16px;">
                  <span style="background:{{ $pc[0] }};color:{{ $pc[1] }};padding:2px 10px;border-radius:100px;font-weight:700;font-size:0.78rem;">{{ $row['predikat'] }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Absensi -->
      <div class="tab-content" id="tab-absensi" style="display:none;">
        <div style="padding:16px 20px;border-bottom:1px solid #F3F4F6;font-weight:700;color:#111827;">Rekap Absensi {{ $siswa['ta'] }}</div>
        <table style="width:100%;border-collapse:collapse;font-size:0.855rem;">
          <thead>
            <tr style="background:#F9FAFB;">
              @foreach(['Bulan','Hadir','Sakit','Izin','Bolos','Total Hari','Persentase'] as $h)
              <th style="padding:10px 16px;text-align:left;font-size:0.72rem;font-weight:700;color:#6B7280;text-transform:uppercase;">{{ $h }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($absensi as $row)
            <tr style="border-top:1px solid #F3F4F6;">
              <td style="padding:10px 16px;font-weight:600;">{{ $row['bulan'] }}</td>
              <td style="padding:10px 16px;color:#16A34A;font-weight:700;">{{ $row['hadir'] }}</td>
              <td style="padding:10px 16px;color:#D97706;">{{ $row['sakit'] }}</td>
              <td style="padding:10px 16px;color:#2563EB;">{{ $row['izin'] }}</td>
              <td style="padding:10px 16px;color:#DC2626;">{{ $row['bolos'] }}</td>
              <td style="padding:10px 16px;color:#6B7280;">{{ $row['total'] }}</td>
              <td style="padding:10px 16px;font-weight:700;color:#16A34A;">{{ number_format($row['hadir'] / $row['total'] * 100, 1) }}%</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Tagihan -->
      <div class="tab-content" id="tab-tagihan" style="display:none;">
        @php $belumBayar = collect($tagihan)->where('status','belum_dibayar')->sum('nominal'); @endphp
        <div style="padding:16px 20px;border-bottom:1px solid #F3F4F6;font-weight:700;color:#111827;display:flex;justify-content:space-between;align-items:center;">
          <span>Tagihan SPP {{ $siswa['ta'] }}</span>
          @if($belumBayar > 0)
          <span style="background:#FEF2F2;color:#DC2626;padding:4px 12px;border-radius:100px;font-size:0.75rem;font-weight:700;">Rp {{ number_format($belumBayar,0,',','.') }} belum dibayar</span>
          @endif
        </div>
        <table style="width:100%;border-collapse:collapse;font-size:0.855rem;">
          <thead>
            <tr style="background:#F9FAFB;">
              @foreach(['Bulan','Nominal','Status','Tanggal Bayar','Aksi'] as $h)
              <th style="padding:10px 16px;text-align:left;font-size:0.72rem;font-weight:700;color:#6B7280;text-transform:uppercase;">{{ $h }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($tagihan as $row)
            @php
              $isLunas = $row['status'] === 'lunas';
              $statusColor = $isLunas ? '#16A34A' : '#DC2626';
            @endphp
            <tr style="border-top:1px solid #F3F4F6;">
              <td style="padding:10px 16px;font-weight:600;">{{ $row['bulan'] }}</td>
              <td style="padding:10px 16px;">Rp {{ number_format($row['nominal'],0,',','.') }}</td>
              <td style="padding:10px 16px;">
                <span style="background:{{ $statusColor }}15;color:{{ $statusColor }};padding:2px 10px;border-radius:100px;font-weight:700;font-size:0.75rem;">
                  {{ $isLunas ? '✓ Lunas' : '⚠ Belum Dibayar' }}
                </span>
              </td>
              <td style="padding:10px 16px;color:#6B7280;">{{ $row['tanggal_bayar'] ?? '—' }}</td>
              <td style="padding:10px 16px;">
                @if(!$isLunas)
                <button style="padding:5px 14px;border-radius:6px;border:none;background:#1B6B3A;color:white;font-size:0.75rem;font-weight:700;cursor:pointer;">Bayar Sekarang</button>
                @else
                <button style="padding:5px 14px;border-radius:6px;border:1px solid #E5E7EB;background:white;color:#6B7280;font-size:0.75rem;cursor:pointer;">Unduh Kwitansi</button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Profil -->
      <div class="tab-content" id="tab-profil" style="display:none;padding:24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          @foreach($profil as $item)
          <div style="background:#F9FAFB;border-radius:8px;padding:12px 14px;">
            <div style="font-size:0.72rem;color:#9CA3AF;font-weight:600;margin-bottom:3px;">{{ $item['label'] }}</div>
            <div style="font-size:0.875rem;font-weight:600;color:#111827;">{{ $item['value'] }}</div>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
function showTab(id) {
  document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
  document.querySelectorAll('.tab-btn').forEach(btn => {
    const active = btn.dataset.tab === id;
    btn.style.background = active ? '#1B6B3A' : 'none';
    btn.style.color = active ? 'white' : '#6B7280';
  });
  document.getElementById('tab-' + id).style.display = 'block';
}

function doLogin() {
  const nisn = document.getElementById('login-nisn').value.trim();
  const pass = document.getElementById('login-pass').value.trim();
  if (nisn && pass) {
    document.getElementById('login-screen').style.display = 'none';
    document.getElementById('portal-content').style.display = 'block';
    window.scrollTo(0, 0);
  }
}

function demoLogin(nisn, pass) {
  document.getElementById('login-nisn').value = nisn;
  document.getElementById('login-pass').value = pass;
  doLogin();
}

function doLogout() {
  document.getElementById('portal-content').style.display = 'none';
  document.getElementById('login-screen').style.display = 'flex';
  document.getElementById('login-nisn').value = '';
  document.getElementById('login-pass').value = '';
  window.scrollTo(0, 0);
}

document.getElementById('login-pass').addEventListener('keydown', e => {
  if (e.key === 'Enter') doLogin();
});
</script>
@endpush

@endsection
