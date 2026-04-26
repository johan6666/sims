@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran - PPDB SMA MA\'ARIF KROYA')

@section('content')

<x-ppdb-nav active="cek" />

<div style="background:#F0FDF4;min-height:100vh;padding:50px 5vw;">
  <div style="max-width:600px;margin:0 auto;">

    {{-- Success redirect dari form daftar --}}
    @if(session('success'))
    <div style="background:#F0FDF4;border:2px solid #1B6B3A;border-radius:16px;padding:24px;margin-bottom:28px;text-align:center;">
      <div style="font-size:2.5rem;margin-bottom:10px;">🎉</div>
      <h3 style="font-weight:800;color:#111827;margin-bottom:6px;">Pendaftaran Berhasil!</h3>
      <p style="color:#6B7280;margin-bottom:16px;">Simpan nomor pendaftaran berikut untuk cek status.</p>
      <div style="background:white;border:2px dashed #1B6B3A;border-radius:12px;padding:20px;margin-bottom:16px;">
        <div style="font-size:0.75rem;color:#6B7280;margin-bottom:4px;">Nomor Pendaftaran</div>
        <div style="font-size:1.8rem;font-weight:800;color:#1B6B3A;letter-spacing:0.05em;">{{ session('no_pendaftaran') }}</div>
      </div>
      <p style="font-size:0.82rem;color:#6B7280;">Informasi akan dikirim ke <strong>{{ session('email_daftar') }}</strong></p>
    </div>
    @endif

    <div style="text-align:center;margin-bottom:32px;">
      <div style="font-size:2.5rem;margin-bottom:12px;">🔍</div>
      <h2 style="font-size:1.6rem;font-weight:800;color:#111827;margin-bottom:8px;font-family:'Syne',sans-serif;">Cek Status Pendaftaran</h2>
      <p style="color:#6B7280;font-size:0.9rem;">Masukkan nomor pendaftaran, email, atau no. HP yang didaftarkan</p>
    </div>

    <!-- Search Form -->
    <div style="background:white;border-radius:16px;padding:28px;border:1px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.05);margin-bottom:20px;">
      <div style="display:flex;gap:10px;">
        <input id="cek-input" type="text"
          placeholder="Contoh: PPDB-2026-001 atau email@gmail.com"
          style="flex:1;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
        <button onclick="cekStatus()" style="padding:9px 20px;border-radius:8px;border:none;background:#1B6B3A;color:white;cursor:pointer;font-weight:700;font-size:0.875rem;white-space:nowrap;">Cek →</button>
      </div>
      <p style="font-size:0.72rem;color:#9CA3AF;margin-top:8px;">
        💡 Demo: coba <strong>PPDB-2026-001</strong> (diterima) · <strong>PPDB-2026-002</strong> (pending) · <strong>PPDB-2026-003</strong> (ditolak)
      </p>
    </div>

    <!-- Result -->
    <div id="cek-result"></div>

  </div>
</div>

@push('scripts')
<script>
const dummyData = [
  {id:'PPDB-2026-001', nama_lengkap:'Ahmad Fauzi',  email:'fauzi@gmail.com',  no_hp:'081234567890', asal_sekolah:'SMP N 1 Kroya',  pilihan_jurusan:'IPA', tanggal_daftar:'2026-03-10', status:'approved',  nilai_tes:88.5},
  {id:'PPDB-2026-002', nama_lengkap:'Siti Rahayu',  email:'rahayu@gmail.com', no_hp:'082345678901', asal_sekolah:'SMP N 2 Kroya',  pilihan_jurusan:'IPS', tanggal_daftar:'2026-03-15', status:'pending',   nilai_tes:null},
  {id:'PPDB-2026-003', nama_lengkap:'Budi Santoso', email:'budi@gmail.com',   no_hp:'083456789012', asal_sekolah:'MTs Kroya',       pilihan_jurusan:'IPA', tanggal_daftar:'2026-03-12', status:'rejected',  nilai_tes:45.0},
];

const statusConfig = {
  pending:  {label:'Sedang Diproses',      color:'#D97706', bg:'#FFFBEB', icon:'⏳', desc:'Pendaftaran Anda sudah diterima dan sedang dalam proses verifikasi dokumen.'},
  approved: {label:'DITERIMA ✓',           color:'#16A34A', bg:'#F0FDF4', icon:'🎉', desc:'Selamat! Anda dinyatakan DITERIMA di SMA MA\'ARIF KROYA. Segera lakukan daftar ulang.'},
  rejected: {label:'Tidak Diterima',       color:'#DC2626', bg:'#FEF2F2', icon:'😔', desc:'Mohon maaf, Anda belum berhasil diterima pada seleksi kali ini. Terima kasih telah mendaftar.'},
  verified: {label:'Siap Tes',             color:'#7C3AED', bg:'#F5F3FF', icon:'📋', desc:'Dokumen terverifikasi. Silakan ikuti tes seleksi sesuai jadwal.'},
};

function cekStatus() {
  const q = document.getElementById('cek-input').value.trim().toLowerCase();
  const result = document.getElementById('cek-result');
  if (!q) return;

  const found = dummyData.find(d =>
    d.id.toLowerCase() === q ||
    d.email.toLowerCase() === q ||
    d.no_hp === q
  );

  if (!found) {
    result.innerHTML = `
      <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:12px;padding:20px;text-align:center;">
        <div style="font-size:1.5rem;margin-bottom:8px;">❌</div>
        <div style="font-weight:700;color:#DC2626;margin-bottom:4px;">Data tidak ditemukan</div>
        <div style="font-size:0.82rem;color:#6B7280;">Periksa kembali nomor pendaftaran, email, atau no. HP Anda.</div>
      </div>`;
    return;
  }

  const info = statusConfig[found.status] || statusConfig.pending;
  result.innerHTML = `
    <div style="background:${info.bg};border:2px solid ${info.color}30;border-radius:16px;padding:24px;">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid ${info.color}20;">
        <div style="font-size:2rem;">${info.icon}</div>
        <div>
          <div style="font-size:0.72rem;font-weight:700;color:${info.color};text-transform:uppercase;letter-spacing:0.08em;margin-bottom:3px;">Status Pendaftaran</div>
          <div style="font-size:1.2rem;font-weight:800;color:${info.color};">${info.label}</div>
        </div>
        <div style="margin-left:auto;background:${info.color};color:white;padding:4px 12px;border-radius:100px;font-size:0.72rem;font-weight:700;">${found.id}</div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
        ${[
          ['Nama', found.nama_lengkap],
          ['Asal Sekolah', found.asal_sekolah],
          ['Pilihan Jurusan', found.pilihan_jurusan],
          ['Tanggal Daftar', found.tanggal_daftar],
          ...(found.nilai_tes !== null ? [['Nilai Tes', found.nilai_tes]] : [])
        ].map(([l,v]) => `
          <div style="background:white;border-radius:8px;padding:10px 14px;">
            <div style="font-size:0.7rem;color:#9CA3AF;font-weight:600;margin-bottom:2px;">${l}</div>
            <div style="font-size:0.875rem;font-weight:700;color:#111827;">${v || '—'}</div>
          </div>`).join('')}
      </div>
      <div style="background:white;border-radius:8px;padding:14px;border-left:4px solid ${info.color};font-size:0.875rem;color:#374151;line-height:1.6;">
        ${info.desc}
      </div>
      ${found.status === 'approved' ? `
      <div style="margin-top:14px;background:${info.color};border-radius:10px;padding:14px 18px;display:flex;justify-content:space-between;align-items:center;">
        <div style="color:white;font-size:0.875rem;font-weight:600;">📋 Segera lakukan Daftar Ulang sebelum 30 Mei 2026</div>
      </div>` : ''}
    </div>`;
}

document.getElementById('cek-input').addEventListener('keydown', e => {
  if (e.key === 'Enter') cekStatus();
});
</script>
@endpush

@endsection
