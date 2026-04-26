'use strict';

const RAW_RBAC = window.ADMIN_RBAC || { user: null, modules: [] };
const EXTRA_MENU_SCHEMA = {
  Akademik: {
    'Kelas': {
      fields: [
        { n: 'name', l: 'Nama Kelas', t: 'text', req: true, ph: 'X-A, XI-B, XII-IPA' },
        { n: 'tingkat', l: 'Tingkat', t: 'number', req: true },
        { n: 'jurusan', l: 'Jurusan', t: 'select', req: true, opts: ['IPA', 'IPS'] },
        { n: 'kapasitas', l: 'Kapasitas', t: 'number' },
        { n: 'ruang_kelas', l: 'Ruang Kelas', t: 'text' },
        { n: 'tahun_ajaran', l: 'Tahun Ajaran', t: 'select2', req: true, opts: [] },
      ],
    },
    'Mata Pelajaran': {
      fields: [
        { n: 'kode', l: 'Kode Mapel', t: 'text', req: true },
        { n: 'nama', l: 'Nama Mata Pelajaran', t: 'text', req: true },
        { n: 'kelompok', l: 'Kelompok', t: 'select', req: true, opts: ['A', 'B', 'C'] },
        { n: 'kkm', l: 'KKM', t: 'number' },
      ],
    },
    'Absensi Siswa': {
      fields: [
        { n: 'attendance_date', l: 'Tanggal', t: 'date', req: true },
        { n: 'start_time', l: 'Jam Mulai', t: 'time' },
        { n: 'end_time', l: 'Jam Selesai', t: 'time' },
        { n: 'class_id', l: 'Kelas', t: 'select', req: true, opts: [] },
        { n: 'subject_id', l: 'Mapel', t: 'select2', req: true, opts: [] },
        { n: 'teacher_id', l: 'Guru Pengampu', t: 'select2', req: true, opts: [] },
        { n: 'teacher_attendance_status', l: 'Status Guru', t: 'select', req: true, opts: ['hadir', 'izin', 'sakit', 'dinas_luar', 'alpha'] },
        { n: 'attendance_taker_type', l: 'Pengambil Absensi', t: 'select', req: true, opts: ['teacher', 'substitute_teacher', 'student_officer', 'staff'] },
        { n: 'substitute_teacher_id', l: 'Guru Pengganti', t: 'select2', opts: [] },
        { n: 'student_officer_id', l: 'Petugas Kelas', t: 'select', opts: [] },
        { n: 'meeting_title', l: 'Judul Pertemuan', t: 'text' },
        { n: 'notes', l: 'Catatan', t: 'textarea' },
      ],
    },
  },
  Kesiswaan: {
    'Data Siswa': {
      fields: [
        { n: 'nis', l: 'NIS', t: 'text', req: true },
        { n: 'nisn', l: 'NISN', t: 'text' },
        { n: 'nama_lengkap', l: 'Nama Lengkap', t: 'text', req: true },
        { n: 'class_id', l: 'Kelas', t: 'select', req: true, opts: [] },
        { n: 'jenis_kelamin', l: 'Jenis Kelamin', t: 'select', req: true, opts: ['laki-laki', 'perempuan'] },
        { n: 'tempat_lahir', l: 'Tempat Lahir', t: 'text' },
        { n: 'tanggal_lahir', l: 'Tanggal Lahir', t: 'date' },
        { n: 'alamat', l: 'Alamat', t: 'textarea' },
        { n: 'no_telepon', l: 'No. Telepon', t: 'text' },
        { n: 'status', l: 'Status', t: 'select', opts: ['aktif', 'nonaktif', 'lulus', 'keluar'] },
      ],
    },
  },
  Kepegawaian: {
    'Penugasan Guru': {
      fields: [
        { n: 'teacher_id', l: 'Guru', t: 'select2', req: true, opts: [] },
        { n: 'subject_id', l: 'Mapel', t: 'select2', req: true, opts: [] },
        { n: 'class_id', l: 'Kelas', t: 'select', req: true, opts: [] },
        { n: 'academic_year', l: 'Tahun Ajaran', t: 'select2', req: true, opts: [] },
        { n: 'assignment_title', l: 'Judul Penugasan', t: 'text' },
        { n: 'is_homeroom_teacher', l: 'Wali Kelas', t: 'boolean' },
        { n: 'status', l: 'Status', t: 'select', req: true, opts: ['active', 'inactive'] },
      ],
    },
    'Penggajian': {
      fields: [
        { n: 'periode_bulan', l: 'Periode Bulan', t: 'select', req: true, opts: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] },
        { n: 'academic_year_id', l: 'Periode Tahun', t: 'select2', req: true, opts: [] },
        { n: 'teacher_id', l: 'Guru', t: 'select2', req: true, opts: [] },
        // Select2 dipakai supaya bisa search pegawai dari dropdown.
        { n: 'gaji_pokok', l: 'Gaji Pokok', t: 'currency' },
        { n: 'tunjangan', l: 'Tunjangan', t: 'currency' },
        { n: 'potongan', l: 'Potongan', t: 'currency' },
        { n: 'total_gaji', l: 'Total Gaji', t: 'currency', readonly: true },
        { n: 'status_pembayaran', l: 'Status Pembayaran', t: 'select', opts: ['draft', 'proses', 'paid'] },
        { n: 'keterangan', l: 'Keterangan', t: 'textarea' },
      ],
    },
    'Pelatihan Guru': {
      fields: [
        { n: 'teacher_id', l: 'Guru', t: 'select2', req: true, opts: [] },
        { n: 'nama_pelatihan', l: 'Nama Pelatihan', t: 'text', req: true },
        { n: 'deskripsi', l: 'Deskripsi', t: 'textarea' },
        { n: 'penyelenggara', l: 'Penyelenggara', t: 'text' },
        { n: 'tanggal_mulai', l: 'Tanggal Mulai', t: 'date' },
        { n: 'tanggal_selesai', l: 'Tanggal Selesai', t: 'date' },
        { n: 'durasi_jam', l: 'Durasi (Jam)', t: 'number' },
        { n: 'lokasi', l: 'Lokasi', t: 'text' },
        { n: 'sertifikat_url', l: 'URL Sertifikat', t: 'text' },
        { n: 'keterangan', l: 'Keterangan', t: 'textarea' },
      ],
    },
  },
  'Sistem & Pengaturan': {
    'Tahun': {
      fields: [
        { n: 'name', l: 'Tahun Ajaran', t: 'text', req: true, ph: '2026/2027' },
        { n: 'is_active', l: 'Aktif', t: 'boolean' },
      ],
    },
    'User Management': {
      fields: [
        { n: 'email', l: 'Email', t: 'email', req: true },
        { n: 'nama_lengkap', l: 'Nama Lengkap', t: 'text', req: true },
        { n: 'role_id', l: 'Role', t: 'select', req: true, opts: [] },
        { n: 'password', l: 'Password Baru', t: 'password' },
        { n: 'status_aktif', l: 'Aktif', t: 'boolean' },
      ],
    },
    'Role & Permission': {
      fields: [
        { n: 'nama_role', l: 'Nama Role', t: 'text', req: true },
        { n: 'deskripsi', l: 'Deskripsi', t: 'textarea' },
        { n: 'kategori_role', l: 'Kategori', t: 'text' },
        { n: 'permissions_csv', l: 'Permissions (pisahkan koma)', t: 'textarea', ph: 'menu.permission.list, menu.permission.create' },
      ],
    },
    'Menu Management': {
      fields: [
        { n: 'menu_name', l: 'Nama Menu', t: 'text', req: true },
        { n: 'module_slug', l: 'Module', t: 'select', req: true, opts: [] },
        { n: 'url', l: 'URL', t: 'text' },
        { n: 'status_aktif', l: 'Aktif', t: 'boolean' },
      ],
    },
    'Permission Management': {
      fields: [
        { n: 'menu_slug', l: 'Menu', t: 'select', req: true, opts: [] },
        { n: 'action_key', l: 'Action Key', t: 'text', req: true, ph: 'create, export, publish' },
        { n: 'label', l: 'Label', t: 'text', req: true },
      ],
    },
  },
};

const RBAC = RAW_RBAC.modules && RAW_RBAC.modules.length ? RAW_RBAC : buildFallbackRbac();
const ACCESSIBLE_SCHEMA = buildAccessibleSchema();

document.addEventListener('DOMContentLoaded', function() {
  S.data = {};
  S.active = null;
  S.search = '';
  S.page = 1;
  S.perPage = 10;
  S.modal = null;
  S.trainingTeacherId = null;
  S.openMods = {};

  const firstModule = Object.keys(ACCESSIBLE_SCHEMA)[0] || null;
  if (firstModule) {
    S.openMods[firstModule] = true;
  }

  Object.entries(ACCESSIBLE_SCHEMA).forEach(([mod, info]) => {
    Object.entries(info.menus).forEach(([menu, mdata]) => {
      S.data[menuKey(mod, menu)] = {
        fields: JSON.parse(JSON.stringify(mdata.fields || [])),
        rows: [],
        meta: {},
        loaded: false,
        loading: false,
      };
    });
  });

  if (!firstModule) {
    renderSidebar();
    renderNoAccess();
    return;
  }

  const requestedMenuSlug = new URLSearchParams(window.location.search).get('menu');
  const requestedMenu = requestedMenuSlug ? findMenuBySlug(requestedMenuSlug) : null;

  if (requestedMenu) {
    S.openMods = { [requestedMenu.mod]: true };
    selectMenuByState(requestedMenu.mod, requestedMenu.menu);
    return;
  }

  syncUrlWithMenu(null);
  showDashboard();
});

function buildFallbackRbac() {
  return {
    user: RAW_RBAC.user || { name: 'Admin', roles: ['admin'] },
    modules: Object.entries(SCHEMA).map(([moduleName, info]) => ({
      name: moduleName,
      slug: moduleName,
      icon: info.icon,
      color: info.color,
      menus: Object.keys(info.menus).map(menuName => ({
        name: menuName,
        slug: menuName,
        permissions: {
          list: true,
          detail: true,
          create: true,
          update: true,
          delete: true,
        },
        permission_list: [
          { key: 'list', label: 'List' },
          { key: 'detail', label: 'Detail' },
          { key: 'create', label: 'Create' },
          { key: 'update', label: 'Update' },
          { key: 'delete', label: 'Delete' },
        ],
      })),
    })),
  };
}

function buildAccessibleSchema() {
  const out = {};

  RBAC.modules.forEach(module => {
    const filteredMenus = {};

    (module.menus || []).forEach(menu => {
      const schemaDef = resolveSchema(module.name, menu.name);

      if (!schemaDef) {
        return;
      }

      filteredMenus[menu.name] = {
        ...schemaDef,
        slug: menu.slug,
        permissions: menu.permissions || {},
        permissionList: menu.permission_list || [],
      };
    });

    if (Object.keys(filteredMenus).length) {
      out[module.name] = {
        icon: module.icon || SCHEMA[module.name]?.icon || '•',
        color: module.color || SCHEMA[module.name]?.color || '#6B7280',
        menus: filteredMenus,
      };
    }
  });

  return out;
}

function resolveSchema(moduleName, menuName) {
  if (EXTRA_MENU_SCHEMA[moduleName] && EXTRA_MENU_SCHEMA[moduleName][menuName]) {
    return EXTRA_MENU_SCHEMA[moduleName][menuName];
  }

  return SCHEMA[moduleName]?.menus?.[menuName] || null;
}

function menuKey(mod, menu) {
  return `${mod}::${menu}`;
}

function getState(mod, menu) {
  return S.data[menuKey(mod, menu)];
}

function getMenuSchema(mod, menu) {
  return ACCESSIBLE_SCHEMA[mod]?.menus?.[menu] || null;
}

function getMenuSlug(mod, menu) {
  return getMenuSchema(mod, menu)?.slug || null;
}

function findMenuBySlug(slug) {
  for (const [mod, info] of Object.entries(ACCESSIBLE_SCHEMA)) {
    for (const [menu, schema] of Object.entries(info.menus)) {
      if (schema.slug === slug) {
        return { mod, menu };
      }
    }
  }

  return null;
}

function getMenuPermissions(mod, menu) {
  return getMenuSchema(mod, menu)?.permissions || {};
}

function getPermissionList(mod, menu) {
  return getMenuSchema(mod, menu)?.permissionList || [];
}

function getResourceConfig(mod, menu) {
  const schema = getMenuSchema(mod, menu);

  switch (menu) {
    case 'Kelas':
      return {
        endpoint: '/admin/api/classes',
        fields: fields => hydrateClassFields(fields, getState(mod, menu).meta || {}),
        rowFromApi: row => row,
        rowToApi: row => ({
          name: row.name,
          tingkat: row.tingkat ? parseInt(row.tingkat, 10) : null,
          jurusan: row.jurusan,
          kapasitas: row.kapasitas ? parseInt(row.kapasitas, 10) : null,
          ruang_kelas: row.ruang_kelas,
          tahun_ajaran: row.tahun_ajaran,
        }),
      };
    case 'Tahun':
      return {
        endpoint: '/admin/api/academic-years',
        rowFromApi: row => row,
        rowToApi: row => ({
          name: row.name,
          is_active: Boolean(row.is_active),
        }),
      };
    case 'Mata Pelajaran':
      return {
        endpoint: '/admin/api/subjects',
        rowFromApi: row => row,
        rowToApi: row => ({
          kode: row.kode,
          nama: row.nama,
          kelompok: row.kelompok,
          kkm: row.kkm ? parseInt(row.kkm, 10) : 0,
        }),
      };
    case 'Data Siswa':
      return {
        endpoint: '/admin/api/students',
        fields: fields => hydrateStudentFields(fields, getState(mod, menu).meta || {}),
        rowFromApi: row => row,
        rowToApi: row => ({
          nis: row.nis,
          nisn: row.nisn || null,
          nama_lengkap: row.nama_lengkap,
          class_id: parseInt(row.class_id, 10),
          jenis_kelamin: row.jenis_kelamin,
          tempat_lahir: row.tempat_lahir,
          tanggal_lahir: row.tanggal_lahir || null,
          alamat: row.alamat,
          no_telepon: row.no_telepon,
          status: row.status || 'aktif',
        }),
      };
    case 'User Management':
      return {
        endpoint: '/admin/api/users',
        fields: fields => hydrateSelectOptions(fields, 'role_id', getState(mod, menu).meta.roles || []),
        rowFromApi: row => ({ ...row, password: '' }),
        rowToApi: row => ({
          email: row.email,
          nama_lengkap: row.nama_lengkap,
          role_id: row.role_id,
          password: row.password || undefined,
          status_aktif: Boolean(row.status_aktif),
        }),
      };
    case 'Role & Permission':
      return {
        endpoint: '/admin/api/roles',
        rowFromApi: row => ({ ...row, permissions_csv: (row.permissions || []).join(', ') }),
        rowToApi: row => ({
          nama_role: row.nama_role,
          deskripsi: row.deskripsi,
          kategori_role: row.kategori_role,
          permissions: splitCsv(row.permissions_csv),
        }),
      };
    case 'Permission Management':
      return {
        endpoint: '/admin/api/permissions',
        fields: fields => hydrateSelectOptions(fields, 'menu_slug', (getState(mod, menu).meta.menus || []).map(item => item.slug)),
        rowFromApi: row => ({
          id: row.id,
          menu_slug: row.menu_slug,
          action_key: row.action_key,
          label: row.label,
          permission_name: row.permission_name,
        }),
        rowToApi: row => ({
          menu_slug: row.menu_slug,
          action_key: row.action_key,
          label: row.label,
        }),
      };
    case 'Menu Management':
      return {
        endpoint: '/admin/api/menus',
        fields: fields => hydrateSelectOptions(fields, 'module_slug', (getState(mod, menu).meta.modules || []).map(item => item.slug)),
        rowFromApi: row => ({
          id: row.id,
          module_slug: row.module_slug,
          module_name: row.module_name,
          menu_name: row.menu_name,
          slug: row.slug,
          url: row.url,
          status_aktif: row.status_aktif,
        }),
        rowToApi: row => ({
          module_slug: row.module_slug,
          menu_name: row.menu_name,
          url: row.url,
          status_aktif: Boolean(row.status_aktif),
        }),
      };
    case 'Absensi Siswa':
      return {
        endpoint: '/admin/api/attendance-sessions',
        fields: fields => hydrateAttendanceFields(fields, getState(mod, menu).meta || {}),
        rowFromApi: row => row,
        rowToApi: row => ({
          attendance_date: row.attendance_date,
          start_time: row.start_time,
          end_time: row.end_time,
          class_id: parseInt(row.class_id, 10),
          subject_id: parseInt(row.subject_id, 10),
          teacher_id: parseInt(row.teacher_id, 10),
          teacher_attendance_status: row.teacher_attendance_status,
          attendance_taker_type: row.attendance_taker_type,
          substitute_teacher_id: row.substitute_teacher_id ? parseInt(row.substitute_teacher_id, 10) : null,
          student_officer_id: row.student_officer_id ? parseInt(row.student_officer_id, 10) : null,
          meeting_title: row.meeting_title,
          notes: row.notes,
          students: row.students || [],
        }),
      };
    case 'Penugasan Guru':
      return {
        endpoint: '/admin/api/teacher-assignments',
        fields: fields => hydrateTeacherAssignmentFields(fields, getState(mod, menu).meta || {}),
        rowFromApi: row => row,
        rowToApi: row => ({
          teacher_id: parseInt(row.teacher_id, 10),
          subject_id: parseInt(row.subject_id, 10),
          class_id: parseInt(row.class_id, 10),
          academic_year: row.academic_year,
          assignment_title: row.assignment_title,
          is_homeroom_teacher: Boolean(row.is_homeroom_teacher),
          status: row.status,
        }),
      };
    case 'Penggajian':
      return {
        endpoint: '/admin/api/payrolls',
        fields: fields => hydratePayrollFields(fields, getState(mod, menu).meta || {}),
        rowFromApi: row => ({
          ...row,
          academic_year_id: row.academic_year_id,
          academic_year_label: row.academic_year_label || row.periode_tahun,
          gaji_pokok: formatCurrencyInputValue(row.gaji_pokok),
          tunjangan: formatCurrencyInputValue(row.tunjangan),
          potongan: formatCurrencyInputValue(row.potongan),
          total_gaji: formatCurrencyInputValue(row.total_gaji),
        }),
        rowToApi: row => ({
          teacher_id: parseInt(row.teacher_id, 10),
          academic_year_id: parseInt(row.academic_year_id, 10),
          periode_bulan: row.periode_bulan,
          nama_pegawai: row.nama_pegawai,
          gaji_pokok: parseCurrencyInputValue(row.gaji_pokok),
          tunjangan: parseCurrencyInputValue(row.tunjangan),
          potongan: parseCurrencyInputValue(row.potongan),
          total_gaji: parseCurrencyInputValue(row.total_gaji),
          status_pembayaran: row.status_pembayaran,
          keterangan: row.keterangan,
        }),
      };
    case 'Pelatihan Guru':
      return {
        endpoint: `/admin/api/menu-data/${encodeURIComponent(schema.slug)}`,
        fields: fields => hydrateTrainingFields(fields, getState(mod, menu).meta || {}),
        rowFromApi: row => ({
          ...row,
          teacher_id: row.teacher_id ? String(row.teacher_id) : '',
        }),
        rowToApi: row => ({
          teacher_id: row.teacher_id ? parseInt(row.teacher_id, 10) : null,
          nama_pelatihan: row.nama_pelatihan,
          deskripsi: row.deskripsi,
          penyelenggara: row.penyelenggara,
          tanggal_mulai: row.tanggal_mulai || null,
          tanggal_selesai: row.tanggal_selesai || null,
          durasi_jam: row.durasi_jam ? parseInt(row.durasi_jam, 10) : null,
          lokasi: row.lokasi,
          sertifikat_url: row.sertifikat_url,
          keterangan: row.keterangan,
        }),
      };
    case 'Absensi Guru':
      return {
        endpoint: '/admin/api/teacher-attendances',
        rowFromApi: row => row,
        rowToApi: row => ({
          attendance_date: row.attendance_date,
          status: row.status,
          check_in_at: row.check_in_at,
          check_out_at: row.check_out_at,
          notes: row.notes,
        }),
      };
    default:
      return {
        endpoint: `/admin/api/menu-data/${encodeURIComponent(schema.slug)}`,
        rowFromApi: row => row,
        rowToApi: row => {
          const payload = { ...row };
          delete payload.id;
          return payload;
        },
      };
  }
}

function hydrateSelectOptions(fields, fieldName, options) {
  return fields.map(field => {
    if (field.n !== fieldName) {
      return field;
    }

    return {
      ...field,
      opts: options,
    };
  });
}

function hydrateAttendanceFields(fields, meta) {
  const classes = (meta.classes || []).map(item => ({ value: String(item.id), label: item.name }));
  const subjects = (meta.subjects || []).map(item => ({ value: String(item.id), label: item.nama }));
  const teachers = (meta.teachers || []).map(item => ({ value: String(item.id), label: item.name }));
  const officers = (meta.student_officers || []).map(item => ({ value: String(item.id), label: item.name }));

  return fields.map(field => {
    switch (field.n) {
      case 'class_id':
        return { ...field, opts: classes };
      case 'subject_id':
      case 'teacher_id':
      case 'substitute_teacher_id':
        return { ...field, opts: field.n === 'subject_id' ? subjects : teachers };
      case 'student_officer_id':
        return { ...field, opts: officers };
      default:
        return field;
    }
  });
}

function hydratePayrollFields(fields, meta) {
  const teachers = (meta.teachers || []).map(item => ({ value: String(item.value), label: item.label }));
  const academicYears = (meta.academic_years || []).map(item => ({ value: String(item.value), label: item.label }));

  return fields.map(field => {
    if (field.n === 'teacher_id') {
      return { ...field, opts: teachers };
    }
    if (field.n === 'academic_year_id') {
      return { ...field, opts: academicYears };
    }

    return field;
  });
}

function hydrateTrainingFields(fields, meta) {
  const teachers = (meta.teachers || []).map(item => ({ value: String(item.value), label: item.label }));

  return fields.map(field => {
    if (field.n === 'teacher_id') {
      return { ...field, opts: teachers };
    }

    return field;
  });
}

function hydrateTeacherAssignmentFields(fields, meta) {
  const teachers = (meta.teachers || []).map(item => ({
    value: String(item.id),
    label: item.name,
  }));
  const subjects = (meta.subjects || []).map(item => ({ value: String(item.id), label: item.nama }));
  const classes = (meta.classes || []).map(item => ({ value: String(item.id), label: item.name }));
  const academicYears = (meta.academic_years || []).map(item => ({ value: String(item.name), label: item.name }));

  return fields.map(field => {
    if (field.n === 'teacher_id') {
      return { ...field, opts: teachers };
    }
    if (field.n === 'subject_id') {
      return { ...field, opts: subjects };
    }
    if (field.n === 'class_id') {
      return { ...field, opts: classes };
    }
    if (field.n === 'academic_year') {
      return { ...field, opts: academicYears };
    }
    return field;
  });
}

function hydrateStudentFields(fields, meta) {
  const classes = (meta.classes || []).map(item => ({ value: String(item.id), label: item.name }));

  return fields.map(field => {
    if (field.n === 'class_id') {
      return { ...field, opts: classes };
    }
    return field;
  });
}

function hydrateClassFields(fields, meta) {
  const academicYears = (meta.academic_years || []).map(item => ({ value: String(item.name), label: item.name }));

  return fields.map(field => {
    if (field.n === 'tahun_ajaran') {
      return { ...field, opts: academicYears };
    }

    return field;
  });
}

function withDefaultValue(rowData, fieldName, options) {
  if (rowData[fieldName] !== undefined && rowData[fieldName] !== null && rowData[fieldName] !== '') {
    return rowData;
  }

  if (!options.length) {
    return rowData;
  }

  const firstOption = options[0];
  const value = typeof firstOption === 'object' ? firstOption.value : firstOption;

  return {
    ...rowData,
    [fieldName]: value,
  };
}

function splitCsv(value) {
  return String(value || '')
    .split(',')
    .map(item => item.trim())
    .filter(Boolean);
}

function can(action) {
  if (!S.active) {
    return false;
  }

  return Boolean(getMenuPermissions(S.active.mod, S.active.menu)[action]);
}

function actionBadge(label) {
  return `<span style="padding:4px 8px;border-radius:999px;background:#EEF2FF;color:#4338CA;font-size:0.7rem;font-weight:700">${esc(label)}</span>`;
}

function renderPermissionSummary(mod, menu) {
  const permissions = getPermissionList(mod, menu);

  if (!permissions.length) {
    return '<span style="font-size:0.78rem;color:#9CA3AF">Tidak ada permission aktif.</span>';
  }

  return permissions.map(item => actionBadge(item.label)).join('');
}

function renderNoAccess() {
  document.getElementById('tb-title').innerHTML = '<div style="font-size:1rem;font-weight:700;color:#111827">Akses Admin</div>';
  document.getElementById('main-content').innerHTML =
    `<div style="background:white;border:1px solid #E5E7EB;border-radius:16px;padding:28px;max-width:720px">
      <div style="font-size:0.78rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#DC2626;margin-bottom:8px">Akses terbatas</div>
      <div style="font-size:1.2rem;font-weight:800;color:#111827;margin-bottom:10px">Belum ada menu yang diberikan ke role login ini.</div>
      <div style="font-size:0.9rem;line-height:1.7;color:#4B5563">Pastikan role user memiliki permission menu di RBAC Spatie. Sidebar akan otomatis tampil jika permission sudah diberikan.</div>
    </div>`;
}

function renderSidebar() {
  let h = '';
  Object.entries(ACCESSIBLE_SCHEMA).forEach(([mod, info]) => {
    const open = Boolean(S.openMods[mod]);
    h += `<div style="margin-bottom:2px">
      <button class="module-btn" onclick="toggleModule(this)" data-mod="${esc(mod)}">
        <span style="flex-shrink:0;font-size:1rem">${info.icon}</span>
        <span class="sb-label" style="flex:1;line-height:1.3">${esc(mod)}</span>
        <span class="sb-label" style="font-size:0.65rem;color:rgba(255,255,255,0.3)">${open ? '▲' : '▼'}</span>
      </button>`;
    if (open && !S.collapsed) {
      h += '<div style="padding-left:8px">';
      Object.keys(info.menus).forEach(menu => {
        const isActive = S.active?.mod === mod && S.active?.menu === menu;
        h += `<button class="submenu-btn" onclick="selectMenu(this)" data-mod="${esc(mod)}" data-menu="${esc(menu)}"
          style="border-left:2px solid ${isActive ? info.color : 'transparent'};
                 background:${isActive ? info.color + '25' : 'none'};
                 color:${isActive ? info.color : 'rgba(255,255,255,0.45)'};
                 font-weight:${isActive ? 600 : 400}">${esc(menu)}</button>`;
      });
      h += '</div>';
    }
    h += '</div>';
  });
  document.getElementById('sb-modules').innerHTML = h || '<div style="padding:12px 10px;color:rgba(255,255,255,0.45);font-size:0.78rem">Tidak ada menu.</div>';
}

function showDashboard() {
  S.active = null;
  S.search = '';
  S.page = 1;
  document.getElementById('search').value = '';
  syncUrlWithMenu(null);
  const firstModule = Object.keys(ACCESSIBLE_SCHEMA)[0] || null;
  S.openMods = firstModule ? { [firstModule]: true } : {};
  const hb = document.getElementById('btn-home');
  hb.style.background = 'rgba(27,107,58,0.3)';
  hb.style.color = '#4ADE80';
  document.getElementById('tb-title').innerHTML = '<div style="font-size:1rem;font-weight:700;color:#111827">Dashboard</div>';
  renderSidebar();
  renderDashboard();
}

async function selectMenu(btn) {
  await selectMenuByState(btn.dataset.mod, btn.dataset.menu);
}

async function selectMenuByState(mod, menu) {
  S.active = { mod, menu, key: menuKey(mod, menu) };
  S.search = '';
  S.page = 1;
  S.openMods = { [mod]: true };
  document.getElementById('search').value = '';
  syncUrlWithMenu(getMenuSlug(mod, menu));
  const hb = document.getElementById('btn-home');
  hb.style.background = 'none';
  hb.style.color = 'rgba(255,255,255,0.6)';
  const info = ACCESSIBLE_SCHEMA[mod];
  document.getElementById('tb-title').innerHTML =
    `<div style="font-size:0.7rem;color:#9CA3AF;font-weight:500">${esc(mod)} / <span style="color:${info.color}">${esc(menu)}</span></div>
     <div style="font-size:1rem;font-weight:700;color:#111827;line-height:1;margin-top:2px">${esc(menu)}</div>`;
  renderSidebar();
  await loadMenuRows(mod, menu);
  renderTable();
}

function toggleModule(btn) {
  const mod = btn.dataset.mod;
  const isOpen = Boolean(S.openMods[mod]);
  S.openMods = isOpen ? {} : { [mod]: true };
  renderSidebar();
}

function syncUrlWithMenu(menuSlug) {
  const url = new URL(window.location.href);

  if (menuSlug) {
    url.searchParams.set('menu', menuSlug);
  } else {
    url.searchParams.delete('menu');
  }

  window.history.replaceState({}, '', url.toString());
}

function renderDashboard() {
  const modules = Object.entries(ACCESSIBLE_SCHEMA);
  const totalMenus = modules.reduce((sum, [, info]) => sum + Object.keys(info.menus).length, 0);
  const grantedPermissions = RBAC.modules.reduce((sum, module) => sum + (module.menus || []).reduce((carry, menu) => carry + Object.keys(menu.permissions || {}).length, 0), 0);
  const roleLabel = ((RBAC.user && RBAC.user.roles) || []).join(', ') || 'tanpa role';
  const stats = [
    { label: 'Modul Aktif', val: String(modules.length), icon: '🧩', color: '#2563EB' },
    { label: 'Menu Tersedia', val: String(totalMenus), icon: '🗂️', color: '#16A34A' },
    { label: 'Permission Aktif', val: String(grantedPermissions), icon: '🔐', color: '#D97706' },
    { label: 'Role Login', val: roleLabel, icon: '👤', color: '#7C3AED' },
  ];
  const acts = [
    { t: `Role aktif: ${roleLabel}`, time: 'sesi saat ini', c: '#7C3AED' },
    { t: `${modules.length} modul berhasil dimuat dari RBAC`, time: 'database', c: '#2563EB' },
    { t: `${totalMenus} menu tersedia untuk user login`, time: 'permission menu', c: '#16A34A' },
    { t: 'Endpoint backend dijaga middleware permission', time: 'server guard', c: '#EA580C' },
  ];
  const statsHtml = stats.map(s =>
    `<div style="background:white;border-radius:12px;padding:20px;border:1px solid #E5E7EB;display:flex;align-items:center;gap:16px">
      <div style="width:48px;height:48px;border-radius:12px;background:${s.color}15;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">${s.icon}</div>
      <div>
        <div style="font-size:1.15rem;font-weight:800;color:#111827;line-height:1.2">${esc(s.val)}</div>
        <div style="font-size:0.78rem;color:#6B7280;margin-top:4px">${s.label}</div>
      </div>
    </div>`).join('');
  const actsHtml = acts.map((a, i) =>
    `<div style="display:flex;gap:12px;padding-bottom:12px;${i < acts.length - 1 ? 'border-bottom:1px solid #F3F4F6;' : ''}margin-bottom:12px">
      <div style="width:8px;height:8px;border-radius:50%;background:${a.c};margin-top:6px;flex-shrink:0"></div>
      <div>
        <div style="font-size:0.825rem;color:#374151">${esc(a.t)}</div>
        <div style="font-size:0.73rem;color:#9CA3AF;margin-top:2px">${esc(a.time)}</div>
      </div>
    </div>`).join('');
  const modHtml = modules.map(([mod, info]) =>
    `<div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid #F3F4F6;margin-bottom:10px">
      <div style="display:flex;align-items:center;gap:8px">
        <span>${info.icon}</span>
        <span style="font-size:0.8rem;color:#374151;font-weight:500">${esc(mod)}</span>
      </div>
      <div style="display:flex;align-items:center;gap:6px">
        <div style="font-size:0.73rem;color:#6B7280">${Object.keys(info.menus).length} menu</div>
        ${badge('aktif')}
      </div>
    </div>`).join('');
  document.getElementById('main-content').innerHTML =
    `<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">${statsHtml}</div>
     <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
       <div style="background:white;border-radius:12px;padding:20px;border:1px solid #E5E7EB">
         <div style="font-size:0.85rem;font-weight:700;color:#374151;margin-bottom:16px">Status RBAC</div>
         ${actsHtml}
       </div>
       <div style="background:white;border-radius:12px;padding:20px;border:1px solid #E5E7EB">
         <div style="font-size:0.85rem;font-weight:700;color:#374151;margin-bottom:16px">Modul Yang Bisa Diakses</div>
         ${modHtml}
       </div>
     </div>`;
}

async function loadMenuRows(mod, menu, force = false) {
  const state = getState(mod, menu);
  if (!state || (state.loaded && !force)) {
    return;
  }

  const config = getResourceConfig(mod, menu);
  state.loading = true;

  try {
    const response = await requestJson(config.endpoint);
    state.rows = (response.data || []).map(config.rowFromApi || (row => row));
    state.meta = response.meta || {};
    state.fields = JSON.parse(JSON.stringify((config.fields ? config.fields(getMenuSchema(mod, menu).fields) : getMenuSchema(mod, menu).fields) || []));
    state.loaded = true;
  } catch (error) {
    state.rows = [];
    state.meta = {};
    state.loaded = true;
    alert(error.message);
  } finally {
    state.loading = false;
  }
}

function renderTable() {
  const { mod, menu, key } = S.active;
  const info = ACCESSIBLE_SCHEMA[mod];
  const schema = getMenuSchema(mod, menu);
  const permissions = getMenuPermissions(mod, menu);
  const state = S.data[key];

  if (state.loading) {
    document.getElementById('main-content').innerHTML =
      `<div style="background:white;border-radius:12px;padding:24px;border:1px solid #E5E7EB;color:#6B7280">Memuat data ${esc(menu)}...</div>`;
    return;
  }

  const allRows = state.rows;
  const normalizedSearch = String(S.search || '').toLowerCase();
  const rows = normalizedSearch
    ? allRows.filter(r => Object.values(r).some(v => String(v ?? '').toLowerCase().includes(normalizedSearch)))
    : allRows;
  const totalRows = rows.length;
  const totalPages = Math.max(1, Math.ceil(totalRows / S.perPage));
  const currentPage = Math.min(S.page, totalPages);
  const startIndex = (currentPage - 1) * S.perPage;
  const pagedRows = rows.slice(startIndex, startIndex + S.perPage);

  if (!permissions.list && !permissions.detail) {
    document.getElementById('main-content').innerHTML =
      `<div style="background:white;border-radius:12px;padding:24px;border:1px solid #E5E7EB">
        <div style="font-size:0.8rem;font-weight:700;color:${info.color};margin-bottom:8px">Permission Menu</div>
        <div style="font-size:1.05rem;font-weight:800;color:#111827;margin-bottom:10px">${esc(menu)}</div>
        <div style="font-size:0.88rem;color:#4B5563;line-height:1.7;margin-bottom:16px">Role ini memiliki akses ke menu, tetapi tidak memiliki izin untuk menampilkan daftar data.</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">${renderPermissionSummary(mod, menu)}</div>
      </div>`;
    return;
  }

  if (menu === 'Absensi Guru') {
    renderTeacherAttendanceView(state, permissions, info);
    return;
  }

  const cols = menu === 'Absensi Siswa'
    ? [
        { n: 'attendance_date', l: 'Tanggal', t: 'date' },
        { n: 'class_name', l: 'Kelas', t: 'text' },
        { n: 'subject_name', l: 'Mapel', t: 'text' },
        { n: 'teacher_name', l: 'Guru', t: 'text' },
        { n: 'summary_badge', l: 'Ringkasan', t: 'text' },
      ]
    : menu === 'Penggajian'
      ? [
          { n: 'slip_number', l: 'Slip', t: 'text' },
          { n: 'teacher_name', l: 'Guru', t: 'text' },
          { n: 'periode_label', l: 'Periode', t: 'text' },
          { n: 'gaji_pokok', l: 'Gaji Pokok', t: 'currency' },
          { n: 'tunjangan', l: 'Tunjangan', t: 'currency' },
          { n: 'potongan', l: 'Potongan', t: 'currency' },
          { n: 'total_gaji', l: 'Total Gaji', t: 'currency' },
          { n: 'status_pembayaran', l: 'Status', t: 'text' },
        ]
    : menu === 'Data Siswa'
      ? [
          { n: 'nis', l: 'NIS', t: 'text' },
          { n: 'nama_lengkap', l: 'Nama Siswa', t: 'text' },
          { n: 'class_name', l: 'Kelas', t: 'text' },
          { n: 'jenis_kelamin', l: 'Gender', t: 'text' },
          { n: 'status', l: 'Status', t: 'text' },
        ]
    : menu === 'Penugasan Guru'
      ? [
          { n: 'teacher_name', l: 'Guru', t: 'text' },
          { n: 'subject_name', l: 'Mapel', t: 'text' },
          { n: 'class_name', l: 'Kelas', t: 'text' },
          { n: 'academic_year', l: 'Tahun Ajaran', t: 'text' },
          { n: 'status', l: 'Status', t: 'text' },
        ]
    : state.fields.slice(0, 5);
  const theadCols = cols.map(c => `<th style="${TH}">${esc(c.l)}</th>`).join('');
  let tbody;

  if (pagedRows.length === 0) {
    tbody = `<tr><td colspan="${cols.length + 2}" style="text-align:center;padding:40px 20px;color:#9CA3AF">Belum ada data untuk menu ini.</td></tr>`;
  } else {
    tbody = pagedRows.map((row, i) => {
      const cells = cols.map(c => {
        const val = c.n === 'summary_badge' ? renderAttendanceSummary(row.summary || {}) : row[c.n];
        let content;
        if (c.n === 'summary_badge') {
          content = val;
        } else if (c.t === 'boolean') {
          content = badge(val ? 'Ya' : 'Tidak');
        } else if (c.t === 'currency') {
          content = `<span style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block">${esc(formatCurrencyRupiah(val))}</span>`;
        } else if (val !== null && val !== undefined && SC[String(val).toLowerCase()]) {
          content = badge(val);
        } else {
          const disp = val !== null && val !== undefined ? esc(val) : '<span style="color:#D1D5DB">—</span>';
          content = `<span style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block">${disp}</span>`;
        }
        return `<td style="${TD}">${content}</td>`;
      }).join('');

      const actions = [];
      if (permissions.detail) {
        actions.push(`<button onclick="openDetail(${row.id})" style="padding:4px 12px;border-radius:6px;border:1px solid #CBD5E1;background:#F8FAFC;color:#334155;font-size:0.75rem;font-weight:600;cursor:pointer">${menu === 'Penggajian' ? 'Slip' : 'Lihat'}</button>`);
      }
      if (permissions.update) {
        actions.push(`<button onclick="openEdit(${row.id})" style="padding:4px 12px;border-radius:6px;border:1px solid ${info.color}40;background:${info.color}10;color:${info.color};font-size:0.75rem;font-weight:600;cursor:pointer">Edit</button>`);
      }
      if (permissions.delete) {
        actions.push(`<button onclick="deleteRow(${row.id})" style="padding:4px 12px;border-radius:6px;border:1px solid #FCA5A540;background:#FEF2F2;color:#DC2626;font-size:0.75rem;font-weight:600;cursor:pointer">Hapus</button>`);
      }

      return `<tr style="border-bottom:1px solid #F3F4F6" onmouseenter="this.style.background='#F9FAFB'" onmouseleave="this.style.background=''">
        <td style="${TD}color:#9CA3AF;text-align:center">${startIndex + i + 1}</td>
        ${cells}
        <td style="${TD}text-align:center">
          <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
            ${actions.length ? actions.join('') : '<span style="font-size:0.74rem;color:#9CA3AF">Tidak ada aksi</span>'}
          </div>
        </td>
      </tr>`;
    }).join('');
  }

  const topActions = [];
  if (permissions.create) {
    topActions.push(`<button onclick="openAdd()" style="padding:8px 18px;border-radius:8px;border:none;background:${info.color};cursor:pointer;font-size:0.85rem;font-weight:700;color:white;display:flex;align-items:center;gap:6px;box-shadow:0 4px 14px ${info.color}40">+ Tambah</button>`);
  }
  if (menu === 'Data Siswa') {
    topActions.push(`<a href="/admin/api/students/template" style="padding:8px 14px;border-radius:8px;border:1px solid #D1D5DB;background:white;color:#374151;font-size:0.82rem;font-weight:700;text-decoration:none">Download Template</a>`);
    topActions.push(`<a href="/admin/api/students/template-sample" style="padding:8px 14px;border-radius:8px;border:1px solid #BFDBFE;background:#EFF6FF;color:#1D4ED8;font-size:0.82rem;font-weight:700;text-decoration:none">Download Contoh</a>`);
  }

  const paginationHtml = totalRows > 0
    ? `<div style="margin-top:12px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
         <div style="font-size:0.78rem;color:#9CA3AF">Menampilkan ${startIndex + 1}-${Math.min(startIndex + S.perPage, totalRows)} dari ${totalRows} data</div>
         <div style="display:flex;align-items:center;gap:8px">
           <button onclick="changePage(-1)" ${currentPage === 1 ? 'disabled' : ''} style="padding:7px 12px;border-radius:8px;border:1px solid #E5E7EB;background:white;cursor:${currentPage === 1 ? 'not-allowed' : 'pointer'};font-size:0.8rem;color:${currentPage === 1 ? '#9CA3AF' : '#374151'}">Sebelumnya</button>
           <span style="font-size:0.8rem;color:#6B7280">Halaman ${currentPage} / ${totalPages}</span>
           <button onclick="changePage(1)" ${currentPage === totalPages ? 'disabled' : ''} style="padding:7px 12px;border-radius:8px;border:1px solid #E5E7EB;background:white;cursor:${currentPage === totalPages ? 'not-allowed' : 'pointer'};font-size:0.8rem;color:${currentPage === totalPages ? '#9CA3AF' : '#374151'}">Berikutnya</button>
         </div>
       </div>`
    : '';

  document.getElementById('main-content').innerHTML =
    `<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;gap:16px">
       <div>
         <div style="font-size:0.82rem;color:#6B7280">Total <strong style="color:#111827">${allRows.length}</strong> data</div>
       </div>
       <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end">${topActions.join('')}</div>
     </div>
     <div style="overflow-x:auto;border-radius:12px;border:1px solid #E5E7EB;background:white">
       <table style="width:100%;border-collapse:collapse;font-size:0.855rem">
         <thead>
           <tr style="background:#F9FAFB;border-bottom:1px solid #E5E7EB">
             <th style="${TH}width:50px">No</th>
             ${theadCols}
             <th style="${TH}width:220px;text-align:center">Aksi</th>
           </tr>
         </thead>
         <tbody>${tbody}</tbody>
       </table>
     </div>
     ${paginationHtml}`;
}

function openAdd() {
  if (!can('create')) {
    alert('Role ini tidak memiliki izin create.');
    return;
  }

  S.modal = { type: 'add' };
  renderModal();
}

function openDetail(id) {
  if (!can('detail')) {
    alert('Role ini tidak memiliki izin detail.');
    return;
  }

  const row = getState(S.active.mod, S.active.menu).rows.find(r => r.id == id);
  S.modal = { type: 'detail', row };
  renderModal();
}

function openEdit(id) {
  if (!can('update')) {
    alert('Role ini tidak memiliki izin update.');
    return;
  }

  const row = getState(S.active.mod, S.active.menu).rows.find(r => r.id == id);
  S.modal = { type: 'edit', row };
  renderModal();
}

async function openTrainingForTeacher(teacherId) {
  const target = findMenuBySlug('kepegawaian.pelatihan-guru');

  if (!target) {
    alert('Menu Pelatihan Guru tidak tersedia.');
    return;
  }

  S.trainingTeacherId = String(teacherId || '');
  await selectMenuByState(target.mod, target.menu);
  openAdd();
}

function renderModal() {
  const { mod, menu } = S.active;
  const info = ACCESSIBLE_SCHEMA[mod];
  const fields = getState(mod, menu).fields;
  const mode = S.modal.type;
  let rowData = mode === 'add' ? {} : (S.modal.row || {});
  const isReadOnly = mode === 'detail';
  const titleMap = {
    add: 'Tambah Data Baru',
    edit: 'Edit Data',
    detail: 'Detail Data',
  };

  document.getElementById('modal-hdr').innerHTML =
    `<div style="padding:18px 24px;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;background:${info.color}0D">
       <div>
         <div style="font-size:0.72rem;font-weight:700;color:${info.color};text-transform:uppercase;letter-spacing:0.1em;margin-bottom:2px">${titleMap[mode]}</div>
         <div style="font-size:1rem;font-weight:700;color:#111827">${esc(menu)}</div>
       </div>
       <button onclick="closeModal()" style="background:none;border:none;cursor:pointer;width:32px;height:32px;border-radius:8px;font-size:1.2rem;color:#9CA3AF">✕</button>
     </div>`;

  if (menu === 'Absensi Siswa') {
    renderAttendanceModal(info, fields, rowData, isReadOnly);
    return;
  }

  if (menu === 'Penugasan Guru' && mode === 'add') {
    rowData = withDefaultValue(rowData, 'teacher_id', getFieldOptions(fields, 'teacher_id'));
    rowData = withDefaultValue(rowData, 'subject_id', getFieldOptions(fields, 'subject_id'));
    rowData = withDefaultValue(rowData, 'class_id', getFieldOptions(fields, 'class_id'));
    rowData = withDefaultValue(rowData, 'status', getFieldOptions(fields, 'status'));
  }

  if (menu === 'Penggajian' && mode === 'add') {
    rowData = withDefaultValue(rowData, 'academic_year_id', getFieldOptions(fields, 'academic_year_id'));
  }

  if (menu === 'Pelatihan Guru' && mode === 'add' && S.trainingTeacherId) {
    rowData = {
      ...rowData,
      teacher_id: String(S.trainingTeacherId),
    };
    S.trainingTeacherId = null;
  }

  let formHtml = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">';
  fields.forEach(f => {
    const val = rowData[f.n] ?? '';
    const span = (f.t === 'textarea' || f.t === 'datetime-local') ? 'grid-column:1/-1' : '';
    const req = f.req ? '<span style="color:#DC2626;margin-left:2px">*</span>' : '';
    let input;

    if (f.t === 'boolean') {
      input = `<label style="display:flex;align-items:center;gap:8px;cursor:${isReadOnly ? 'default' : 'pointer'}">
        <input type="checkbox" name="${f.n}" ${val ? 'checked' : ''} ${isReadOnly ? 'disabled' : ''} style="width:16px;height:16px;accent-color:${info.color}">
        <span style="font-size:0.82rem;color:#6B7280">Ya / Aktif</span>
      </label>`;
    } else if (f.t === 'select' || f.t === 'select2') {
      const opts = (f.opts || []).map(option => {
        const optionValue = typeof option === 'object' ? option.value : option;
        const optionLabel = typeof option === 'object' ? option.label : option;
        return `<option value="${esc(optionValue)}"${String(optionValue) === String(val) ? ' selected' : ''}>${esc(optionLabel)}</option>`;
      }).join('');
      input = `<select name="${f.n}" class="${f.t === 'select2' ? 'js-select2' : ''}" ${isReadOnly ? 'disabled' : ''} style="${IS}"><option value="">-- Pilih --</option>${opts}</select>`;
    } else if (f.t === 'textarea') {
      input = `<textarea name="${f.n}" placeholder="${esc(f.ph || '')}" rows="3" ${isReadOnly ? 'readonly' : ''} style="${IS}resize:vertical;min-height:72px">${esc(val)}</textarea>`;
    } else {
      input = `<input type="${f.t}" name="${f.n}" value="${esc(val)}" placeholder="${esc(f.ph || '')}" ${f.req && !isReadOnly ? 'required' : ''} ${isReadOnly ? 'readonly' : ''} style="${IS}">`;
    }

    formHtml += `<div style="${span}">
      <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">${esc(f.l)}${req}</label>
      ${input}
    </div>`;
  });
  formHtml += '</div>';

  if (menu === 'Data Guru & Staff' && isReadOnly) {
    const teacherId = rowData.teacher_id ?? rowData.id;
    if (teacherId) {
      formHtml += `
        <div style="margin-top:16px;padding:16px;border:1px solid #E5E7EB;border-radius:14px;background:#F9FAFB;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
          <div>
            <div style="font-size:0.8rem;font-weight:800;color:#111827;margin-bottom:4px">Riwayat Pelatihan</div>
            <div style="font-size:0.78rem;color:#6B7280">Klik untuk menambahkan pelatihan baru untuk guru ini.</div>
          </div>
          <button type="button" onclick="openTrainingForTeacher(${esc(teacherId)})" style="padding:8px 14px;border:none;border-radius:10px;background:${info.color};color:white;font-weight:700;cursor:pointer">
            + Tambah Pelatihan
          </button>
        </div>`;
    }
  }

  document.getElementById('modal-body').innerHTML = formHtml;
  initSearchSelectComboboxes();
  document.getElementById('btn-save').style.background = info.color;
  document.getElementById('btn-save').style.display = isReadOnly ? 'none' : '';
  document.getElementById('modal-overlay').style.display = 'flex';
  if (window.jQuery && typeof window.jQuery.fn.select2 === 'function') {
    window.jQuery('#modal-body .js-select2').select2({
      dropdownParent: window.jQuery('#modal-overlay'),
      width: '100%',
    });
  }
}

function renderAttendanceModal(info, fields, rowData, isReadOnly) {
  const classOptions = getFieldOptions(fields, 'class_id');
  const effectiveRowData = withDefaultValue(rowData, 'class_id', classOptions);
  const selectedClassId = String(effectiveRowData.class_id ?? '');
  const filteredFields = applyAttendanceAssignmentFilter(fields, selectedClassId, effectiveRowData);
  const classStudents = getStudentsForClass(selectedClassId);
  const studentRows = buildAttendanceStudents(effectiveRowData.students || [], classStudents);
  const formHtml = `
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px">
      ${renderField(filteredFields, 'attendance_date', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'start_time', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'end_time', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'class_id', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'subject_id', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'teacher_id', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'teacher_attendance_status', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'attendance_taker_type', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'substitute_teacher_id', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'student_officer_id', effectiveRowData, isReadOnly, info)}
      ${renderField(filteredFields, 'meeting_title', effectiveRowData, isReadOnly, info)}
      <div style="grid-column:1/-1">${renderField(filteredFields, 'notes', effectiveRowData, isReadOnly, info, true)}</div>
    </div>
    <div style="border-top:1px solid #E5E7EB;padding-top:16px">
      <div style="font-size:0.78rem;font-weight:700;color:#374151;margin-bottom:10px">Daftar Siswa Kelas</div>
      <div id="attendance-students" style="display:flex;flex-direction:column;gap:10px">
        ${studentRows.map((row, index) => renderAttendanceStudentRow(row, index, isReadOnly)).join('')}
      </div>
    </div>
  `;

  document.getElementById('modal-body').innerHTML = formHtml;
  initSearchSelectComboboxes();
  document.getElementById('btn-save').style.background = info.color;
  document.getElementById('btn-save').style.display = isReadOnly ? 'none' : '';
  document.getElementById('modal-overlay').style.display = 'flex';

  if (!isReadOnly) {
    const classField = document.querySelector('#modal-body [name="class_id"]');
    if (classField) {
      classField.addEventListener('change', refreshAttendanceStudents);
    }
    const payrollTeacherField = document.querySelector('#modal-body [name="teacher_id"]');
    const payrollTeacherDisplayField = document.querySelector('#modal-body [name="teacher_id__display"]');
    if (payrollTeacherField && payrollTeacherDisplayField && S.active?.menu === 'Penggajian') {
      payrollTeacherDisplayField.addEventListener('input', () => {
        syncSearchSelectValue('teacher_id');
        syncPayrollTeacherName();
      });
      payrollTeacherDisplayField.addEventListener('change', () => {
        syncSearchSelectValue('teacher_id');
        syncPayrollTeacherName();
      });
      payrollTeacherField.addEventListener('change', syncPayrollTeacherName);
      syncPayrollTeacherName();
    }
    if (S.active?.menu === 'Penggajian') {
      ['gaji_pokok', 'tunjangan', 'potongan'].forEach(name => {
        const field = document.querySelector(`#modal-body [name="${name}"]`);
        if (field) {
          field.addEventListener('input', () => {
            syncCurrencyField(name);
            syncPayrollTotal();
          });
          field.addEventListener('change', () => {
            syncCurrencyField(name);
            syncPayrollTotal();
          });
        }
      });
      syncPayrollTotal();
    }
    applyDefaultAssignmentSelection(selectedClassId, effectiveRowData);
  }
}

function renderField(fields, name, rowData, isReadOnly, info, forceBlock = false) {
  const field = fields.find(item => item.n === name);
  const val = rowData[name] ?? '';
  const req = field.req ? '<span style="color:#DC2626;margin-left:2px">*</span>' : '';
  let input;

  if (field.t === 'select2') {
    const options = (field.opts && field.opts.length ? field.opts : getSearchSelectOptions(field.n));
    const optionHtml = options.map(option => {
      const optionValue = typeof option === 'object' ? option.value : option;
      const optionLabel = typeof option === 'object' ? (option.label || option.value) : option;
      return `<option value="${esc(optionValue)}"${String(optionValue) === String(val) ? ' selected' : ''}>${esc(optionLabel)}</option>`;
    }).join('');
    input = `
      <select name="${field.n}" class="js-select2" ${isReadOnly ? 'disabled' : ''} style="${IS}">
        <option value="">-- Pilih --</option>
        ${optionHtml}
      </select>
    `;
  } else if (field.t === 'searchselect') {
    const options = getSearchSelectOptions(field.n);
    const menuId = `ss-${S.active?.mod || 'mod'}-${S.active?.menu || 'menu'}-${field.n}`.replace(/[^a-zA-Z0-9_-]/g, '-');
    const optionHtml = options.map(option => {
      const optionValue = typeof option === 'object' ? option.value : option;
      const optionLabel = typeof option === 'object' ? (option.label || option.value) : option;
      return `<button type="button" class="searchselect-option" data-value="${esc(optionValue)}" data-label="${esc(optionLabel)}" style="display:block;width:100%;text-align:left;padding:10px 12px;border:none;background:white;cursor:pointer;font-size:0.82rem;color:#111827">${esc(optionLabel)}</button>`;
    }).join('');
    const helperText = field.n === 'teacher_id'
      ? 'Ketik NIP atau nama pegawai, lalu pilih dari saran.'
      : 'Ketik untuk mencari data.';
    const selectedLabel = getSearchSelectDisplayValue(field.n, val);
    input = `
      <div style="position:relative">
        <input type="hidden" name="${field.n}" value="${esc(val)}">
        <div style="position:relative">
          <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9CA3AF;font-size:0.85rem;pointer-events:none">⌕</span>
          <input type="text" name="${field.n}__display" value="${esc(selectedLabel)}" placeholder="${esc(field.ph || 'Ketik untuk mencari')}" ${isReadOnly ? 'readonly' : ''} data-searchselect-input="${esc(field.n)}" autocomplete="off" style="${IS};padding-left:34px;padding-right:34px;cursor:${isReadOnly ? 'default' : 'text'}">
          <button type="button" tabindex="-1" data-searchselect-toggle="${esc(field.n)}" style="position:absolute;right:6px;top:50%;transform:translateY(-50%);border:none;background:none;color:#9CA3AF;font-size:0.9rem;cursor:pointer;padding:4px 6px">▾</button>
        </div>
        <div data-searchselect-menu="${esc(field.n)}" style="display:none;position:absolute;left:0;right:0;top:calc(100% + 6px);z-index:60;max-height:220px;overflow:auto;border:1px solid #D1D5DB;border-radius:12px;background:#fff;box-shadow:0 12px 24px rgba(15,23,42,.12)">
          ${optionHtml || '<div style="padding:10px 12px;font-size:0.8rem;color:#9CA3AF">Tidak ada data.</div>'}
          <div data-searchselect-empty style="display:none;padding:10px 12px;font-size:0.8rem;color:#9CA3AF;border-top:1px solid #F3F4F6">Tidak ada hasil pencarian.</div>
        </div>
      </div>
      <div style="font-size:0.72rem;color:#6B7280;margin-top:4px">${helperText}</div>
    `;
  } else if (field.t === 'select') {
    const opts = (field.opts || []).map(option => {
      const optionValue = typeof option === 'object' ? option.value : option;
      const optionLabel = typeof option === 'object' ? option.label : option;
      return `<option value="${esc(optionValue)}"${String(optionValue) === String(val) ? ' selected' : ''}>${esc(optionLabel)}</option>`;
    }).join('');
    input = `<select name="${field.n}" ${isReadOnly ? 'disabled' : ''} style="${IS}"><option value="">-- Pilih --</option>${opts}</select>`;
  } else if (field.t === 'currency') {
    input = `<input type="text" inputmode="numeric" name="${field.n}" value="${esc(formatCurrencyInputValue(val))}" ${isReadOnly || field.readonly ? 'readonly' : ''} style="${IS}">`;
  } else if (field.t === 'textarea') {
    input = `<textarea name="${field.n}" rows="3" ${isReadOnly ? 'readonly' : ''} style="${IS}resize:vertical;min-height:72px">${esc(val)}</textarea>`;
  } else {
    const isTeacherNameField = field.n === 'nama_pegawai' && S.active?.menu === 'Penggajian';
    const shouldReadonly = isReadOnly || (isTeacherNameField && Boolean(document.querySelector('#modal-body [name="teacher_id"]')?.value));
    input = `<input type="${field.t}" name="${field.n}" value="${esc(val)}" ${shouldReadonly ? 'readonly' : ''} style="${IS}">`;
  }

  return `<div style="${forceBlock ? '' : ''}">
    <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">${esc(field.l)}${req}</label>
    ${input}
     </div>`;
}

function renderTeacherAttendanceView(state, permissions, info) {
  const teacher = state.meta?.teacher || {};
  const today = state.meta?.today || null;
  const rows = state.rows || [];
  const statusLabel = today ? today.status : 'belum absen';
  const nowLocal = getLocalDateTimeValue();
  const manualForm = today || {
    attendance_date: new Date().toISOString().slice(0, 10),
    status: 'hadir',
    check_in_at: nowLocal,
    check_out_at: nowLocal,
    notes: '',
  };
  const canSaveManual = permissions.create || permissions.update;

  const historyRows = rows.length
    ? rows.map((row, index) => `
        <tr style="border-bottom:1px solid #F3F4F6">
          <td style="${TD}color:#9CA3AF;text-align:center">${index + 1}</td>
          <td style="${TD}">${esc(row.attendance_date || '-')}</td>
          <td style="${TD}">${esc(row.check_in_at || '-')}</td>
          <td style="${TD}">${esc(row.check_out_at || '-')}</td>
          <td style="${TD}">${badge(row.status || 'hadir')}</td>
        </tr>
      `).join('')
    : `<tr><td colspan="5" style="text-align:center;padding:32px;color:#9CA3AF">Belum ada riwayat absensi guru.</td></tr>`;

  document.getElementById('main-content').innerHTML = `
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
      <div style="background:white;border:1px solid #E5E7EB;border-radius:16px;padding:20px">
        <div style="font-size:0.78rem;font-weight:700;color:${info.color};text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px">Absensi Manual Guru</div>
        <div style="font-size:1.2rem;font-weight:800;color:#111827;margin-bottom:6px">${esc(teacher.name || 'Guru')}</div>
        <div style="font-size:0.84rem;color:#6B7280;margin-bottom:12px">${esc(teacher.nip || '-')}</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px">
          <span style="padding:4px 10px;border-radius:999px;background:#EEF2FF;color:#4338CA;font-size:0.75rem;font-weight:700">${esc(statusLabel)}</span>
          <span style="padding:4px 10px;border-radius:999px;background:#ECFDF5;color:#047857;font-size:0.75rem;font-weight:700">${esc(state.meta?.now || '')}</span>
        </div>
        <div style="margin-top:14px">
          <form id="teacher-attendance-manual" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
            <div style="grid-column:1/-1">
              <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">Tanggal</label>
              <input type="date" name="attendance_date" value="${esc(manualForm.attendance_date || '')}" style="${IS}">
            </div>
            <div>
              <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">Status</label>
              <select name="status" style="${IS}">
                ${['hadir', 'izin', 'sakit', 'dinas_luar', 'cuti', 'alpha'].map(status => `<option value="${status}"${status === manualForm.status ? ' selected' : ''}>${status}</option>`).join('')}
              </select>
            </div>
            <div>
              <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">Jam Masuk</label>
              <input type="datetime-local" name="check_in_at" value="${formatDateTimeLocal(manualForm.check_in_at) || nowLocal}" style="${IS}">
            </div>
            <div>
              <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">Jam Pulang</label>
              <input type="datetime-local" name="check_out_at" value="${formatDateTimeLocal(manualForm.check_out_at) || nowLocal}" style="${IS}">
            </div>
            <div style="grid-column:1/-1">
              <label style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:5px">Catatan</label>
              <textarea name="notes" rows="3" style="${IS}resize:vertical;min-height:72px">${esc(manualForm.notes || '')}</textarea>
            </div>
            <div style="grid-column:1/-1;display:flex;gap:10px;align-items:center;flex-wrap:wrap">
              ${canSaveManual ? `<button type="button" onclick="saveTeacherAttendanceManual()" style="padding:10px 16px;border:none;border-radius:10px;background:${info.color};color:white;font-weight:700;cursor:pointer">${today ? 'Update Manual' : 'Simpan Manual'}</button>` : ''}
              <span style="font-size:0.85rem;color:#6B7280">Guru login otomatis dipakai sebagai teacher_id.</span>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div style="background:white;border:1px solid #E5E7EB;border-radius:16px;overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-size:0.855rem">
        <thead>
          <tr style="background:#F9FAFB;border-bottom:1px solid #E5E7EB">
            <th style="${TH}width:50px">No</th>
            <th style="${TH}">Tanggal</th>
            <th style="${TH}">Masuk</th>
            <th style="${TH}">Pulang</th>
            <th style="${TH}">Status</th>
          </tr>
        </thead>
        <tbody>${historyRows}</tbody>
      </table>
    </div>`;
}

function formatDateTimeLocal(value) {
  if (!value) {
    return '';
  }

  const date = new Date(String(value).replace(' ', 'T'));

  if (Number.isNaN(date.getTime())) {
    return '';
  }

  const pad = value => String(value).padStart(2, '0');
  return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
}

function getLocalDateTimeValue(date = new Date()) {
  const pad = value => String(value).padStart(2, '0');
  return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
}

async function saveTeacherAttendanceManual() {
  const { mod, menu } = S.active || {};
  if (menu !== 'Absensi Guru') {
    return;
  }

  const state = getState(mod, menu);
  const form = document.getElementById('teacher-attendance-manual');

  if (!form) {
    return;
  }

  const payload = {
    attendance_date: form.querySelector('[name="attendance_date"]')?.value,
    status: form.querySelector('[name="status"]')?.value,
    check_in_at: form.querySelector('[name="check_in_at"]')?.value,
    check_out_at: form.querySelector('[name="check_out_at"]')?.value,
    notes: form.querySelector('[name="notes"]')?.value || '',
  };

  const endpoint = '/admin/api/teacher-attendances/manual';

  try {
    await requestJson(endpoint, {
      method: 'POST',
      body: JSON.stringify(payload),
    });
    await loadMenuRows(mod, menu, true);
    renderTable();
  } catch (error) {
    alert(error.message);
  }
}

function getFieldOptions(fields, name) {
  return fields.find(item => item.n === name)?.opts || [];
}

function getSearchSelectOptions(fieldName) {
  const meta = getState(S.active.mod, S.active.menu).meta || {};

  if (fieldName === 'teacher_id') {
    return meta.teachers || [];
  }

  if (fieldName === 'nis') {
    return meta.students || [];
  }

  return [];
}

function getSearchSelectDisplayValue(fieldName, value) {
  if (!value) {
    return '';
  }

  const options = getSearchSelectOptions(fieldName);
  const selected = options.find(item => String(item.value) === String(value));
  return selected?.label || String(value);
}

function initSearchSelectComboboxes() {
  const inputs = document.querySelectorAll('#modal-body [data-searchselect-input]');

  inputs.forEach(input => {
    const fieldName = input.dataset.searchselectInput;
    const menu = document.querySelector(`#modal-body [data-searchselect-menu="${fieldName}"]`);
    const hiddenField = document.querySelector(`#modal-body [name="${fieldName}"]`);
    const toggle = document.querySelector(`#modal-body [data-searchselect-toggle="${fieldName}"]`);

    if (!menu || !hiddenField) {
      return;
    }

    const openMenu = () => {
      menu.style.display = 'block';
      filterMenu();
    };

    const closeMenu = () => {
      menu.style.display = 'none';
    };

    const filterMenu = () => {
      const query = String(input.value || '').trim().toLowerCase();
      let visibleCount = 0;

      menu.querySelectorAll('.searchselect-option').forEach(option => {
        const label = String(option.dataset.label || option.textContent || '').toLowerCase();
        const match = !query || label.includes(query);
        option.style.display = match ? 'block' : 'none';
        if (match) {
          visibleCount += 1;
        }
      });

      const empty = menu.querySelector('[data-searchselect-empty]');
      if (empty) {
        empty.style.display = visibleCount ? 'none' : 'block';
      }
    };

    input.addEventListener('focus', openMenu);
    input.addEventListener('click', openMenu);
    input.addEventListener('input', () => {
      hiddenField.value = '';
      filterMenu();
      if (fieldName === 'teacher_id') {
        syncPayrollTeacherName();
      }
    });
    input.addEventListener('keydown', event => {
      if (event.key === 'Escape') {
        closeMenu();
      }
    });

    if (toggle) {
      toggle.addEventListener('click', event => {
        event.preventDefault();
        event.stopPropagation();
        if (menu.style.display === 'block') {
          closeMenu();
        } else {
          openMenu();
          input.focus();
        }
      });
    }

    menu.querySelectorAll('.searchselect-option').forEach(option => {
      option.addEventListener('click', () => {
        hiddenField.value = String(option.dataset.value || '');
        input.value = String(option.dataset.label || option.textContent || '');
        closeMenu();
        if (fieldName === 'teacher_id') {
          syncPayrollTeacherName();
        }
      });
    });

    filterMenu();
  });

  if (!window.__searchSelectGlobalBound) {
    document.addEventListener('click', event => {
      const target = event.target;
      if (target.closest && target.closest('[data-searchselect-input]')) {
        return;
      }
      document.querySelectorAll('#modal-body [data-searchselect-menu]').forEach(menu => {
        menu.style.display = 'none';
      });
    });
    window.__searchSelectGlobalBound = true;
  }
}

function syncSearchSelectValue(fieldName) {
  const displayField = document.querySelector(`#modal-body [data-searchselect-input="${fieldName}"]`);
  const hiddenField = document.querySelector(`#modal-body [name="${fieldName}"]`);

  if (!displayField || !hiddenField) {
    return;
  }

  const options = getSearchSelectOptions(fieldName);
  const current = String(displayField.value || '').trim().toLowerCase();
  const exact = options.find(item => String(item.label || '').trim().toLowerCase() === current);
  const partial = exact || options.find(item => String(item.label || '').toLowerCase().includes(current));

  if (partial) {
    hiddenField.value = String(partial.value);
    displayField.value = partial.label;
  } else if (!current) {
    hiddenField.value = '';
  }
}

function syncPayrollTeacherName() {
  if (!S.active || S.active.menu !== 'Penggajian') {
    return;
  }

  const teacherField = document.querySelector('#modal-body [name="teacher_id"]');
  const teacherDisplayField = document.querySelector('#modal-body [data-searchselect-input="teacher_id"]');
  if (!teacherField) {
    return;
  }

  const selected = getSearchSelectOptions('teacher_id').find(item => String(item.value) === String(teacherField.value));
  if (selected && teacherDisplayField) {
    teacherDisplayField.value = selected.label;
    teacherField.value = String(selected.value);
  }
}

function syncPayrollTotal() {
  if (!S.active || S.active.menu !== 'Penggajian') {
    return;
  }

  const gajiPokok = parseCurrencyInputValue(document.querySelector('#modal-body [name="gaji_pokok"]')?.value);
  const tunjangan = parseCurrencyInputValue(document.querySelector('#modal-body [name="tunjangan"]')?.value);
  const potongan = parseCurrencyInputValue(document.querySelector('#modal-body [name="potongan"]')?.value);
  const totalField = document.querySelector('#modal-body [name="total_gaji"]');

  if (!totalField) {
    return;
  }

  totalField.value = formatCurrencyRupiah(Math.max(0, gajiPokok + tunjangan - potongan));
}

function parseCurrencyInputValue(value) {
  return Number(String(value || '').replace(/[^\d-]/g, '')) || 0;
}

function formatCurrencyInputValue(value) {
  const number = parseCurrencyInputValue(value);
  return number ? `Rp ${String(number).replace(/\B(?=(\d{3})+(?!\d))/g, '.')}` : '';
}

function formatCurrencyRupiah(value) {
  return formatCurrencyInputValue(value) || 'Rp 0';
}

function syncCurrencyField(fieldName) {
  const field = document.querySelector(`#modal-body [name="${fieldName}"]`);
  if (!field) {
    return;
  }

  const digits = parseCurrencyInputValue(field.value);
  field.value = digits ? formatCurrencyInputValue(digits) : '';
}

function getStudentsForClass(classId) {
  const classes = getState(S.active.mod, S.active.menu).meta.classes || [];
  return classes.find(item => String(item.id) === String(classId))?.students || [];
}

function getAssignmentsForClass(classId) {
  return (getState(S.active.mod, S.active.menu).meta.assignments || []).filter(item => String(item.class_id) === String(classId));
}

function applyAttendanceAssignmentFilter(fields, classId, rowData) {
  const assignments = getAssignmentsForClass(classId);
  const subjectOptions = assignments.map(item => ({ value: String(item.subject_id), label: item.subject_name }));
  const teacherOptions = assignments.map(item => ({ value: String(item.teacher_id), label: item.teacher_name }));
  const uniqueSubjectOptions = dedupeOptions(subjectOptions);
  const uniqueTeacherOptions = dedupeOptions(teacherOptions);

  return fields.map(field => {
    if (field.n === 'subject_id') {
      return { ...field, opts: uniqueSubjectOptions };
    }
    if (field.n === 'teacher_id' || field.n === 'substitute_teacher_id') {
      return { ...field, opts: uniqueTeacherOptions };
    }
    return field;
  });
}

function dedupeOptions(options) {
  const seen = new Set();
  return options.filter(option => {
    if (seen.has(option.value)) {
      return false;
    }
    seen.add(option.value);
    return true;
  });
}

function buildAttendanceStudents(existingRows, classStudents) {
  if (!classStudents.length) {
    return [];
  }

  return classStudents.map(student => {
    const existing = existingRows.find(item => String(item.student_id) === String(student.id));
    return {
      student_id: student.id,
      student_name: student.name,
      status: existing?.status || 'hadir',
      is_late: existing?.is_late || false,
      late_minutes: existing?.late_minutes || 0,
      notes: existing?.notes || '',
    };
  });
}

function renderAttendanceStudentRow(row, index, isReadOnly) {
  return `<div class="attendance-row" style="display:grid;grid-template-columns:1.3fr 1fr 0.8fr 1fr 1.5fr;gap:10px;align-items:center;border:1px solid #E5E7EB;border-radius:12px;padding:12px">
    <div>
      <div style="font-size:0.82rem;font-weight:700;color:#111827">${esc(row.student_name)}</div>
      <input type="hidden" name="student_id_${index}" value="${esc(row.student_id)}">
    </div>
    <select name="student_status_${index}" ${isReadOnly ? 'disabled' : ''} style="${IS}">
      ${['hadir', 'sakit', 'izin', 'bolos', 'terlambat'].map(status => `<option value="${status}"${status === row.status ? ' selected' : ''}>${status}</option>`).join('')}
    </select>
    <label style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:#6B7280">
      <input type="checkbox" name="student_late_${index}" ${row.is_late ? 'checked' : ''} ${isReadOnly ? 'disabled' : ''}>
      Terlambat
    </label>
    <input type="number" min="0" max="300" name="student_late_minutes_${index}" value="${esc(row.late_minutes)}" ${isReadOnly ? 'readonly' : ''} style="${IS}">
    <input type="text" name="student_notes_${index}" value="${esc(row.notes)}" ${isReadOnly ? 'readonly' : ''} placeholder="Catatan siswa" style="${IS}">
  </div>`;
}

function refreshAttendanceStudents() {
  const classId = document.querySelector('#modal-body [name="class_id"]')?.value || '';
  const classStudents = getStudentsForClass(classId);
  const rows = buildAttendanceStudents([], classStudents);
  document.getElementById('attendance-students').innerHTML = rows.map((row, index) => renderAttendanceStudentRow(row, index, false)).join('');

  const fields = getState(S.active.mod, S.active.menu).fields;
  const filteredFields = applyAttendanceAssignmentFilter(fields, classId, {});
  ['subject_id', 'teacher_id', 'substitute_teacher_id'].forEach(name => {
    const target = document.querySelector(`#modal-body [name="${name}"]`);
    const field = filteredFields.find(item => item.n === name);
    if (!target || !field) {
      return;
    }
    const options = (field.opts || []).map(option => {
      const optionValue = typeof option === 'object' ? option.value : option;
      const optionLabel = typeof option === 'object' ? option.label : option;
      return `<option value="${esc(optionValue)}">${esc(optionLabel)}</option>`;
    }).join('');
    target.innerHTML = `<option value="">-- Pilih --</option>${options}`;
  });
  if (window.jQuery && typeof window.jQuery.fn.select2 === 'function') {
    window.jQuery('#modal-body .js-select2').trigger('change.select2');
  }
  applyDefaultAssignmentSelection(classId, {});
}

function closeModal() {
  document.getElementById('modal-overlay').style.display = 'none';
  document.getElementById('btn-save').style.display = '';
  S.modal = null;
}

async function saveModal() {
  if (!S.modal || S.modal.type === 'detail') {
    return;
  }

  const isEdit = S.modal.type === 'edit';
  if (isEdit && !can('update')) {
    alert('Role ini tidak memiliki izin update.');
    return;
  }
  if (!isEdit && !can('create')) {
    alert('Role ini tidak memiliki izin create.');
    return;
  }

  const { mod, menu } = S.active;
  const state = getState(mod, menu);
  const config = getResourceConfig(mod, menu);
  const payload = {};

  if (menu === 'Penggajian') {
    syncPayrollTeacherName();
    ['gaji_pokok', 'tunjangan', 'potongan', 'total_gaji'].forEach(syncCurrencyField);
  }

  if (menu === 'Absensi Siswa') {
    state.fields.forEach(f => {
      const el = document.querySelector(`#modal-body [name="${f.n}"]`);
      if (!el) {
        return;
      }
      payload[f.n] = el.value;
    });
    payload.students = collectAttendanceStudents();
  } else if (menu === 'Pelatihan Guru') {
    [
      'teacher_id',
      'nama_pelatihan',
      'deskripsi',
      'penyelenggara',
      'tanggal_mulai',
      'tanggal_selesai',
      'durasi_jam',
      'lokasi',
      'sertifikat_url',
      'keterangan',
    ].forEach(name => {
      const el = document.querySelector(`#modal-body [name="${name}"]`);
      if (!el) {
        return;
      }

      payload[name] = el.type === 'checkbox' ? el.checked : el.value;
    });
  } else {
    state.fields.forEach(f => {
      const el = document.querySelector(`#modal-body [name="${f.n}"]`);
      if (!el) {
        return;
      }
      payload[f.n] = f.t === 'boolean' ? el.checked : el.value;
    });
  }

  try {
    const endpoint = isEdit ? `${config.endpoint}/${S.modal.row.id}` : config.endpoint;
    const method = isEdit ? 'PUT' : 'POST';
    await requestJson(endpoint, {
      method,
      body: JSON.stringify((config.rowToApi || (row => row))(payload)),
    });
    closeModal();
    await loadMenuRows(mod, menu, true);
    renderTable();
  } catch (error) {
    alert(error.message);
  }
}

function collectAttendanceStudents() {
  const rows = Array.from(document.querySelectorAll('#attendance-students .attendance-row'));
  return rows.map((row, index) => ({
    student_id: parseInt(row.querySelector(`[name="student_id_${index}"]`).value, 10),
    status: row.querySelector(`[name="student_status_${index}"]`).value,
    is_late: row.querySelector(`[name="student_late_${index}"]`).checked,
    late_minutes: parseInt(row.querySelector(`[name="student_late_minutes_${index}"]`).value || '0', 10),
    notes: row.querySelector(`[name="student_notes_${index}"]`).value || '',
  }));
}

function renderAttendanceSummary(summary) {
  const parts = [
    ['hadir', '#16A34A'],
    ['sakit', '#2563EB'],
    ['izin', '#D97706'],
    ['bolos', '#DC2626'],
    ['terlambat', '#7C3AED'],
  ];

  return `<div style="display:flex;gap:6px;flex-wrap:wrap">${
    parts.map(([key, color]) => `<span style="padding:3px 8px;border-radius:999px;background:${color}15;color:${color};font-size:0.7rem;font-weight:700">${key}: ${summary[key] || 0}</span>`).join('')
  }</div>`;
}

function applyDefaultAssignmentSelection(classId, rowData) {
  const assignments = getAssignmentsForClass(classId);
  const classField = document.querySelector('#modal-body [name="class_id"]');

  if (classField && !rowData.class_id && classId) {
    classField.value = String(classId);
  }

  if (!assignments.length) {
    return;
  }

  const defaultAssignment = assignments[0];
  const teacherField = document.querySelector('#modal-body [name="teacher_id"]');
  const subjectField = document.querySelector('#modal-body [name="subject_id"]');

  if (teacherField && !rowData.teacher_id) {
    teacherField.value = String(defaultAssignment.teacher_id);
  }
  if (subjectField && !rowData.subject_id) {
    subjectField.value = String(defaultAssignment.subject_id);
  }
}

async function deleteRow(id) {
  if (!can('delete')) {
    alert('Role ini tidak memiliki izin delete.');
    return;
  }

  if (!confirm('Hapus data ini?')) {
    return;
  }

  const { mod, menu } = S.active;
  const config = getResourceConfig(mod, menu);

  try {
    await requestJson(`${config.endpoint}/${id}`, { method: 'DELETE' });
    await loadMenuRows(mod, menu, true);
    renderTable();
  } catch (error) {
    alert(error.message);
  }
}

function doSearch() {
  S.search = document.getElementById('search').value;
  S.page = 1;
  if (S.active) {
    renderTable();
  }
}

function changePage(delta) {
  if (!S.active) {
    return;
  }

  const state = getState(S.active.mod, S.active.menu);
  const normalizedSearch = String(S.search || '').toLowerCase();
  const rows = normalizedSearch
    ? state.rows.filter(r => Object.values(r).some(v => String(v ?? '').toLowerCase().includes(normalizedSearch)))
    : state.rows;
  const totalPages = Math.max(1, Math.ceil(rows.length / S.perPage));
  const nextPage = Math.min(totalPages, Math.max(1, S.page + delta));

  if (nextPage === S.page) {
    return;
  }

  S.page = nextPage;
  renderTable();
}

async function requestJson(url, options = {}) {
  const csrfToken = getCsrfToken();
  const response = await fetch(url, {
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': csrfToken,
      'X-XSRF-TOKEN': csrfToken,
    },
    credentials: 'include',
    ...options,
  });

  let payload = {};
  try {
    payload = await response.json();
  } catch (error) {
    payload = {};
  }

  if (!response.ok) {
    const message = payload.message || payload.error || 'Request gagal diproses.';
    throw new Error(message);
  }

  return payload;
}

function getCsrfToken() {
  const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  if (metaToken) {
    return metaToken;
  }

  const cookieMatch = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
  if (!cookieMatch) {
    return '';
  }

  try {
    return decodeURIComponent(cookieMatch[1]);
  } catch (error) {
    return cookieMatch[1];
  }
}
