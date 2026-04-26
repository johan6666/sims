'use strict';

const SCHEMA = {
  "Dashboard & Reporting": {
    icon:"📊", color:"#059669",
    menus: {
      "KPI Dashboard": { fields:[
        {n:"metric_name",l:"Nama Metrik",t:"text",req:true},
        {n:"metric_type",l:"Tipe Metrik",t:"select",opts:["integer","percentage","currency"]},
        {n:"current_value",l:"Nilai Saat Ini",t:"number"},
        {n:"target_value",l:"Target KPI",t:"number"},
        {n:"period",l:"Periode",t:"date"},
      ]},
      "Custom Reports": { fields:[
        {n:"report_name",l:"Nama Laporan",t:"text",req:true},
        {n:"report_type",l:"Tipe",t:"select",opts:["akademik","finance","siswa","staff"]},
        {n:"is_scheduled",l:"Auto Generate",t:"boolean"},
        {n:"schedule_frequency",l:"Frekuensi",t:"select",opts:["daily","weekly","monthly","yearly"]},
      ]},
    }
  },
  "Penerimaan Siswa": {
    icon:"🎓", color:"#2563EB",
    menus: {
      "Pendaftar Siswa": { fields:[
        {n:"nama_lengkap",l:"Nama Lengkap",t:"text",req:true},
        {n:"email",l:"Email",t:"email",req:true},
        {n:"no_hp",l:"No. HP",t:"text"},
        {n:"asal_sekolah",l:"Asal Sekolah",t:"text"},
        {n:"tanggal_pendaftaran",l:"Tanggal Daftar",t:"date"},
        {n:"status_pendaftaran",l:"Status",t:"select",opts:["pending","submitted","verified","approved","rejected"]},
      ]},
      "Tes Masuk": { fields:[
        {n:"applicant_id",l:"ID Pendaftar",t:"text",req:true},
        {n:"jadwal_tes",l:"Jadwal Tes",t:"datetime-local"},
        {n:"metode_tes",l:"Metode Tes",t:"select",opts:["CBT","tertulis","interview"]},
        {n:"ruangan",l:"Ruangan",t:"text"},
        {n:"nilai_tes",l:"Nilai Tes (0-100)",t:"number"},
        {n:"status_tes",l:"Status",t:"select",opts:["belum_dimulai","berjalan","selesai","absent"]},
        {n:"hasil",l:"Hasil",t:"select",opts:["lulus","tidak_lulus"]},
      ]},
      "Daftar Ulang": { fields:[
        {n:"applicant_id",l:"ID Pendaftar",t:"text",req:true},
        {n:"tanggal_daftar_ulang",l:"Tanggal Daftar Ulang",t:"date"},
        {n:"pembayaran_pertama",l:"Pembayaran DPP (Rp)",t:"number"},
        {n:"dokumen_asli_uploaded",l:"Dokumen Asli Diserahkan",t:"boolean"},
        {n:"status",l:"Status",t:"select",opts:["pending","completed","cancelled"]},
        {n:"keterangan",l:"Keterangan",t:"textarea"},
      ]},
      "ID Card & NISN": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"nisn",l:"NISN",t:"text",req:true},
        {n:"no_id_sekolah",l:"No. ID Sekolah",t:"text"},
        {n:"tanggal_terbit",l:"Tanggal Terbit",t:"date"},
        {n:"tanggal_kadaluarsa",l:"Kadaluarsa",t:"date"},
        {n:"status",l:"Status",t:"select",opts:["active","expired","cancelled"]},
      ]},
    }
  },
  "Akademik": {
    icon:"📚", color:"#7C3AED",
    menus: {
      "Kelas": { fields:[
        {n:"nama_kelas",l:"Nama Kelas",t:"text",req:true,ph:"X-A, XI-B, XII-C"},
        {n:"tingkat",l:"Tingkat",t:"number",ph:"10, 11, atau 12"},
        {n:"jurusan",l:"Jurusan",t:"text",ph:"IPA, IPS, Teknik"},
        {n:"kapasitas",l:"Kapasitas Siswa",t:"number"},
        {n:"tahun_ajaran",l:"Tahun Ajaran",t:"text",ph:"2025/2026"},
        {n:"ruangan",l:"Ruangan",t:"text"},
      ]},
      "Mata Pelajaran": { fields:[
        {n:"nama_mapel",l:"Nama Mata Pelajaran",t:"text",req:true},
        {n:"kode_mapel",l:"Kode Mapel",t:"text"},
        {n:"kategori",l:"Kategori",t:"select",opts:["umum","keahlian","kejuruan"]},
        {n:"jam_pelajaran",l:"JP per Minggu",t:"number"},
        {n:"kurikulum",l:"Kurikulum",t:"select",opts:["Merdeka","2013"]},
      ]},
      "Nilai Siswa": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"jenis_penilaian",l:"Jenis",t:"select",opts:["tugas","uts","uas","praktik","sikap"]},
        {n:"nilai",l:"Nilai (0-100)",t:"number",req:true},
        {n:"bobot",l:"Bobot (%)",t:"number"},
        {n:"tanggal_penilaian",l:"Tanggal",t:"date"},
        {n:"remidial_nilai",l:"Nilai Remidial",t:"number"},
        {n:"keterangan",l:"Keterangan",t:"textarea"},
      ]},
      "Rapor Siswa": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"semester",l:"Semester",t:"select",opts:["1","2"]},
        {n:"tahun_ajaran",l:"Tahun Ajaran",t:"text"},
        {n:"template_format",l:"Format",t:"select",opts:["kemendikbud","kurikulum_merdeka","custom"]},
        {n:"status_rapor",l:"Status",t:"select",opts:["draft","finalized","published","signed"]},
        {n:"tanggal_generate",l:"Tanggal Generate",t:"date"},
      ]},
      "Absensi Siswa": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"tanggal_pelajaran",l:"Tanggal",t:"date",req:true},
        {n:"status_kehadiran",l:"Status",t:"select",opts:["hadir","sakit","izin","bolos","libur"]},
        {n:"jam_masuk",l:"Jam Masuk",t:"time"},
        {n:"jam_pulang",l:"Jam Pulang",t:"time"},
        {n:"offline_sync",l:"Sync dari Offline",t:"boolean"},
      ]},
    }
  },
  "Keuangan & SPP": {
    icon:"💰", color:"#D97706",
    menus: {
      "Komposisi Biaya": { fields:[
        {n:"jenis_biaya",l:"Jenis Biaya",t:"text",req:true,ph:"SPP, Biaya Pelaksanaan"},
        {n:"nominal_biaya",l:"Nominal (Rp)",t:"number",req:true},
        {n:"tipe_pembayaran",l:"Tipe",t:"select",opts:["bulanan","semesteran","tahunan"]},
        {n:"berlaku_dari",l:"Berlaku Dari",t:"date"},
        {n:"berlaku_sampai",l:"Berlaku Sampai",t:"date"},
        {n:"keterangan",l:"Keterangan",t:"textarea"},
      ]},
      "Tagihan SPP": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"nominal",l:"Nominal Tagihan (Rp)",t:"number",req:true},
        {n:"periode_bulan",l:"Bulan (1-12)",t:"number"},
        {n:"tahun",l:"Tahun",t:"number"},
        {n:"tanggal_jatuh_tempo",l:"Jatuh Tempo",t:"date"},
        {n:"status_tagihan",l:"Status",t:"select",opts:["belum_dibayar","lunas","cicilan","tunggakan"]},
      ]},
      "Pembayaran SPP": { fields:[
        {n:"tagihan_id",l:"ID Tagihan",t:"text",req:true},
        {n:"metode_pembayaran",l:"Metode",t:"select",opts:["transfer_bank","e_wallet","cicilan","cek"]},
        {n:"nominal_bayar",l:"Nominal Bayar (Rp)",t:"number",req:true},
        {n:"tanggal_pembayaran",l:"Tanggal",t:"date"},
        {n:"status_verifikasi",l:"Status",t:"select",opts:["pending","verified","rejected"]},
      ]},
      "Bank Reconciliation": { fields:[
        {n:"rekening_id",l:"ID Rekening",t:"text"},
        {n:"tanggal_recon",l:"Tanggal Rekonsiliasi",t:"date"},
        {n:"saldo_bank_statement",l:"Saldo Bank Statement (Rp)",t:"number"},
        {n:"saldo_sistem",l:"Saldo Sistem (Rp)",t:"number"},
        {n:"status",l:"Status",t:"select",opts:["balanced","discrepancy","pending"]},
        {n:"keterangan",l:"Keterangan",t:"textarea"},
      ]},
      "Laporan Keuangan": { fields:[
        {n:"jenis_laporan",l:"Jenis Laporan",t:"select",opts:["penerimaan","cash_flow","tunggakan","refund"]},
        {n:"periode_dari",l:"Periode Dari",t:"date"},
        {n:"periode_sampai",l:"Periode Sampai",t:"date"},
        {n:"total_penerimaan",l:"Total Penerimaan (Rp)",t:"number"},
        {n:"total_pengeluaran",l:"Total Pengeluaran (Rp)",t:"number"},
      ]},
    }
  },
  "Kesiswaan": {
    icon:"👥", color:"#16A34A",
    menus: {
      "Data Siswa": { fields:[
        {n:"nisn",l:"NISN",t:"text",req:true},
        {n:"nama_lengkap",l:"Nama Lengkap",t:"text",req:true},
        {n:"tempat_lahir",l:"Tempat Lahir",t:"text"},
        {n:"tanggal_lahir",l:"Tanggal Lahir",t:"date"},
        {n:"jenis_kelamin",l:"Jenis Kelamin",t:"select",opts:["laki-laki","perempuan"]},
        {n:"agama",l:"Agama",t:"text"},
        {n:"alamat",l:"Alamat",t:"textarea"},
        {n:"no_telepon",l:"No. Telepon",t:"text"},
        {n:"email",l:"Email",t:"email"},
        {n:"nama_ayah",l:"Nama Ayah",t:"text"},
        {n:"nama_ibu",l:"Nama Ibu",t:"text"},
        {n:"no_hp_ayah",l:"No. HP Ayah",t:"text"},
      ]},
      "Ekstrakurikuler": { fields:[
        {n:"nama_ekstrakurikuler",l:"Nama Ekskul",t:"text",req:true},
        {n:"deskripsi",l:"Deskripsi",t:"textarea"},
        {n:"jadwal_latihan",l:"Jadwal Latihan",t:"text",ph:"Senin 14:00-16:00"},
        {n:"kapasitas_anggota",l:"Kapasitas",t:"number"},
        {n:"tahun_ajaran",l:"Tahun Ajaran",t:"text"},
      ]},
      "Pelanggaran": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"jenis_pelanggaran",l:"Jenis Pelanggaran",t:"text",req:true},
        {n:"kategori_pelanggaran",l:"Kategori",t:"select",opts:["ringan","sedang","berat"]},
        {n:"bobot_pelanggaran",l:"Bobot Poin",t:"number"},
        {n:"tanggal_pelanggaran",l:"Tanggal",t:"date"},
        {n:"tindakan_discipliner",l:"Tindakan",t:"select",opts:["SP1","SP2","SP3","skorsing"]},
        {n:"status_penyelesaian",l:"Status",t:"select",opts:["open","resolved","appealed"]},
      ]},
      "Bimbingan Konseling": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"tanggal_konsultasi",l:"Tanggal",t:"date"},
        {n:"topik_konseling",l:"Topik",t:"text"},
        {n:"ringkasan_konseling",l:"Ringkasan",t:"textarea"},
        {n:"rekomendasi",l:"Rekomendasi",t:"textarea"},
        {n:"follow_up_tanggal",l:"Follow-up Tanggal",t:"date"},
      ]},
      "Prestasi Siswa": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"nama_prestasi",l:"Nama Prestasi/Kompetisi",t:"text",req:true},
        {n:"jenis_prestasi",l:"Jenis",t:"select",opts:["akademik","non_akademik","olahraga","seni"]},
        {n:"tingkat",l:"Tingkat",t:"select",opts:["sekolah","kota","provinsi","nasional","internasional"]},
        {n:"pencapaian",l:"Pencapaian",t:"text",ph:"Juara 1, Juara 2"},
        {n:"tanggal_pencapaian",l:"Tanggal",t:"date"},
        {n:"publikasi_sekolah",l:"Publikasikan di Website",t:"boolean"},
      ]},
    }
  },
  "Kepegawaian": {
    icon:"👨‍🏫", color:"#DB2777",
    menus: {
      "Data Guru & Staff": { fields:[
        {n:"nip",l:"NIP",t:"text"},
        {n:"nama_lengkap",l:"Nama Lengkap",t:"text",req:true},
        {n:"tempat_lahir",l:"Tempat Lahir",t:"text"},
        {n:"tanggal_lahir",l:"Tanggal Lahir",t:"date"},
        {n:"jenis_kelamin",l:"Jenis Kelamin",t:"select",opts:["laki-laki","perempuan"]},
        {n:"agama",l:"Agama",t:"text"},
        {n:"alamat",l:"Alamat",t:"textarea"},
        {n:"no_telepon",l:"No. Telepon",t:"text"},
        {n:"email",l:"Email",t:"email"},
        {n:"status_kepegawaian",l:"Status",t:"select",opts:["tetap","kontrak","honorer"]},
        {n:"tanggal_bergabung",l:"Tanggal Bergabung",t:"date"},
      ]},
      "Penugasan Guru": { fields:[
        {n:"guru_id",l:"ID Guru",t:"text",req:true},
        {n:"mapel_id",l:"Mata Pelajaran",t:"text"},
        {n:"kelas_id",l:"Kelas",t:"text"},
        {n:"tugas_khusus",l:"Tugas Khusus",t:"text",ph:"Wali Kelas, Pembina"},
        {n:"beban_kerja_jam",l:"Beban Kerja (JP)",t:"number"},
        {n:"tahun_ajaran",l:"Tahun Ajaran",t:"text"},
        {n:"status_penugasan",l:"Status",t:"select",opts:["aktif","nonaktif","diganti"]},
      ]},
      "Absensi Guru": { fields:[
        {n:"guru_id",l:"ID Guru",t:"text",req:true},
        {n:"tanggal_absensi",l:"Tanggal",t:"date",req:true},
        {n:"status_kehadiran",l:"Status",t:"select",opts:["hadir","sakit","izin","cuti","alfa","libur"]},
        {n:"jam_masuk_aktual",l:"Jam Masuk",t:"time"},
        {n:"jam_pulang_aktual",l:"Jam Pulang",t:"time"},
        {n:"keterangan",l:"Keterangan",t:"textarea"},
      ]},
      "Penggajian": { fields:[
        {n:"periode_bulan",l:"Periode Bulan",t:"select",req:true,opts:["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]},
        {n:"periode_tahun",l:"Periode Tahun",t:"number",req:true,ph:"2026"},
        {n:"teacher_id",l:"Nama Pegawai",t:"select2",req:true,opts:[]},
        {n:"gaji_pokok",l:"Gaji Pokok",t:"currency"},
        {n:"tunjangan",l:"Tunjangan",t:"currency"},
        {n:"potongan",l:"Potongan",t:"currency"},
        {n:"total_gaji",l:"Total Gaji",t:"currency",readonly:true},
        {n:"status_pembayaran",l:"Status Pembayaran",t:"select",opts:["draft","proses","paid"]},
        {n:"keterangan",l:"Keterangan",t:"textarea"},
      ]},
      "Pelatihan Guru": { fields:[
        {n:"teacher_id",l:"Guru",t:"select2",req:true,opts:[]},
        {n:"nama_pelatihan",l:"Nama Pelatihan",t:"text",req:true},
        {n:"deskripsi",l:"Deskripsi",t:"textarea"},
        {n:"penyelenggara",l:"Penyelenggara",t:"text"},
        {n:"tanggal_mulai",l:"Tanggal Mulai",t:"date"},
        {n:"tanggal_selesai",l:"Tanggal Selesai",t:"date"},
        {n:"durasi_jam",l:"Durasi (Jam)",t:"number"},
        {n:"lokasi",l:"Lokasi",t:"text"},
      ]},
      "Penilaian Kinerja": { fields:[
        {n:"guru_id",l:"ID Guru",t:"text",req:true},
        {n:"tahun_ajaran",l:"Tahun Ajaran",t:"text"},
        {n:"skor_kompetensi",l:"Skor Kompetensi (0-100)",t:"number"},
        {n:"skor_dedikasi",l:"Skor Dedikasi (0-100)",t:"number"},
        {n:"skor_disiplin",l:"Skor Disiplin (0-100)",t:"number"},
        {n:"skor_inovasi",l:"Skor Inovasi (0-100)",t:"number"},
        {n:"feedback",l:"Feedback",t:"textarea"},
        {n:"development_plan",l:"Rencana Pengembangan",t:"textarea"},
      ]},
    }
  },
  "Sarana & Prasarana": {
    icon:"🏫", color:"#0891B2",
    menus: {
      "Ruangan": { fields:[
        {n:"nama_ruangan",l:"Nama Ruangan",t:"text",req:true},
        {n:"nomor_ruangan",l:"Nomor Ruangan",t:"text"},
        {n:"gedung",l:"Gedung",t:"text",ph:"A, B, C"},
        {n:"lantai",l:"Lantai",t:"number"},
        {n:"tipe_ruangan",l:"Tipe",t:"select",opts:["kelas","lab","perpustakaan","kantor","mushola"]},
        {n:"luas_ruangan",l:"Luas (m²)",t:"number"},
        {n:"kapasitas",l:"Kapasitas",t:"number"},
        {n:"kondisi_ruangan",l:"Kondisi",t:"select",opts:["baik","perlu_perbaikan","rusak"]},
        {n:"catatan_kondisi",l:"Catatan",t:"textarea"},
      ]},
      "Inventaris Aset": { fields:[
        {n:"nama_aset",l:"Nama Aset",t:"text",req:true},
        {n:"kode_aset",l:"Kode Aset",t:"text"},
        {n:"kategori_aset",l:"Kategori",t:"text",ph:"mebel, elektronik, kendaraan"},
        {n:"merk",l:"Merk",t:"text"},
        {n:"tahun_perolehan",l:"Tahun Perolehan",t:"number"},
        {n:"nilai_perolehan",l:"Nilai Perolehan (Rp)",t:"number"},
        {n:"kondisi",l:"Kondisi",t:"select",opts:["baik","sedang","rusak","hilang"]},
        {n:"status_aset",l:"Status",t:"select",opts:["aktif","tidak_aktif","dihapuskan"]},
      ]},
      "Maintenance": { fields:[
        {n:"aset_id",l:"ID Aset",t:"text",req:true},
        {n:"jenis_maintenance",l:"Jenis",t:"select",opts:["preventif","korektif","emergency"]},
        {n:"deskripsi_masalah",l:"Deskripsi Masalah",t:"textarea"},
        {n:"tanggal_mulai",l:"Tanggal Mulai",t:"date"},
        {n:"tanggal_selesai",l:"Tanggal Selesai",t:"date"},
        {n:"biaya_maintenance",l:"Biaya (Rp)",t:"number"},
        {n:"status_maintenance",l:"Status",t:"select",opts:["pending","progress","completed"]},
        {n:"catatan",l:"Catatan",t:"textarea"},
      ]},
      "Keamanan & Akses": { fields:[
        {n:"no_kartu_akses",l:"No. Kartu Akses",t:"text"},
        {n:"tipe_akses",l:"Tipe Akses",t:"select",opts:["semua_area","area_tertentu","terbatas"]},
        {n:"tanggal_berlaku",l:"Berlaku Dari",t:"date"},
        {n:"tanggal_kadaluarsa",l:"Kadaluarsa",t:"date"},
        {n:"status_akses",l:"Status",t:"select",opts:["aktif","nonaktif","blokir"]},
      ]},
    }
  },
  "Humas & Komunikasi": {
    icon:"📢", color:"#EA580C",
    menus: {
      "Pengumuman": { fields:[
        {n:"judul_pengumuman",l:"Judul",t:"text",req:true},
        {n:"isi_pengumuman",l:"Isi Pengumuman",t:"textarea",req:true},
        {n:"tipe_pengumuman",l:"Tipe",t:"select",opts:["umum","akademik","keuangan","keamanan"]},
        {n:"tanggal_terbit",l:"Tanggal Terbit",t:"datetime-local"},
        {n:"tanggal_kadaluarsa",l:"Kadaluarsa",t:"date"},
        {n:"status_publikasi",l:"Status",t:"select",opts:["draft","published","expired"]},
      ]},
      "Event Sekolah": { fields:[
        {n:"nama_event",l:"Nama Event",t:"text",req:true},
        {n:"deskripsi_event",l:"Deskripsi",t:"textarea"},
        {n:"jenis_event",l:"Jenis",t:"select",opts:["akademik","olahraga","seni","sosial","wisuda"]},
        {n:"tanggal_mulai",l:"Tanggal Mulai",t:"date"},
        {n:"tanggal_selesai",l:"Tanggal Selesai",t:"date"},
        {n:"lokasi_event",l:"Lokasi",t:"text"},
        {n:"status_event",l:"Status",t:"select",opts:["planning","confirmed","berlangsung","selesai","dibatalkan"]},
      ]},
      "Media & Galeri": { fields:[
        {n:"judul_media",l:"Judul",t:"text",req:true},
        {n:"deskripsi",l:"Deskripsi",t:"textarea"},
        {n:"tipe_media",l:"Tipe",t:"select",opts:["foto","video","berita","artikel"]},
        {n:"kategori",l:"Kategori",t:"text",ph:"event, prestasi, aktivitas"},
        {n:"tanggal_upload",l:"Tanggal Upload",t:"date"},
        {n:"publikasi_publik",l:"Publik di Website",t:"boolean"},
      ]},
      "Komunikasi Ortu": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"tipe_komunikasi",l:"Tipe",t:"select",opts:["notifikasi_nilai","notifikasi_absensi","rapat_orangtua","pesan_umum"]},
        {n:"isi_pesan",l:"Isi Pesan",t:"textarea"},
        {n:"saluran_pengiriman",l:"Saluran",t:"select",opts:["email","sms","push","web_portal"]},
        {n:"tanggal_pengiriman",l:"Tanggal",t:"datetime-local"},
      ]},
    }
  },
  "Kelulusan & Alumni": {
    icon:"🏆", color:"#65A30D",
    menus: {
      "Eligibility Kelulusan": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"tahun_ajaran_lulus",l:"Tahun Ajaran Lulus",t:"text"},
        {n:"nilai_rata_rata",l:"Nilai Rata-rata",t:"number"},
        {n:"status_tunggakan",l:"Status Tunggakan",t:"select",opts:["lunas","masih_ada_tunggakan"]},
        {n:"kehadiran_minimum_terpenuhi",l:"Kehadiran Min. Terpenuhi",t:"boolean"},
        {n:"status_eligibility",l:"Status",t:"select",opts:["eligible","eligible_bersyarat","tidak_eligible"]},
        {n:"catatan_keputusan",l:"Catatan",t:"textarea"},
      ]},
      "Ijazah": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"nomor_ijazah",l:"Nomor Ijazah",t:"text"},
        {n:"tanggal_terbit",l:"Tanggal Terbit",t:"date"},
        {n:"template_format",l:"Format",t:"select",opts:["kemendikbud","kurikulum_merdeka"]},
        {n:"ttd_kepala_sekolah",l:"TTD Kepala Sekolah",t:"boolean"},
        {n:"status_ijazah",l:"Status",t:"select",opts:["draft","diterbitkan","diambil","hilang"]},
        {n:"tanggal_diambil",l:"Tanggal Diambil",t:"date"},
      ]},
      "Data Alumni": { fields:[
        {n:"siswa_id",l:"ID Siswa",t:"text",req:true},
        {n:"tahun_lulus",l:"Tahun Lulus",t:"number"},
        {n:"nomor_alumni",l:"Nomor Alumni",t:"text"},
        {n:"status_lanjutan",l:"Status",t:"select",opts:["bekerja","melanjutkan_studi","belum_tahu"]},
        {n:"tempat_bekerja",l:"Tempat Bekerja/Kampus",t:"text"},
        {n:"email_alumni",l:"Email Alumni",t:"email"},
        {n:"no_hp_alumni",l:"No. HP",t:"text"},
        {n:"linkedin_profile",l:"LinkedIn",t:"text"},
      ]},
      "Event Alumni": { fields:[
        {n:"nama_event",l:"Nama Acara",t:"text",req:true},
        {n:"tanggal_event",l:"Tanggal",t:"date"},
        {n:"deskripsi",l:"Deskripsi",t:"textarea"},
        {n:"peserta_terdaftar",l:"Peserta Terdaftar",t:"number"},
        {n:"peserta_hadir",l:"Peserta Hadir",t:"number"},
      ]},
    }
  },
  "Sistem & Pengaturan": {
    icon:"⚙️", color:"#6B7280",
    menus: {
      "Tahun Ajaran": { fields:[
        {n:"tahun_ajaran",l:"Tahun Ajaran",t:"text",ph:"2025/2026"},
        {n:"semester",l:"Semester",t:"select",opts:["1","2"]},
        {n:"tanggal_mulai",l:"Tanggal Mulai",t:"date"},
        {n:"tanggal_selesai",l:"Tanggal Selesai",t:"date"},
        {n:"tanggal_uts",l:"Tanggal UTS",t:"date"},
        {n:"tanggal_uas",l:"Tanggal UAS",t:"date"},
        {n:"status_aktif",l:"Aktif",t:"boolean"},
      ]},
      "Konfigurasi Sekolah": { fields:[
        {n:"nama_sekolah",l:"Nama Sekolah",t:"text",req:true},
        {n:"npsn",l:"NPSN",t:"text"},
        {n:"alamat_sekolah",l:"Alamat",t:"textarea"},
        {n:"no_telepon",l:"No. Telepon",t:"text"},
        {n:"email_sekolah",l:"Email",t:"email"},
        {n:"nama_kepala_sekolah",l:"Nama Kepala Sekolah",t:"text"},
        {n:"zona_waktu",l:"Zona Waktu",t:"text",ph:"Asia/Jakarta"},
        {n:"bahasa_default",l:"Bahasa",t:"select",opts:["id","en"]},
      ]},
      "User Management": { fields:[
        {n:"email",l:"Email",t:"email",req:true},
        {n:"nama_lengkap",l:"Nama Lengkap",t:"text",req:true},
        {n:"role_id",l:"Role",t:"text"},
        {n:"status_aktif",l:"Aktif",t:"boolean"},
        {n:"mfa_enabled",l:"MFA Aktif",t:"boolean"},
      ]},
      "Role & Permission": { fields:[
        {n:"nama_role",l:"Nama Role",t:"text",req:true},
        {n:"deskripsi",l:"Deskripsi",t:"textarea"},
        {n:"kategori_role",l:"Kategori",t:"select",opts:["super_admin","admin","guru","siswa","orang_tua","staff"]},
      ]},
      "Audit Trail": { fields:[
        {n:"modul_id",l:"Modul",t:"text"},
        {n:"tabel_nama",l:"Tabel",t:"text"},
        {n:"aksi_type",l:"Aksi",t:"select",opts:["CREATE","READ","UPDATE","DELETE","LOGIN","LOGOUT"]},
        {n:"ip_address",l:"IP Address",t:"text"},
        {n:"keterangan",l:"Keterangan",t:"textarea"},
      ]},
      "Backup & Recovery": { fields:[
        {n:"backup_type",l:"Tipe",t:"select",opts:["daily","weekly","monthly","manual"]},
        {n:"tanggal_backup",l:"Tanggal",t:"date"},
        {n:"jam_backup",l:"Jam",t:"time"},
        {n:"status_backup",l:"Status",t:"select",opts:["success","failed","partial"]},
        {n:"backup_location",l:"Lokasi",t:"text"},
        {n:"restore_tested",l:"Restore Tested",t:"boolean"},
      ]},
    }
  },
};

const DUMMY = {
  "KPI Dashboard": [
    {id:1,metric_name:"Tingkat Kehadiran Siswa",metric_type:"percentage",current_value:"94.5",target_value:"95",period:"2026-04-01"},
    {id:2,metric_name:"Penerimaan SPP",metric_type:"currency",current_value:"185000000",target_value:"200000000",period:"2026-04-01"},
    {id:3,metric_name:"Siswa Aktif",metric_type:"integer",current_value:"1247",target_value:"1300",period:"2026-04-01"},
  ],
  "Pendaftar Siswa": [
    {id:1,nama_lengkap:"Ahmad Fauzi",email:"fauzi@gmail.com",no_hp:"081234567890",asal_sekolah:"SMP N 1 Kroya",tanggal_pendaftaran:"2026-02-10",status_pendaftaran:"approved"},
    {id:2,nama_lengkap:"Siti Rahayu",email:"rahayu@gmail.com",no_hp:"082345678901",asal_sekolah:"SMP N 2 Kroya",tanggal_pendaftaran:"2026-02-11",status_pendaftaran:"verified"},
    {id:3,nama_lengkap:"Budi Santoso",email:"budi@gmail.com",no_hp:"083456789012",asal_sekolah:"MTs Kroya",tanggal_pendaftaran:"2026-02-12",status_pendaftaran:"pending"},
  ],
  "Kelas": [
    {id:1,nama_kelas:"X-A",tingkat:10,jurusan:"IPA",kapasitas:36,tahun_ajaran:"2025/2026",ruangan:"R-101"},
    {id:2,nama_kelas:"X-B",tingkat:10,jurusan:"IPA",kapasitas:36,tahun_ajaran:"2025/2026",ruangan:"R-102"},
    {id:3,nama_kelas:"XI-A",tingkat:11,jurusan:"IPS",kapasitas:34,tahun_ajaran:"2025/2026",ruangan:"R-201"},
  ],
  "Data Siswa": [
    {id:1,nisn:"1234567890",nama_lengkap:"Ahmad Fauzi",tempat_lahir:"Kroya",tanggal_lahir:"2008-05-15",jenis_kelamin:"laki-laki",agama:"Islam",no_telepon:"081234567890"},
    {id:2,nisn:"0987654321",nama_lengkap:"Siti Rahayu",tempat_lahir:"Cilacap",tanggal_lahir:"2008-07-22",jenis_kelamin:"perempuan",agama:"Islam",no_telepon:"082345678901"},
    {id:3,nisn:"1122334455",nama_lengkap:"Budi Pratama",tempat_lahir:"Kroya",tanggal_lahir:"2007-11-03",jenis_kelamin:"laki-laki",agama:"Islam",no_telepon:"083456789012"},
  ],
  "Data Guru & Staff": [
    {id:1,nip:"198505122010011001",nama_lengkap:"Drs. Ahmad Kusuma",jenis_kelamin:"laki-laki",status_kepegawaian:"tetap",tanggal_bergabung:"2010-01-12",email:"ahmad@smamaarif.sch.id"},
    {id:2,nip:"199001052015012002",nama_lengkap:"Siti Nurhaliza, S.Pd",jenis_kelamin:"perempuan",status_kepegawaian:"tetap",tanggal_bergabung:"2015-01-05",email:"siti@smamaarif.sch.id"},
    {id:3,nip:"-",nama_lengkap:"Budi Setiawan, S.Kom",jenis_kelamin:"laki-laki",status_kepegawaian:"kontrak",tanggal_bergabung:"2022-07-01",email:"budi@smamaarif.sch.id"},
  ],
  "Tagihan SPP": [
    {id:1,siswa_id:"1234567890",nominal:"350000",periode_bulan:4,tahun:2026,tanggal_jatuh_tempo:"2026-04-10",status_tagihan:"lunas"},
    {id:2,siswa_id:"0987654321",nominal:"350000",periode_bulan:4,tahun:2026,tanggal_jatuh_tempo:"2026-04-10",status_tagihan:"belum_dibayar"},
    {id:3,siswa_id:"1122334455",nominal:"350000",periode_bulan:3,tahun:2026,tanggal_jatuh_tempo:"2026-03-10",status_tagihan:"tunggakan"},
  ],
  "Pengumuman": [
    {id:1,judul_pengumuman:"Pengumuman Ujian Akhir Semester Genap 2025/2026",tipe_pengumuman:"akademik",tanggal_terbit:"2026-04-15T08:00",status_publikasi:"published"},
    {id:2,judul_pengumuman:"Pembayaran SPP Bulan April 2026",tipe_pengumuman:"keuangan",tanggal_terbit:"2026-04-01T07:00",status_publikasi:"published"},
    {id:3,judul_pengumuman:"Pendaftaran Ekskul Baru TA 2026/2027",tipe_pengumuman:"umum",tanggal_terbit:"2026-04-20T09:00",status_publikasi:"draft"},
  ],
};

const SC = {
  approved:"#16A34A",active:"#16A34A",aktif:"#16A34A",lunas:"#16A34A",
  published:"#16A34A",hadir:"#16A34A",completed:"#16A34A",eligible:"#16A34A",
  success:"#16A34A",baik:"#16A34A",paid:"#16A34A",final:"#16A34A",
  pending:"#D97706",berjalan:"#D97706",progress:"#D97706",cicilan:"#D97706",
  verified:"#2563EB",draft:"#6B7280",
  rejected:"#DC2626",tunggakan:"#DC2626",rusak:"#DC2626",berat:"#DC2626",
  bolos:"#DC2626",blokir:"#DC2626",failed:"#DC2626",
};

// ── State ────────────────────────────────────────────────────────
const S = {
  collapsed: false,
  openMods: {'Dashboard & Reporting': true},
  active: null,
  data: {},
  search: '',
  modal: null,
};

// ── Constants ────────────────────────────────────────────────────
const TH = 'padding:10px 14px;text-align:left;font-size:0.75rem;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:0.05em;white-space:nowrap;';
const TD = 'padding:10px 14px;color:#374151;vertical-align:middle;';
const IS = 'width:100%;padding:8px 12px;border-radius:8px;border:1px solid #E5E7EB;font-size:0.875rem;outline:none;background:white;color:#111827;font-family:inherit;';

// ── Init ─────────────────────────────────────────────────────────
window.addEventListener('DOMContentLoaded', function() {
  Object.entries(SCHEMA).forEach(([,info]) => {
    Object.entries(info.menus).forEach(([menu, mdata]) => {
      S.data[menu] = { fields: mdata.fields, rows: JSON.parse(JSON.stringify(DUMMY[menu] || [])) };
    });
  });
  renderSidebar();
  renderDashboard();
});

// ── Helpers ──────────────────────────────────────────────────────
function badge(val) {
  const c = SC[String(val).toLowerCase()] || '#6B7280';
  return `<span style="background:${c}18;color:${c};border:1px solid ${c}30;padding:2px 10px;border-radius:100px;font-size:0.72rem;font-weight:600;white-space:nowrap">${val}</span>`;
}

function esc(str) {
  return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function formatCurrency(value) {
  const raw = String(value ?? '').replace(/[^\d-]/g, '');
  if (!raw) return '';
  const num = Number(raw);
  if (Number.isNaN(num)) return '';
  return new Intl.NumberFormat('id-ID').format(num);
}

function parseCurrency(value) {
  const raw = String(value ?? '').replace(/[^\d-]/g, '');
  return raw ? raw : '';
}

function getTeacherOptions() {
  return (DUMMY['Data Guru & Staff'] || []).map(item => ({
    value: String(item.id),
    label: `${item.nama_lengkap || '-'}${item.nip ? ' - ' + item.nip : ''}`,
    search: `${item.nip || ''} ${item.nama_lengkap || ''} ${item.email || ''}`.toLowerCase(),
  }));
}

function getSearchOptions(field) {
  if (field.n === 'teacher_id') {
    return getTeacherOptions();
  }
  return (field.opts || []).map(option => ({
    value: typeof option === 'object' ? String(option.value) : String(option),
    label: typeof option === 'object' ? String(option.label ?? option.value) : String(option),
    search: String(typeof option === 'object' ? (option.label ?? option.value) : option).toLowerCase(),
  }));
}

function getSearchDisplayValue(fieldName, value) {
  if (fieldName === 'teacher_id') {
    const option = getTeacherOptions().find(item => String(item.value) === String(value));
    return option ? option.label : '';
  }
  return String(value ?? '');
}

function syncSearchSelect(fieldName) {
  const hidden = document.querySelector(`#modal-body [name="${fieldName}"]`);
  const display = document.querySelector(`#modal-body [name="${fieldName}__display"]`);
  const menu = document.querySelector(`#modal-body [data-searchselect-menu="${fieldName}"]`);
  if (!hidden || !display || !menu) return;

  const allOptions = Array.from(menu.querySelectorAll('.searchselect-option'));
  const filterOptions = () => {
    const q = display.value.trim().toLowerCase();
    let visible = 0;
    allOptions.forEach(btn => {
      const hay = (btn.dataset.search || btn.dataset.label || '').toLowerCase();
      const match = !q || hay.includes(q);
      btn.style.display = match ? 'block' : 'none';
      if (match) visible++;
    });
    const empty = menu.querySelector('[data-searchselect-empty]');
    if (empty) empty.style.display = visible ? 'none' : 'block';
  };

  display.addEventListener('focus', () => {
    menu.style.display = 'block';
    filterOptions();
  });
  display.addEventListener('input', () => {
    hidden.value = '';
    menu.style.display = 'block';
    filterOptions();
  });

  const toggle = document.querySelector(`#modal-body [data-searchselect-toggle="${fieldName}"]`);
  if (toggle) {
    toggle.addEventListener('click', () => {
      const open = menu.style.display === 'block';
      menu.style.display = open ? 'none' : 'block';
      if (!open) filterOptions();
    });
  }

  allOptions.forEach(btn => {
    btn.addEventListener('click', () => {
      hidden.value = btn.dataset.value || '';
      display.value = btn.dataset.label || '';
      menu.style.display = 'none';
    });
  });

  document.addEventListener('click', function handleOutside(e) {
    if (!document.getElementById('modal-overlay')?.contains(e.target)) {
      menu.style.display = 'none';
      document.removeEventListener('click', handleOutside, true);
    }
  }, true);
}

// ── Sidebar ──────────────────────────────────────────────────────
function getOpenSidebarModule() {
  return Object.entries(S.openMods || {}).find(([, isOpen]) => Boolean(isOpen))?.[0] || null;
}

function renderSidebarFlyout() {
  const flyout = document.getElementById('sb-flyout');
  if (!flyout) return;

  if (!S.collapsed || !S.flyoutModule) {
    flyout.innerHTML = '';
    flyout.style.display = 'none';
    flyout.setAttribute('aria-hidden', 'true');
    return;
  }

  const mod = S.flyoutModule;
  if (!mod || !SCHEMA[mod]) {
    flyout.innerHTML = '';
    flyout.style.display = 'none';
    flyout.setAttribute('aria-hidden', 'true');
    return;
  }

  const info = SCHEMA[mod];
  const menuHtml = Object.keys(info.menus).map(menu => {
    const isActive = S.active?.menu === menu && S.active?.mod === mod;
    return `<button class="submenu-btn" onclick="selectMenu(this)" data-mod="${esc(mod)}" data-menu="${esc(menu)}"
      style="border-left:2px solid ${isActive ? info.color : 'transparent'};
             background:${isActive ? info.color + '25' : 'rgba(255,255,255,0.02)'};
             color:${isActive ? info.color : 'rgba(255,255,255,0.7)'}">${esc(menu)}</button>`;
  }).join('');

  flyout.innerHTML = `
    <div class="sb-flyout-panel">
      <div class="sb-flyout-head">
        <div>
          <strong>${esc(mod)}</strong><br>
          <small>Daftar menu</small>
        </div>
        <div style="width:10px;height:10px;border-radius:50%;background:${info.color};box-shadow:0 0 0 4px ${info.color}22;"></div>
      </div>
      <div class="sb-flyout-list">${menuHtml}</div>
    </div>`;
  flyout.style.top = `${Math.max(72, S.flyoutTop || 72)}px`;
  flyout.style.display = 'block';
  flyout.setAttribute('aria-hidden', 'false');
}

function toggleSidebar() {
  S.collapsed = !S.collapsed;
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('collapsed', S.collapsed);
  document.getElementById('sb-toggle').textContent = S.collapsed ? '>' : '<';
  document.getElementById('sb-toggle').setAttribute('aria-expanded', String(!S.collapsed));
  if (!S.collapsed) S.flyoutModule = null;
  renderSidebar();
  renderSidebarFlyout();
}

function renderSidebar() {
  let h = '';
  Object.entries(SCHEMA).forEach(([mod, info]) => {
    const open = S.openMods[mod];
    h += `<div style="margin-bottom:2px">
      <button class="module-btn" onclick="toggleModule(this)" data-mod="${esc(mod)}" style="${S.active?.mod === mod ? `background:${info.color}25;color:${info.color};` : ''}">
        <span style="flex-shrink:0;font-size:1rem">${info.icon}</span>
        <span class="sb-label" style="flex:1;line-height:1.3">${esc(mod)}</span>
        <span class="sb-label" style="font-size:0.65rem;color:rgba(255,255,255,0.3)">${open?'▲':'▼'}</span>
      </button>`;
    if (open && !S.collapsed) {
      h += `<div style="padding-left:8px">`;
      Object.keys(info.menus).forEach(menu => {
        const isActive = S.active?.menu === menu;
        h += `<button class="submenu-btn" onclick="selectMenu(this)" data-mod="${esc(mod)}" data-menu="${esc(menu)}"
          style="border-left:2px solid ${isActive ? info.color : 'transparent'};
                 background:${isActive ? info.color+'25' : 'none'};
                 color:${isActive ? info.color : 'rgba(255,255,255,0.45)'};
                 font-weight:${isActive ? 600 : 400}">${esc(menu)}</button>`;
      });
      h += `</div>`;
    }
    h += `</div>`;
  });
  document.getElementById('sb-modules').innerHTML = h;
  renderSidebarFlyout();
}

function toggleModule(btn) {
  const mod = btn.dataset.mod;
  const isOpen = Boolean(S.openMods[mod]);
  if (S.collapsed) {
    S.openMods = isOpen ? {} : { [mod]: true };
    S.flyoutModule = isOpen ? null : mod;
    S.flyoutTop = Math.max(72, btn.getBoundingClientRect().top);
  } else {
    S.openMods[mod] = !S.openMods[mod];
  }
  renderSidebar();
}

function showDashboard() {
  S.active = null;
  S.search = '';
  document.getElementById('search').value = '';
  const hb = document.getElementById('btn-home');
  hb.style.background = 'rgba(27,107,58,0.3)';
  hb.style.color = '#4ADE80';
  document.getElementById('tb-title').innerHTML = '<div style="font-size:1rem;font-weight:700;color:#111827">Dashboard</div>';
  renderSidebar();
  renderDashboard();
}

function selectMenu(btn) {
  const mod = btn.dataset.mod;
  const menu = btn.dataset.menu;
  S.active = {mod, menu};
  S.search = '';
  document.getElementById('search').value = '';
  S.openMods = { [mod]: true };
  S.flyoutModule = null;
  const hb = document.getElementById('btn-home');
  hb.style.background = 'none';
  hb.style.color = 'rgba(255,255,255,0.6)';
  const info = SCHEMA[mod];
  document.getElementById('tb-title').innerHTML =
    `<div style="font-size:0.7rem;color:#9CA3AF;font-weight:500">${esc(mod)} / <span style="color:${info.color}">${esc(menu)}</span></div>
     <div style="font-size:1rem;font-weight:700;color:#111827;line-height:1;margin-top:2px">${esc(menu)}</div>`;
  renderSidebar();
  renderTable();
}

// ── Dashboard Home ───────────────────────────────────────────────
function renderDashboard() {
  const stats = [
    {label:'Total Siswa Aktif',val:'1.247',icon:'👥',color:'#2563EB'},
    {label:'Guru & Staff',val:'85',icon:'👨‍🏫',color:'#7C3AED'},
    {label:'SPP Bulan Ini',val:'Rp 185jt',icon:'💰',color:'#D97706'},
    {label:'Tingkat Kehadiran',val:'94.5%',icon:'📊',color:'#16A34A'},
  ];
  const acts = [
    {t:'Pendaftar baru: Ahmad Fauzi mendaftar',time:'5 menit lalu',c:'#2563EB'},
    {t:'Pembayaran SPP diverifikasi: Siti Rahayu',time:'12 menit lalu',c:'#16A34A'},
    {t:'Pengumuman UAS diterbitkan',time:'1 jam lalu',c:'#EA580C'},
    {t:'Backup harian selesai (success)',time:'3 jam lalu',c:'#6B7280'},
    {t:'Pelanggaran baru dicatat: Budi Santoso',time:'kemarin',c:'#DC2626'},
  ];
  const statsHtml = stats.map(s =>
    `<div style="background:white;border-radius:12px;padding:20px;border:1px solid #E5E7EB;display:flex;align-items:center;gap:16px">
      <div style="width:48px;height:48px;border-radius:12px;background:${s.color}15;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">${s.icon}</div>
      <div>
        <div style="font-size:1.5rem;font-weight:800;color:#111827;line-height:1">${s.val}</div>
        <div style="font-size:0.78rem;color:#6B7280;margin-top:4px">${s.label}</div>
      </div>
    </div>`).join('');
  const actsHtml = acts.map((a,i) =>
    `<div style="display:flex;gap:12px;padding-bottom:12px;${i<acts.length-1?'border-bottom:1px solid #F3F4F6;':''}margin-bottom:12px">
      <div style="width:8px;height:8px;border-radius:50%;background:${a.c};margin-top:6px;flex-shrink:0"></div>
      <div>
        <div style="font-size:0.825rem;color:#374151">${a.t}</div>
        <div style="font-size:0.73rem;color:#9CA3AF;margin-top:2px">${a.time}</div>
      </div>
    </div>`).join('');
  const modHtml = Object.entries(SCHEMA).map(([mod,info]) =>
    `<div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid #F3F4F6;margin-bottom:10px">
      <div style="display:flex;align-items:center;gap:8px">
        <span>${info.icon}</span>
        <span style="font-size:0.8rem;color:#374151;font-weight:500">${mod}</span>
      </div>
      <div style="display:flex;align-items:center;gap:6px">
        <div style="width:60px;height:5px;background:#F3F4F6;border-radius:3px;overflow:hidden">
          <div style="height:100%;width:${Math.floor(Math.random()*40+60)}%;background:${info.color};border-radius:3px"></div>
        </div>
        ${badge('aktif')}
      </div>
    </div>`).join('');
  document.getElementById('main-content').innerHTML =
    `<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">${statsHtml}</div>
     <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
       <div style="background:white;border-radius:12px;padding:20px;border:1px solid #E5E7EB">
         <div style="font-size:0.85rem;font-weight:700;color:#374151;margin-bottom:16px">Aktivitas Terbaru</div>
         ${actsHtml}
       </div>
       <div style="background:white;border-radius:12px;padding:20px;border:1px solid #E5E7EB">
         <div style="font-size:0.85rem;font-weight:700;color:#374151;margin-bottom:16px">Status Modul</div>
         ${modHtml}
       </div>
     </div>`;
}

// ── Table View ───────────────────────────────────────────────────
function renderTable() {
  const {mod, menu} = S.active;
  const info = SCHEMA[mod];
  const mdata = S.data[menu];
  const allRows = mdata.rows;
  const rows = S.search
    ? allRows.filter(r => Object.values(r).some(v => String(v).toLowerCase().includes(S.search.toLowerCase())))
    : allRows;
  const cols = mdata.fields.slice(0, 5);
  const theadCols = cols.map(c => `<th style="${TH}">${esc(c.l)}</th>`).join('');
  let tbody;
  if (rows.length === 0) {
    tbody = `<tr><td colspan="${cols.length+2}" style="text-align:center;padding:40px 20px;color:#9CA3AF">Belum ada data. Klik "+ Tambah" untuk menambahkan.</td></tr>`;
  } else {
    tbody = rows.map((row, i) => {
      const cells = cols.map(c => {
        const val = row[c.n];
        let content;
        if (c.t === 'boolean') {
          content = badge(val ? 'Ya' : 'Tidak');
        } else if (val !== null && val !== undefined && SC[String(val).toLowerCase()]) {
          content = badge(val);
        } else {
          const disp = val !== null && val !== undefined ? esc(val) : '<span style="color:#D1D5DB">—</span>';
          content = `<span style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block">${disp}</span>`;
        }
        return `<td style="${TD}">${content}</td>`;
      }).join('');
      return `<tr style="border-bottom:1px solid #F3F4F6" onmouseenter="this.style.background='#F9FAFB'" onmouseleave="this.style.background=''">
        <td style="${TD}color:#9CA3AF;text-align:center">${i+1}</td>
        ${cells}
        <td style="${TD}text-align:center">
          <div style="display:flex;gap:6px;justify-content:center">
            <button onclick="openEdit(${row.id})" style="padding:4px 12px;border-radius:6px;border:1px solid ${info.color}40;background:${info.color}10;color:${info.color};font-size:0.75rem;font-weight:600;cursor:pointer">Edit</button>
            <button onclick="deleteRow(${row.id})" style="padding:4px 12px;border-radius:6px;border:1px solid #FCA5A540;background:#FEF2F2;color:#DC2626;font-size:0.75rem;font-weight:600;cursor:pointer">Hapus</button>
          </div>
        </td>
      </tr>`;
    }).join('');
  }
  document.getElementById('main-content').innerHTML =
    `<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
       <div style="font-size:0.82rem;color:#6B7280">Total <strong style="color:#111827">${allRows.length}</strong> data</div>
       <div style="display:flex;gap:8px">
         <button style="padding:8px 14px;border-radius:8px;border:1px solid #E5E7EB;background:white;cursor:pointer;font-size:0.82rem;font-weight:600;color:#374151;display:flex;align-items:center;gap:6px">📥 Import</button>
         <button style="padding:8px 14px;border-radius:8px;border:1px solid #E5E7EB;background:white;cursor:pointer;font-size:0.82rem;font-weight:600;color:#374151;display:flex;align-items:center;gap:6px">📤 Export</button>
         <button onclick="openAdd()" style="padding:8px 18px;border-radius:8px;border:none;background:${info.color};cursor:pointer;font-size:0.85rem;font-weight:700;color:white;display:flex;align-items:center;gap:6px;box-shadow:0 4px 14px ${info.color}40">+ Tambah</button>
       </div>
     </div>
     <div style="overflow-x:auto;border-radius:12px;border:1px solid #E5E7EB;background:white">
       <table style="width:100%;border-collapse:collapse;font-size:0.855rem">
         <thead>
           <tr style="background:#F9FAFB;border-bottom:1px solid #E5E7EB">
             <th style="${TH}width:50px">No</th>
             ${theadCols}
             <th style="${TH}width:120px;text-align:center">Aksi</th>
           </tr>
         </thead>
         <tbody>${tbody}</tbody>
       </table>
     </div>
     ${rows.length > 0 ? `<div style="margin-top:12px;font-size:0.78rem;color:#9CA3AF">Menampilkan ${rows.length} dari ${allRows.length} data</div>` : ''}`;
}

// ── Modal ────────────────────────────────────────────────────────
function openAdd() {
  S.modal = {type:'add'};
  renderModal();
}

function openEdit(id) {
  const row = S.data[S.active.menu].rows.find(r => r.id == id);
  S.modal = {type:'edit', row};
  renderModal();
}

function renderModal() {
  const {mod, menu} = S.active;
  const info = SCHEMA[mod];
  const fields = S.data[menu].fields;
  const isEdit = S.modal.type === 'edit';
  const rowData = isEdit ? S.modal.row : {};
  document.getElementById('modal-hdr').innerHTML =
    `<div style="padding:18px 24px;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;background:${info.color}0D">
       <div>
         <div style="font-size:0.72rem;font-weight:700;color:${info.color};text-transform:uppercase;letter-spacing:0.1em;margin-bottom:2px">${isEdit?'Edit Data':'Tambah Data Baru'}</div>
         <div style="font-size:1rem;font-weight:700;color:#111827">${esc(menu)}</div>
       </div>
       <button onclick="closeModal()" style="background:none;border:none;cursor:pointer;width:32px;height:32px;border-radius:8px;font-size:1.2rem;color:#9CA3AF">✕</button>
     </div>`;
  let formHtml = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">';
  fields.forEach(f => {
    const val = rowData[f.n] ?? '';
    const span = (f.t==='textarea'||f.t==='datetime-local') ? 'grid-column:1/-1' : '';
    const req = f.req ? '<span style="color:#DC2626;margin-left:2px">*</span>' : '';
    let input;
    if (f.t === 'boolean') {
      input = `<label style="display:flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="${f.n}" ${val?'checked':''} style="width:16px;height:16px;accent-color:${info.color}">
        <span style="font-size:0.82rem;color:#6B7280">Ya / Aktif</span>
      </label>`;
  } else if (f.t === 'select' || f.t === 'select2') {
      const optsSource = f.t === 'select2' && f.n === 'teacher_id' ? getTeacherOptions() : (f.opts || []);
      const opts = optsSource.map(o => {
        const optionValue = typeof o === 'object' ? o.value : o;
        const optionLabel = typeof o === 'object' ? o.label : o;
        return `<option value="${esc(optionValue)}"${String(optionValue) === String(val) ? ' selected' : ''}>${esc(optionLabel)}</option>`;
      }).join('');
      input = `<select name="${f.n}" class="${f.t === 'select2' ? 'js-select2' : ''}" style="${IS}"><option value="">-- Pilih --</option>${opts}</select>`;
    } else if (f.t === 'currency') {
      input = `<input type="text" inputmode="numeric" name="${f.n}" value="${esc(formatCurrency(val))}" placeholder="${esc(f.ph||'')}" ${f.readonly?'readonly':''} style="${IS}">`;
    } else if (f.t === 'textarea') {
      input = `<textarea name="${f.n}" placeholder="${esc(f.ph||'')}" rows="3" style="${IS}resize:vertical;min-height:72px">${esc(val)}</textarea>`;
    } else {
      input = `<input type="${f.t}" name="${f.n}" value="${esc(val)}" placeholder="${esc(f.ph||'')}" ${f.req?'required':''} style="${IS}">`;
    }
    formHtml += `<div style="${span}">
      <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">${esc(f.l)}${req}</label>
      ${input}
    </div>`;
  });
  formHtml += '</div>';
  document.getElementById('modal-body').innerHTML = formHtml;
  document.querySelectorAll('#modal-body input[name]').forEach(input => {
    if (input.name === 'gaji_pokok' || input.name === 'tunjangan' || input.name === 'potongan' || input.name === 'total_gaji') {
      input.addEventListener('input', () => {
        input.value = formatCurrency(input.value);
      });
    }
  });
  const gajiPokok = document.querySelector('#modal-body [name="gaji_pokok"]');
  const tunjangan = document.querySelector('#modal-body [name="tunjangan"]');
  const potongan = document.querySelector('#modal-body [name="potongan"]');
  const totalGaji = document.querySelector('#modal-body [name="total_gaji"]');
  const recalcTotal = () => {
    if (!gajiPokok || !tunjangan || !potongan || !totalGaji) return;
    const total = Math.max(0,
      (Number.parseInt(parseCurrency(gajiPokok.value) || '0', 10) || 0) +
      (Number.parseInt(parseCurrency(tunjangan.value) || '0', 10) || 0) -
      (Number.parseInt(parseCurrency(potongan.value) || '0', 10) || 0)
    );
    totalGaji.value = formatCurrency(total);
  };
  [gajiPokok, tunjangan, potongan].forEach(el => {
    if (!el) return;
    el.addEventListener('input', recalcTotal);
    el.addEventListener('blur', recalcTotal);
  });
  recalcTotal();
  if (window.jQuery && typeof window.jQuery.fn.select2 === 'function') {
    window.jQuery('#modal-body .js-select2').select2({
      dropdownParent: window.jQuery('#modal-overlay'),
      width: '100%',
    });
  }
  document.getElementById('btn-save').style.background = info.color;
  document.getElementById('modal-overlay').style.display = 'flex';
}

function closeModal() {
  document.getElementById('modal-overlay').style.display = 'none';
  S.modal = null;
}

function saveModal() {
  const {menu} = S.active;
  const fields = S.data[menu].fields;
  const form = {};
  fields.forEach(f => {
    const el = document.querySelector(`#modal-body [name="${f.n}"]`);
    if (!el) return;
    if (f.t === 'boolean') {
      form[f.n] = el.checked;
    } else if (f.t === 'currency') {
      form[f.n] = parseCurrency(el.value);
    } else {
      form[f.n] = el.value;
    }
  });
  const rows = S.data[menu].rows;
  if (S.modal.type === 'edit') {
    const idx = rows.findIndex(r => r.id == S.modal.row.id);
    if (idx >= 0) rows[idx] = {...rows[idx], ...form};
  } else {
    form.id = Date.now();
    rows.push(form);
  }
  closeModal();
  renderTable();
}

function deleteRow(id) {
  if (!confirm('Hapus data ini?')) return;
  const {menu} = S.active;
  S.data[menu].rows = S.data[menu].rows.filter(r => r.id != id);
  renderTable();
}

function doSearch() {
  S.search = document.getElementById('search').value;
  if (S.active) renderTable();
}
