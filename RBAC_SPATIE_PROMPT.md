# RBAC Menu, Role, User, Permission - Laravel 12 + Spatie

## Tujuan

Bangun sistem RBAC di Laravel 12 menggunakan Spatie Permission dengan alur:

`Menu -> Permission -> Role -> User -> Akses`

Konsep utamanya:

1. User membuat **menu** terlebih dahulu, misalnya `Guru`, `Murid`, `Pegawai`.
2. Saat membuat menu, user mengisi:
   - `nama menu`
   - `url`
   - `permission`
3. Di form menu, harus ada permission default utama yang **wajib tersedia**:
   - `create`
   - `update`
   - `delete`
   - `list`
   - `detail`
4. Semua permission default itu muncul dalam bentuk checklist, dan bisa di-`select all`.
5. Selain permission default, user bisa menambah permission custom dengan tombol `Tambah`.
6. Saat klik `Tambah`, muncul input:
   - nama permission
   - checklist permission
7. Setelah disimpan, sistem membuat daftar permission untuk menu tersebut.
8. Lalu saat membuat **role**, menu yang sudah dibuat akan muncul.
9. Saat memilih menu, permission checklist yang muncul hanya yang terkait menu itu.
10. Setelah role disimpan, user bisa dibuat dan dipetakan ke role.
11. Saat user login, akses menu dan tindakan mengikuti permission dari role tersebut.

## Scope Teknologi

- Laravel 12
- Spatie Laravel Permission
- Blade / Laravel backend
- MySQL

## Struktur Konsep

### 1. Menu

Menu adalah entitas utama yang menampung modul aplikasi.

Contoh:
- `Guru`
- `Murid`
- `Pegawai`
- `Keuangan`

Field menu yang dibutuhkan:
- `name`
- `slug`
- `url`
- `description` optional
- `icon` optional
- `order` optional
- `is_active`

### 2. Permission

Permission harus dibagi menjadi:

#### Default Permission Wajib
- `create`
- `update`
- `delete`
- `list`
- `detail`

#### Custom Permission Tambahan
Contoh:
- `export`
- `import`
- `approve`
- `reject`
- `print`
- `upload`

Custom permission dibuat dari tombol `Tambah`.

### 3. Role

Role dibangun dari menu dan permission yang sudah tersedia.

Contoh:
- `Admin`
- `Guru BK`
- `Wali Kelas`
- `Keuangan`
- `Operator`

Saat membuat role:
- pilih menu
- pilih permission yang diizinkan untuk role itu
- simpan

### 4. User

User dipetakan ke role.

Contoh:
- user `budi@sekolah.test` -> role `Guru BK`
- user `siti@sekolah.test` -> role `Keuangan`

Saat login:
- user hanya melihat menu yang diizinkan
- user hanya bisa akses action yang sesuai permission

## Alur UI yang Diinginkan

### A. Form Menu

Form menu harus memiliki:

- Nama menu
- URL
- Deskripsi
- Icon
- Checkbox permission default:
  - create
  - update
  - delete
  - list
  - detail
- Tombol `Select All`
- Tombol `Tambah Permission`

Saat `Tambah Permission` diklik:
- tampilkan field `nama permission`
- tampilkan checkbox permission action
- simpan sebagai permission tambahan untuk menu tersebut

### B. Form Role

Form role harus memiliki:

- Nama role
- Deskripsi
- Pilih menu yang tersedia
- Setelah menu dipilih, tampilkan permission yang terkait
- Ceklist permission yang ingin diberikan
- Simpan role

### C. Form User

Form user harus memiliki:

- Nama
- Email
- Password
- Role
- Status aktif

Saat role dipilih:
- otomatis user mendapatkan akses sesuai role

## Aturan Permission

1. Permission default wajib tersedia untuk setiap menu.
2. Permission custom boleh ditambah sesuai kebutuhan.
3. Permission harus disimpan unik per menu.
4. Role hanya dapat memilih permission yang sudah terdaftar pada menu.
5. User mewarisi permission dari role.
6. Jika role tidak memiliki permission, user juga tidak bisa mengaksesnya.

## Database Design yang Disarankan

### menus
- id
- name
- slug
- url
- description
- icon
- order
- is_active
- timestamps

### permissions
Gunakan tabel Spatie Permission default:
- id
- name
- guard_name
- timestamps

### roles
Gunakan tabel Spatie Role default:
- id
- name
- guard_name
- timestamps

### model_has_roles
### model_has_permissions
### role_has_permissions

### menu_permissions / pivot table khusus

Butuh tabel relasi untuk menu ke permission, misalnya:
- `menu_permissions`

Field:
- `menu_id`
- `permission_id`
- `type` optional, jika perlu membedakan default/custom
- timestamps optional

## Output Yang Diinginkan

### Backend
- Migration untuk menus
- Migration / setup permission custom
- Model relasi yang rapi
- Controller CRUD
- Form request validation
- Seeder untuk default role dan permission

### Frontend
- Form create menu
- Form create role
- Form create user
- Checkbox default permission
- Checkbox custom permission
- Button select all
- Dynamic add permission row

### Auth
- Login user berdasarkan role
- Middleware pembatasan akses
- Tampilkan menu sesuai permission

## Acceptance Criteria

- Menu bisa dibuat dengan URL dan permission
- Default permission selalu muncul dan bisa di-select all
- Custom permission bisa ditambah dari tombol `Tambah`
- Role bisa dipilih berdasarkan menu yang ada
- Role hanya menerima permission yang dicentang
- User yang login hanya melihat menu yang diizinkan
- Akses create/update/delete/list/detail berjalan sesuai role
- Implementasi memakai Spatie Permission

## Catatan Implementasi

- Gunakan Laravel 12
- Ikuti konvensi Spatie Permission
- Permission harus bisa di-generate dari UI
- Jangan hardcode permission di blade jika bisa disimpan ke database
- Menu dan permission harus bisa berkembang tanpa ubah banyak kode

## Prompt Singkat untuk Eksekusi

> Buat sistem RBAC di Laravel 12 dengan Spatie Permission. Alurnya dimulai dari menu, lalu permission default wajib create/update/delete/list/detail plus permission custom, lalu role memilih menu dan permission, lalu user dipetakan ke role. User yang login hanya bisa melihat menu dan aksi sesuai permission role. Buat migration, model, controller, form Blade, middleware, dan seeder yang dibutuhkan.

