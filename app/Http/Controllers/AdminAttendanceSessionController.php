<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\AttendanceSessionStudent;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminAttendanceSessionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AttendanceSession::query()
            ->with(['class', 'subject', 'teacher', 'substituteTeacher', 'studentOfficer', 'attendanceItems'])
            ->orderByDesc('attendance_date')
            ->orderByDesc('start_time');

        if ($teacherId = $this->teacherIdForUser($request)) {
            $query->where(function ($builder) use ($teacherId): void {
                $builder
                    ->where('teacher_id', $teacherId)
                    ->orWhere('substitute_teacher_id', $teacherId);
            });
        }

        $sessions = $query
            ->get()
            ->map(function (AttendanceSession $session): array {
                return [
                    'id' => $session->id,
                    'class_id' => $session->class_id,
                    'subject_id' => $session->subject_id,
                    'teacher_id' => $session->teacher_id,
                    'substitute_teacher_id' => $session->substitute_teacher_id,
                    'student_officer_id' => $session->student_officer_id,
                    'attendance_taker_type' => $session->attendance_taker_type,
                    'teacher_attendance_status' => $session->teacher_attendance_status,
                    'attendance_date' => optional($session->attendance_date)->format('Y-m-d'),
                    'start_time' => $session->start_time,
                    'end_time' => $session->end_time,
                    'meeting_title' => $session->meeting_title,
                    'notes' => $session->notes,
                    'class_name' => $session->class?->name,
                    'subject_name' => $session->subject?->nama,
                    'teacher_name' => $session->teacher?->name,
                    'substitute_teacher_name' => $session->substituteTeacher?->name,
                    'student_officer_name' => $session->studentOfficer?->name,
                    'summary' => [
                        'hadir' => $session->attendanceItems->where('status', 'hadir')->count(),
                        'sakit' => $session->attendanceItems->where('status', 'sakit')->count(),
                        'izin' => $session->attendanceItems->where('status', 'izin')->count(),
                        'bolos' => $session->attendanceItems->where('status', 'bolos')->count(),
                        'terlambat' => $session->attendanceItems->where('status', 'terlambat')->count(),
                    ],
                    'students' => $session->attendanceItems
                        ->map(fn (AttendanceSessionStudent $item): array => [
                            'student_id' => $item->student_id,
                            'student_name' => $item->student?->name,
                            'status' => $item->status,
                            'is_late' => $item->is_late,
                            'late_minutes' => $item->late_minutes,
                            'notes' => $item->notes,
                        ])
                        ->values()
                        ->all(),
                ];
            });

        return response()->json([
            'data' => $sessions,
            'meta' => $this->meta($request),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->validated($request);
        $this->scopePayloadForTeacher($request, $payload);

        $session = DB::transaction(function () use ($request, $payload): AttendanceSession {
            $session = AttendanceSession::create([
                'class_id' => $payload['class_id'],
                'subject_id' => $payload['subject_id'],
                'teacher_id' => $payload['teacher_id'],
                'substitute_teacher_id' => $payload['substitute_teacher_id'] ?? null,
                'student_officer_id' => $payload['student_officer_id'] ?? null,
                'recorded_by_user_id' => $request->user()?->id,
                'attendance_taker_type' => $payload['attendance_taker_type'],
                'teacher_attendance_status' => $payload['teacher_attendance_status'],
                'attendance_date' => $payload['attendance_date'],
                'start_time' => $payload['start_time'] ?? null,
                'end_time' => $payload['end_time'] ?? null,
                'meeting_title' => $payload['meeting_title'] ?? null,
                'notes' => $payload['notes'] ?? null,
            ]);

            $this->syncStudents($session, $payload['students']);

            return $session;
        });

        return response()->json([
            'message' => 'Sesi absensi berhasil dibuat.',
            'data' => ['id' => $session->id],
        ], 201);
    }

    public function update(Request $request, AttendanceSession $attendanceSession): JsonResponse
    {
        $this->authorizeOwnership($request, $attendanceSession);

        $payload = $this->validated($request);
        $this->scopePayloadForTeacher($request, $payload);

        DB::transaction(function () use ($request, $payload, $attendanceSession): void {
            $attendanceSession->update([
                'class_id' => $payload['class_id'],
                'subject_id' => $payload['subject_id'],
                'teacher_id' => $payload['teacher_id'],
                'substitute_teacher_id' => $payload['substitute_teacher_id'] ?? null,
                'student_officer_id' => $payload['student_officer_id'] ?? null,
                'recorded_by_user_id' => $request->user()?->id,
                'attendance_taker_type' => $payload['attendance_taker_type'],
                'teacher_attendance_status' => $payload['teacher_attendance_status'],
                'attendance_date' => $payload['attendance_date'],
                'start_time' => $payload['start_time'] ?? null,
                'end_time' => $payload['end_time'] ?? null,
                'meeting_title' => $payload['meeting_title'] ?? null,
                'notes' => $payload['notes'] ?? null,
            ]);

            $attendanceSession->attendanceItems()->delete();
            $this->syncStudents($attendanceSession, $payload['students']);
        });

        return response()->json([
            'message' => 'Sesi absensi berhasil diperbarui.',
        ]);
    }

    public function destroy(Request $request, AttendanceSession $attendanceSession): JsonResponse
    {
        $this->authorizeOwnership($request, $attendanceSession);
        $attendanceSession->delete();

        return response()->json([
            'message' => 'Sesi absensi berhasil dihapus.',
        ]);
    }

    private function syncStudents(AttendanceSession $session, array $students): void
    {
        foreach ($students as $student) {
            $session->attendanceItems()->create([
                'student_id' => $student['student_id'],
                'status' => $student['status'],
                'is_late' => $student['status'] === 'terlambat' || ($student['is_late'] ?? false),
                'late_minutes' => $student['late_minutes'] ?? 0,
                'notes' => $student['notes'] ?? null,
            ]);
        }
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'class_id' => ['required', 'integer', Rule::exists('classes', 'id')],
            'subject_id' => ['required', 'integer', Rule::exists('subjects', 'id')],
            'teacher_id' => ['required', 'integer', Rule::exists('teachers', 'id')],
            'substitute_teacher_id' => ['nullable', 'integer', Rule::exists('teachers', 'id')],
            'student_officer_id' => ['nullable', 'integer', Rule::exists('students', 'id')],
            'attendance_taker_type' => ['required', Rule::in(['teacher', 'substitute_teacher', 'student_officer', 'staff'])],
            'teacher_attendance_status' => ['required', Rule::in(['hadir', 'izin', 'sakit', 'dinas_luar', 'alpha'])],
            'attendance_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'meeting_title' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'students' => ['required', 'array', 'min:1'],
            'students.*.student_id' => ['required', 'integer', Rule::exists('students', 'id')],
            'students.*.status' => ['required', Rule::in(['hadir', 'sakit', 'izin', 'bolos', 'terlambat'])],
            'students.*.is_late' => ['nullable', 'boolean'],
            'students.*.late_minutes' => ['nullable', 'integer', 'min:0', 'max:300'],
            'students.*.notes' => ['nullable', 'string'],
        ]);
    }

    private function meta(Request $request): array
    {
        $teacherId = $this->teacherIdForUser($request);

        $classes = SchoolClass::query()
            ->with('students')
            ->when($teacherId, function ($query) use ($teacherId) {
                $query->whereHas('teacherAssignments', function ($assignmentQuery) use ($teacherId): void {
                    $assignmentQuery->where('teacher_id', $teacherId)->where('status', 'active');
                });
            })
            ->orderBy('name')
            ->get()
            ->map(fn (SchoolClass $class): array => [
                'id' => $class->id,
                'name' => $class->name,
                'students' => $class->students
                    ->sortBy('name')
                    ->values()
                    ->map(fn (Student $student): array => [
                        'id' => $student->id,
                        'name' => $student->name,
                    ])
                    ->all(),
            ])
            ->all();

        $assignments = TeacherAssignment::query()
            ->with(['teacher', 'subject', 'class'])
            ->where('status', 'active')
            ->when($teacherId, fn ($query) => $query->where('teacher_id', $teacherId))
            ->orderBy('class_id')
            ->orderBy('teacher_id')
            ->get()
            ->map(fn (TeacherAssignment $assignment): array => [
                'id' => $assignment->id,
                'teacher_id' => $assignment->teacher_id,
                'teacher_name' => $assignment->teacher?->name,
                'subject_id' => $assignment->subject_id,
                'subject_name' => $assignment->subject?->nama,
                'class_id' => $assignment->class_id,
                'class_name' => $assignment->class?->name,
                'academic_year' => $assignment->academic_year,
                'assignment_title' => $assignment->assignment_title,
            ])
            ->all();

        $subjectIds = collect($assignments)->pluck('subject_id')->filter()->unique()->values()->all();
        $teacherIds = collect($assignments)->pluck('teacher_id')->filter()->unique()->values()->all();
        $classIds = collect($classes)->pluck('id')->filter()->unique()->values()->all();

        return [
            'classes' => $classes,
            'subjects' => Subject::query()
                ->when($teacherId, fn ($query) => $query->whereIn('id', $subjectIds))
                ->orderBy('nama')
                ->get(['id', 'nama']),
            'teachers' => Teacher::query()
                ->when($teacherId, fn ($query) => $query->whereIn('id', $teacherIds))
                ->orderBy('name')
                ->get(['id', 'name']),
            'student_officers' => Student::query()
                ->when($teacherId, fn ($query) => $query->whereIn('class_id', $classIds))
                ->orderBy('name')
                ->get(['id', 'name', 'class_id']),
            'assignments' => $assignments,
            'current_teacher_id' => $teacherId,
        ];
    }

    private function teacherIdForUser(Request $request): ?int
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('guru')) {
            return null;
        }

        return Teacher::query()->where('user_id', $user->id)->value('id');
    }

    private function scopePayloadForTeacher(Request $request, array &$payload): void
    {
        $teacherId = $this->teacherIdForUser($request);

        if (! $teacherId) {
            return;
        }

        $payload['teacher_id'] = $teacherId;

        $hasAssignment = TeacherAssignment::query()
            ->where('teacher_id', $teacherId)
            ->where('class_id', $payload['class_id'])
            ->where('subject_id', $payload['subject_id'])
            ->where('status', 'active')
            ->exists();

        if (! $hasAssignment) {
            abort(403, 'Kelas atau mapel tidak termasuk penugasan guru login.');
        }
    }

    private function authorizeOwnership(Request $request, AttendanceSession $attendanceSession): void
    {
        $teacherId = $this->teacherIdForUser($request);

        if (! $teacherId) {
            return;
        }

        if (! in_array($teacherId, [$attendanceSession->teacher_id, $attendanceSession->substitute_teacher_id], true)) {
            abort(403, 'Akses sesi absensi ditolak.');
        }
    }
}
