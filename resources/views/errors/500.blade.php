@extends('layouts.app')

@section('title', '500 - Terjadi Kesalahan')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--cream);text-align:center;padding:2rem;">
  <div>
    <div style="font-family:'Syne',sans-serif;font-size:6rem;font-weight:800;color:var(--gold);line-height:1;">500</div>
    <h2 style="margin-bottom:1rem;">Terjadi Kesalahan Server</h2>
    <p style="color:var(--muted);margin-bottom:2rem;">Maaf, terjadi kesalahan pada server. Silakan coba beberapa saat lagi.</p>
    <a href="{{ route('landing') }}" class="btn-gold">← Kembali ke Beranda</a>
  </div>
</div>
@endsection
