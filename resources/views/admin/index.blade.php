@extends('layouts.admin')
@section('title','SIMS Admin')
@section('content')
<script>
window.ADMIN_RBAC = @json($adminRbac ?? ['user' => null, 'modules' => []]);
</script>
<div style="display:flex;height:100vh;overflow:hidden;">

  {{-- SIDEBAR --}}
  <div id="sidebar">
    <div class="sb-logo">
      <div class="sb-icon">S</div>
      <div id="sb-title" class="sb-title-wrap">
        <div>SIMS Admin</div>
        <small>SMA MA'ARIF KROYA</small>
      </div>
      <button id="sb-toggle" onclick="toggleSidebar()">←</button>
    </div>
    <div style="padding:8px 8px 0;flex-shrink:0;">
      <button id="btn-home" onclick="showDashboard()" class="sb-home sb-home-active">
        <span>🏠</span><span class="sb-label"> Dashboard</span>
      </button>
    </div>
    <div id="sb-modules" style="flex:1;overflow-y:auto;padding:8px;"></div>
    <div id="sb-back" style="padding:12px 8px;border-top:1px solid rgba(255,255,255,0.07);flex-shrink:0;">
      <a href="{{ route('landing') }}" class="sb-backlink">
        <span>🌐</span><span class="sb-label"> Ke Website Sekolah</span>
      </a>
    </div>
  </div>

  {{-- MAIN --}}
  <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;">
    <div class="topbar">
      <div id="tb-title" style="flex:1;">
        <div style="font-size:1rem;font-weight:700;color:#111827;">Dashboard</div>
      </div>
      <div class="search-wrap">
        <span style="color:#9CA3AF;font-size:0.85rem;">🔍</span>
        <input id="search" placeholder="Cari data..." oninput="doSearch()" class="search-input">
      </div>
      <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:8px;height:8px;border-radius:50%;background:#16A34A;box-shadow:0 0 6px #16A34A;"></div>
        <span style="font-size:0.82rem;font-weight:600;color:#374151;">{{ auth()->user()->name ?? 'Admin' }}</span>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" style="padding:7px 10px;border-radius:8px;border:1px solid #E5E7EB;background:white;cursor:pointer;font-size:0.78rem;font-weight:700;color:#374151;">Keluar</button>
        </form>
        <div style="width:32px;height:32px;border-radius:50%;background:#1B6B3A;display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;color:white;">{{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}</div>
      </div>
    </div>
    <div id="main-content" style="flex:1;overflow-y:auto;padding:24px;"></div>
  </div>
</div>

{{-- MODAL --}}
<div id="modal-overlay" onclick="closeModal()">
  <div id="modal-box" onclick="event.stopPropagation()">
    <div id="modal-hdr"></div>
    <div id="modal-body" style="padding:20px 24px;overflow-y:auto;flex:1;"></div>
    <div style="padding:14px 24px;border-top:1px solid #F3F4F6;display:flex;gap:10px;justify-content:flex-end;">
      <button onclick="closeModal()" class="btn-cancel">Batal</button>
      <button id="btn-save" onclick="saveModal()">Simpan Data</button>
    </div>
  </div>
</div>
@endsection
