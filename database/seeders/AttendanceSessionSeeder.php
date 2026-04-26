<?php

namespace Database\Seeders;

use App\Models\AttendanceSession;
use App\Models\AttendanceSessionStudent;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSessionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@smamaarifkroya.sch.id')->first();
        $primaryGuruUser = User::query()->where('email', 'guru@smamaarifkroya.sch.id')->first();
        $legacyGuruUser = User::query()
            ->where('email', 'guruabsensi@smamaarifkroya.sch.id')
            ->orWhere('nip_nis', '198812312020011001')
            ->first();

        if ($primaryGuruUser && $legacyGuruUser && $primaryGuruUser->id !== $legacyGuruUser->id) {
            Teacher::query()
                ->where('user_id', $legacyGuruUser->id)
                ->update(['user_id' => $primaryGuruUser->id]);

            AttendanceSession::query()
                ->where('recorded_by_user_id', $legacyGuruUser->id)
                ->update(['recorded_by_user_id' => $primaryGuruUser->id]);

            $legacyGuruUser->update([
                'email' => 'legacy-guru-' . $legacyGuruUser->id . '@local.invalid',
                'nip_nis' => 'LEGACY-GURU-' . $legacyGuruUser->id,
                'is_active' => false,
            ]);
        }

        $teacherUser = User::query()->updateOrCreate(
            ['email' => 'guru@smamaarifkroya.sch.id'],
            [
                'name' => 'Ahmad Fauzan',
                'password' => 'password123',
                'role' => 'guru',
                'nip_nis' => '198812312020011001',
                'phone' => '081200000001',
                'is_active' => true,
            ]
        );
        $teacherUser->syncRoles(['guru']);
        $substituteUser = User::query()->updateOrCreate(
            ['email' => 'gurupengganti@smamaarifkroya.sch.id'],
            [
                'name' => 'Siti Mariani',
                'password' => 'password123',
                'role' => 'guru',
                'nip_nis' => '198901012021011002',
                'phone' => '081200000002',
                'is_active' => true,
            ]
        );
        $substituteUser->syncRoles(['guru']);
        $studentUser = User::query()->updateOrCreate(
            ['email' => 'ketuakelas@smamaarifkroya.sch.id'],
            [
                'name' => 'Ketua Kelas X-A',
                'password' => 'password123',
                'role' => 'siswa',
                'nip_nis' => 'S-ATT-001',
                'phone' => '081200000003',
                'is_active' => true,
            ]
        );
        $studentUser->syncRoles(['siswa']);

        $teacher = Teacher::query()->updateOrCreate(
            ['nip' => '198812312020011001'],
            [
                'user_id' => $teacherUser->id,
                'gender' => 'L',
                'tempat_lahir' => 'Kroya',
                'tanggal_lahir' => '1988-12-31',
                'alamat' => 'Kroya',
                'phone' => $teacherUser->phone ?? '081200000001',
                'pendidikan_terakhir' => 'S1',
                'mata_pelajaran' => 'Matematika',
                'status_kepegawaian' => 'GTY',
                'tmt' => '2020-01-01',
            ]
        );
        $teacher->update([
            'user_id' => $teacherUser->id,
            'name' => $teacherUser->name,
        ]);

        $substituteTeacher = Teacher::query()->updateOrCreate(
            ['nip' => '198901012021011002'],
            [
                'user_id' => $substituteUser->id,
                'gender' => 'P',
                'tempat_lahir' => 'Cilacap',
                'tanggal_lahir' => '1989-01-01',
                'alamat' => 'Cilacap',
                'phone' => $substituteUser->phone ?? '081200000002',
                'pendidikan_terakhir' => 'S1',
                'mata_pelajaran' => 'Matematika',
                'status_kepegawaian' => 'GTT',
                'tmt' => '2021-01-01',
            ]
        );
        $substituteTeacher->update([
            'user_id' => $substituteUser->id,
            'name' => $substituteUser->name,
        ]);

        $class = SchoolClass::query()->firstOrCreate(
            ['name' => 'X-A'],
            [
                'tingkat' => 10,
                'jurusan' => 'IPA',
                'wali_kelas_id' => $teacher->id,
                'kapasitas' => 36,
                'ruang_kelas' => 'R-101',
                'tahun_ajaran' => '2026/2027',
            ]
        );

        $classXB = SchoolClass::query()->firstOrCreate(
            ['name' => 'X-B'],
            [
                'tingkat' => 10,
                'jurusan' => 'IPA',
                'wali_kelas_id' => $substituteTeacher->id,
                'kapasitas' => 36,
                'ruang_kelas' => 'R-102',
                'tahun_ajaran' => '2026/2027',
            ]
        );

        $classXIA = SchoolClass::query()->firstOrCreate(
            ['name' => 'XI-A'],
            [
                'tingkat' => 11,
                'jurusan' => 'IPS',
                'wali_kelas_id' => $teacher->id,
                'kapasitas' => 34,
                'ruang_kelas' => 'R-201',
                'tahun_ajaran' => '2026/2027',
            ]
        );

        $subject = Subject::query()->firstOrCreate(
            ['kode' => 'MTK-10'],
            [
                'nama' => 'Matematika',
                'kelompok' => 'A',
                'kkm' => 75,
            ]
        );

        $studentOfficer = Student::query()->firstOrCreate(
            ['nis' => 'ATT-001'],
            [
                'user_id' => $studentUser->id,
                'nisn' => '9988776655',
                'name' => $studentUser->name,
                'gender' => 'L',
                'tempat_lahir' => 'Kroya',
                'tanggal_lahir' => '2009-01-01',
                'alamat' => 'Kroya',
                'phone' => $studentUser->phone,
                'class_id' => $class->id,
                'status' => 'aktif',
            ]
        );

        $students = collect([
            $studentOfficer,
            Student::query()->firstOrCreate(
                ['nis' => 'ATT-002'],
                [
                    'user_id' => $studentUser->id,
                    'nisn' => '9988776656',
                    'name' => 'Siswa Hadir',
                    'gender' => 'P',
                    'tempat_lahir' => 'Kroya',
                    'tanggal_lahir' => '2009-02-01',
                    'alamat' => 'Kroya',
                    'phone' => '081200000004',
                    'class_id' => $class->id,
                    'status' => 'aktif',
                ]
            ),
            Student::query()->firstOrCreate(
                ['nis' => 'ATT-003'],
                [
                    'user_id' => $studentUser->id,
                    'nisn' => '9988776657',
                    'name' => 'Siswa Izin',
                    'gender' => 'L',
                    'tempat_lahir' => 'Kroya',
                    'tanggal_lahir' => '2009-03-01',
                    'alamat' => 'Kroya',
                    'phone' => '081200000005',
                    'class_id' => $class->id,
                    'status' => 'aktif',
                ]
            ),
        ]);

        collect([
            [
                'email' => 'rina.xb@smamaarifkroya.sch.id',
                'nis' => 'X-B-001',
                'nisn' => '9988777701',
                'name' => 'Rina Kelas X-B',
                'gender' => 'P',
                'tempat_lahir' => 'Kroya',
                'tanggal_lahir' => '2009-04-05',
                'alamat' => 'Kroya',
                'phone' => '081200000006',
                'class_id' => $classXB->id,
            ],
            [
                'email' => 'deni.xb@smamaarifkroya.sch.id',
                'nis' => 'X-B-002',
                'nisn' => '9988777702',
                'name' => 'Deni Kelas X-B',
                'gender' => 'L',
                'tempat_lahir' => 'Cilacap',
                'tanggal_lahir' => '2009-05-12',
                'alamat' => 'Cilacap',
                'phone' => '081200000007',
                'class_id' => $classXB->id,
            ],
            [
                'email' => 'nadia.xia@smamaarifkroya.sch.id',
                'nis' => 'XI-A-001',
                'nisn' => '9988778801',
                'name' => 'Nadia XI-A',
                'gender' => 'P',
                'tempat_lahir' => 'Kroya',
                'tanggal_lahir' => '2008-08-17',
                'alamat' => 'Kroya',
                'phone' => '081200000008',
                'class_id' => $classXIA->id,
            ],
            [
                'email' => 'fajar.xia@smamaarifkroya.sch.id',
                'nis' => 'XI-A-002',
                'nisn' => '9988778802',
                'name' => 'Fajar XI-A',
                'gender' => 'L',
                'tempat_lahir' => 'Banyumas',
                'tanggal_lahir' => '2008-09-22',
                'alamat' => 'Banyumas',
                'phone' => '081200000009',
                'class_id' => $classXIA->id,
            ],
        ])->each(function (array $student): void {
            $studentUser = User::query()->updateOrCreate(
                ['email' => $student['email']],
                [
                    'name' => $student['name'],
                    'password' => 'password123',
                    'role' => 'siswa',
                    'nip_nis' => $student['nis'],
                    'phone' => $student['phone'],
                    'is_active' => true,
                ]
            );
            $studentUser->syncRoles(['siswa']);

            Student::query()->firstOrCreate(
                ['nis' => $student['nis']],
                [
                    'user_id' => $studentUser->id,
                    'nisn' => $student['nisn'],
                    'name' => $student['name'],
                    'gender' => $student['gender'],
                    'tempat_lahir' => $student['tempat_lahir'],
                    'tanggal_lahir' => $student['tanggal_lahir'],
                    'alamat' => $student['alamat'],
                    'phone' => $student['phone'],
                    'class_id' => $student['class_id'],
                    'status' => 'aktif',
                ]
            );
        });

        $session = AttendanceSession::query()->updateOrCreate(
            [
                'class_id' => $class->id,
                'subject_id' => $subject->id,
                'teacher_id' => $teacher->id,
                'attendance_date' => '2026-04-25',
                'start_time' => '07:00:00',
            ],
            [
                'substitute_teacher_id' => $substituteTeacher->id,
                'student_officer_id' => $studentOfficer->id,
                'recorded_by_user_id' => $admin?->id ?? $teacherUser->id,
                'attendance_taker_type' => 'substitute_teacher',
                'teacher_attendance_status' => 'izin',
                'end_time' => '08:30:00',
                'meeting_title' => 'Matematika Bab Persamaan Linear',
                'notes' => 'Guru pengampu berhalangan hadir, absensi diambil oleh guru pengganti.',
            ]
        );

        foreach ($students as $index => $student) {
            AttendanceSessionStudent::query()->updateOrCreate(
                [
                    'attendance_session_id' => $session->id,
                    'student_id' => $student->id,
                ],
                [
                    'status' => match ($index) {
                        1 => 'hadir',
                        2 => 'izin',
                        default => 'terlambat',
                    },
                    'is_late' => $index === 0,
                    'late_minutes' => $index === 0 ? 12 : 0,
                    'notes' => $index === 2 ? 'Izin sakit dari orang tua.' : null,
                ]
            );
        }
    }
}
