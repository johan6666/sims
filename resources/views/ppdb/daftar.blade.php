@extends('layouts.app')

@section('title', 'Formulir Pendaftaran - PPDB SMA MA\'ARIF KROYA')

@section('content')

<x-ppdb-nav active="daftar" />

<div style="background:#F0FDF4;min-height:100vh;padding:40px 5vw;">
  <div style="max-width:720px;margin:0 auto;">

    <!-- Header -->
    <div style="text-align:center;margin-bottom:32px;">
      <h2 style="font-size:1.6rem;font-weight:800;color:#111827;margin-bottom:4px;font-family:'Syne',sans-serif;">Formulir Pendaftaran</h2>
      <p style="color:#6B7280;font-size:0.875rem;">PPDB SMA MA'ARIF KROYA Tahun Ajaran 2026/2027</p>
    </div>

    <!-- Step Indicator -->
    <div style="display:flex;align-items:center;margin-bottom:32px;" id="step-indicator">
      @php $steps = ['Data Diri', 'Data Keluarga', 'Pilihan & Berkas']; @endphp
      @foreach($steps as $i => $label)
        <div style="display:flex;align-items:center;gap:8px;">
          <div class="step-circle" id="circle-{{ $i+1 }}" style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;background:{{ $i === 0 ? '#1B6B3A' : '#E5E7EB' }};color:{{ $i === 0 ? 'white' : '#9CA3AF' }};">{{ $i+1 }}</div>
          <span class="step-label" id="label-{{ $i+1 }}" style="font-size:0.8rem;font-weight:600;color:{{ $i === 0 ? '#1B6B3A' : '#9CA3AF' }};">{{ $label }}</span>
        </div>
        @if(!$loop->last)
        <div class="step-line" id="line-{{ $i+1 }}" style="flex:1;height:2px;background:#E5E7EB;margin:0 12px;"></div>
        @endif
      @endforeach
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('ppdb.daftar.store') }}" id="ppdb-form">
      @csrf

      @if($errors->any())
      <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:16px;margin-bottom:20px;">
        <ul style="list-style:none;padding:0;margin:0;">
          @foreach($errors->all() as $error)
          <li style="font-size:0.85rem;color:#DC2626;">• {{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div style="background:white;border-radius:16px;padding:28px;border:1px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.05);">

        <!-- Step 1: Data Diri -->
        <div class="form-step" id="form-step-1">
          <h3 style="font-weight:700;margin-bottom:20px;color:#1B6B3A;">📋 Data Diri Calon Siswa</h3>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Nama Lengkap <span style="color:#DC2626;">*</span></label>
              <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Sesuai akta lahir" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Email <span style="color:#DC2626;">*</span></label>
              <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">No. HP / WhatsApp <span style="color:#DC2626;">*</span></label>
              <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Tanggal Lahir <span style="color:#DC2626;">*</span></label>
              <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Tempat Lahir <span style="color:#DC2626;">*</span></label>
              <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Jenis Kelamin <span style="color:#DC2626;">*</span></label>
              <select name="jenis_kelamin" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;background:white;">
                <option value="">Pilih</option>
                <option value="Laki-laki"  {{ old('jenis_kelamin') === 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan"  {{ old('jenis_kelamin') === 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Agama</label>
              <select name="agama" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;background:white;">
                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                <option value="{{ $agama }}" {{ old('agama','Islam') === $agama ? 'selected' : '' }}>{{ $agama }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Asal Sekolah <span style="color:#DC2626;">*</span></label>
              <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Nama SMP/MTs asal" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Alamat Lengkap <span style="color:#DC2626;">*</span></label>
              <textarea name="alamat" rows="3" placeholder="Jl. ..., RT/RW, Desa/Kelurahan, Kecamatan" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;resize:vertical;">{{ old('alamat') }}</textarea>
            </div>
          </div>
        </div>

        <!-- Step 2: Data Keluarga -->
        <div class="form-step" id="form-step-2" style="display:none;">
          <h3 style="font-weight:700;margin-bottom:20px;color:#1B6B3A;">👨‍👩‍👦 Data Orang Tua / Wali</h3>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Nama Ayah / Wali <span style="color:#DC2626;">*</span></label>
              <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Nama Ibu <span style="color:#DC2626;">*</span></label>
              <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">No. HP Ayah / Wali <span style="color:#DC2626;">*</span></label>
              <input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah') }}" placeholder="08xxxxxxxxxx" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Pekerjaan Ayah / Wali</label>
              <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Penghasilan Bulanan</label>
              <select name="penghasilan_ortu" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;background:white;">
                <option value="">Pilih rentang</option>
                @foreach(['< Rp 1 juta','Rp 1-3 juta','Rp 3-5 juta','Rp 5-10 juta','> Rp 10 juta'] as $opt)
                <option value="{{ $opt }}" {{ old('penghasilan_ortu') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <!-- Step 3: Pilihan & Berkas -->
        <div class="form-step" id="form-step-3" style="display:none;">
          <h3 style="font-weight:700;margin-bottom:20px;color:#1B6B3A;">📚 Pilihan & Informasi Tambahan</h3>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Pilihan Jurusan <span style="color:#DC2626;">*</span></label>
              <select name="pilihan_jurusan" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;background:white;">
                <option value="">Pilih</option>
                <option value="IPA" {{ old('pilihan_jurusan') === 'IPA' ? 'selected' : '' }}>IPA (Ilmu Pengetahuan Alam)</option>
                <option value="IPS" {{ old('pilihan_jurusan') === 'IPS' ? 'selected' : '' }}>IPS (Ilmu Pengetahuan Sosial)</option>
              </select>
            </div>
            <div>
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Nilai Rata-rata Rapor</label>
              <input type="number" name="nilai_rata_rapor" value="{{ old('nilai_rata_rapor') }}" placeholder="Skala 100" min="0" max="100" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;">
            </div>
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Prestasi yang Pernah Diraih</label>
              <textarea name="prestasi" rows="2" placeholder="Contoh: Juara 1 Olimpiade Matematika Kabupaten 2025" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;resize:vertical;">{{ old('prestasi') }}</textarea>
            </div>
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:5px;">Alasan Memilih SMA MA'ARIF KROYA <span style="color:#DC2626;">*</span></label>
              <textarea name="alasan" rows="3" placeholder="Jelaskan motivasi Anda..." style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;resize:vertical;">{{ old('alasan') }}</textarea>
            </div>
            <div style="grid-column:1/-1;">
              <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:8px;">📎 Upload Dokumen (Rapor, Akta Lahir, KK)</label>
              <div style="border:2px dashed #D1D5DB;border-radius:10px;padding:28px;text-align:center;background:#F9FAFB;cursor:pointer;">
                <div style="font-size:1.5rem;margin-bottom:6px;">📁</div>
                <div style="font-size:0.82rem;color:#6B7280;">Klik untuk upload atau drag & drop</div>
                <div style="font-size:0.72rem;color:#9CA3AF;margin-top:4px;">PDF, JPG, PNG maks. 5MB</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div style="display:flex;justify-content:space-between;margin-top:24px;padding-top:20px;border-top:1px solid #F3F4F6;">
          <button type="button" id="btn-prev" onclick="prevStep()" style="padding:10px 20px;border-radius:8px;border:1px solid #E5E7EB;background:white;cursor:pointer;font-weight:600;font-size:0.875rem;opacity:0.4;pointer-events:none;">← Sebelumnya</button>
          <button type="button" id="btn-next" onclick="nextStep()" style="padding:10px 24px;border-radius:8px;border:none;background:#1B6B3A;color:white;cursor:pointer;font-weight:700;font-size:0.875rem;">Selanjutnya →</button>
          <button type="submit" id="btn-submit" style="display:none;padding:10px 28px;border-radius:8px;border:none;background:linear-gradient(135deg,#C9932A,#E5A830);color:white;cursor:pointer;font-weight:800;font-size:0.875rem;box-shadow:0 4px 16px rgba(201,147,42,0.4);">✅ Kirim Pendaftaran</button>
        </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = 3;

function showStep(step) {
  document.querySelectorAll('.form-step').forEach(el => el.style.display = 'none');
  document.getElementById('form-step-' + step).style.display = 'block';

  for (let i = 1; i <= totalSteps; i++) {
    const circle = document.getElementById('circle-' + i);
    const label  = document.getElementById('label-' + i);
    if (i < step) {
      circle.style.background = '#1B6B3A'; circle.style.color = 'white'; circle.textContent = '✓';
    } else if (i === step) {
      circle.style.background = '#1B6B3A'; circle.style.color = 'white'; circle.textContent = i;
    } else {
      circle.style.background = '#E5E7EB'; circle.style.color = '#9CA3AF'; circle.textContent = i;
    }
    label.style.color = i === step ? '#1B6B3A' : '#9CA3AF';
    if (i < totalSteps) {
      const line = document.getElementById('line-' + i);
      if (line) line.style.background = i < step ? '#1B6B3A' : '#E5E7EB';
    }
  }

  const btnPrev   = document.getElementById('btn-prev');
  const btnNext   = document.getElementById('btn-next');
  const btnSubmit = document.getElementById('btn-submit');

  if (step === 1) {
    btnPrev.style.opacity = '0.4'; btnPrev.style.pointerEvents = 'none';
  } else {
    btnPrev.style.opacity = '1'; btnPrev.style.pointerEvents = 'auto';
  }

  if (step < totalSteps) {
    btnNext.style.display = 'inline-block'; btnSubmit.style.display = 'none';
  } else {
    btnNext.style.display = 'none'; btnSubmit.style.display = 'inline-block';
  }
}

function nextStep() {
  if (currentStep < totalSteps) { currentStep++; showStep(currentStep); }
}

function prevStep() {
  if (currentStep > 1) { currentStep--; showStep(currentStep); }
}

showStep(1);
</script>
@endpush

@endsection
