<nav style="background:white;border-bottom:2px solid #E8F5EE;padding:0 5vw;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
  <a href="{{ route('landing') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
    <div style="width:36px;height:36px;border-radius:8px;background:#1B6B3A;display:flex;align-items:center;justify-content:center;font-weight:800;color:white;font-size:0.9rem;font-family:'Syne',sans-serif;">MA</div>
    <div>
      <div style="font-size:0.85rem;font-weight:800;color:#1B6B3A;line-height:1;font-family:'Syne',sans-serif;">SMA MA'ARIF KROYA</div>
      <div style="font-size:0.65rem;color:#6B7280;">PPDB & Portal Siswa 2026/2027</div>
    </div>
  </a>
  <div style="display:flex;gap:4px;">
    <a href="{{ route('ppdb.index') }}"  style="padding:7px 14px;border-radius:8px;text-decoration:none;font-size:0.8rem;font-weight:600;{{ $active === 'home'   ? 'background:#1B6B3A;color:white;' : 'color:#374151;' }}">🏠 Beranda</a>
    <a href="{{ route('ppdb.daftar') }}" style="padding:7px 14px;border-radius:8px;text-decoration:none;font-size:0.8rem;font-weight:600;{{ $active === 'daftar' ? 'background:#1B6B3A;color:white;' : 'color:#374151;' }}">📝 Daftar</a>
    <a href="{{ route('ppdb.cek') }}"    style="padding:7px 14px;border-radius:8px;text-decoration:none;font-size:0.8rem;font-weight:600;{{ $active === 'cek'    ? 'background:#1B6B3A;color:white;' : 'color:#374151;' }}">🔍 Cek Status</a>
    <a href="{{ route('portal.index') }}" style="padding:7px 14px;border-radius:8px;text-decoration:none;font-size:0.8rem;font-weight:600;{{ $active === 'portal' ? 'background:#1B6B3A;color:white;' : 'color:#374151;' }}">👤 Portal Siswa</a>
  </div>
</nav>
