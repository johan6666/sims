@extends('layouts.app')

@section('title', 'PPDB Online ' . $periode['tahun_ajaran'] . ' - SMA MA\'ARIF KROYA')

@section('content')

<x-ppdb-nav active="home" />

<!-- Hero PPDB -->
<div style="background:linear-gradient(135deg,#0D4A26 0%,#1B6B3A 60%,#22854A 100%);padding:70px 5vw;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;inset:0;opacity:0.04;background-image:url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23fff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E');pointer-events:none;"></div>
  <div style="position:relative;">
    <div style="display:inline-block;background:rgba(201,147,42,0.2);border:1px solid rgba(201,147,42,0.4);color:#E5A830;padding:5px 16px;border-radius:100px;font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:1.5rem;">
      🎓 PPDB Tahun Ajaran {{ $periode['tahun_ajaran'] }}
    </div>
    <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;letter-spacing:-0.03em;line-height:1.1;margin-bottom:1rem;font-family:'Syne',sans-serif;">
      Penerimaan Peserta Didik Baru<br>
      <span style="color:#4ADE80;">SMA MA'ARIF KROYA</span>
    </h1>
    <p style="color:rgba(255,255,255,0.75);max-width:500px;margin:0 auto 2.5rem;font-size:1rem;">
      Daftarkan diri sekarang dan jadilah bagian dari keluarga besar SMA MA'ARIF KROYA. Pendaftaran online 24 jam.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('ppdb.daftar') }}" style="padding:12px 28px;border-radius:10px;background:linear-gradient(135deg,#C9932A,#E5A830);color:white;font-weight:800;font-size:1rem;box-shadow:0 6px 24px rgba(201,147,42,0.4);text-decoration:none;display:inline-block;">
        📝 Daftar Sekarang
      </a>
      <a href="{{ route('ppdb.cek') }}" style="padding:12px 28px;border-radius:10px;border:1px solid rgba(255,255,255,0.3);background:rgba(255,255,255,0.1);color:white;font-weight:700;font-size:1rem;backdrop-filter:blur(8px);text-decoration:none;display:inline-block;">
        🔍 Cek Status Pendaftaran
      </a>
    </div>
  </div>
</div>

<!-- Info Bar -->
<div style="background:#C9932A;padding:1rem 5vw;display:grid;grid-template-columns:repeat(3,1fr);gap:1px;">
  <div style="text-align:center;padding:4px 0;">
    <div style="font-size:0.8rem;font-weight:700;color:white;">📅 Pendaftaran</div>
    <div style="font-size:0.78rem;color:rgba(255,255,255,0.85);">{{ $periode['pendaftaran_mulai'] }} – {{ $periode['pendaftaran_selesai'] }}</div>
  </div>
  <div style="text-align:center;padding:4px 0;">
    <div style="font-size:0.8rem;font-weight:700;color:white;">💻 Tes CBT</div>
    <div style="font-size:0.78rem;color:rgba(255,255,255,0.85);">{{ $periode['tes_cbt_mulai'] }} – {{ $periode['tes_cbt_selesai'] }}</div>
  </div>
  <div style="text-align:center;padding:4px 0;">
    <div style="font-size:0.8rem;font-weight:700;color:white;">📢 Pengumuman</div>
    <div style="font-size:0.78rem;color:rgba(255,255,255,0.85);">{{ $periode['pengumuman'] }}</div>
  </div>
</div>

<!-- Steps -->
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
      <div style="font-size:0.65rem;font-weight:800;color:#C9932A;letter-spacing:0.1em;margin-bottom:6px;">LANGKAH {{ $step['number'] }}</div>
      <h3 style="font-size:1rem;font-weight:700;color:#111827;margin-bottom:8px;">{{ $step['title'] }}</h3>
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
          <span style="color:#16A34A;margin-right:8px;font-weight:700;">✓</span>{{ $item }}
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
          <span style="font-weight:700;color:{{ $harga === 'Gratis' ? '#16A34A' : '#111827' }};">{{ $harga }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<!-- CTA -->
<div style="background:#1B6B3A;padding:50px 5vw;text-align:center;">
  <h2 style="font-size:2rem;font-weight:800;color:white;margin-bottom:1rem;font-family:'Syne',sans-serif;">Siap Bergabung?</h2>
  <p style="color:rgba(255,255,255,0.75);margin-bottom:2rem;font-size:1rem;">Daftar sekarang dan raih masa depan cemerlang bersama SMA MA'ARIF KROYA</p>
  <a href="{{ route('ppdb.daftar') }}" style="padding:14px 32px;border-radius:10px;background:linear-gradient(135deg,#C9932A,#E5A830);color:white;font-weight:800;font-size:1.1rem;text-decoration:none;display:inline-block;box-shadow:0 6px 24px rgba(201,147,42,0.4);">
    📝 Mulai Pendaftaran
  </a>
</div>

@endsection
