@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--cream);text-align:center;padding:2rem;">
  <div>
    <div style="font-family:'Syne',sans-serif;font-size:6rem;font-weight:800;color:var(--green);line-height:1;">404</div>
    <h2 style="margin-bottom:1rem;">Halaman Tidak Ditemukan</h2>
    <p style="color:var(--muted);margin-bottom:2rem;">Halaman yang kamu cari tidak ada atau sudah dipindahkan.</p>
    <a href="{{ route('landing') }}" class="btn-gold">← Kembali ke Beranda</a>
  </div>
</div>
@endsection
