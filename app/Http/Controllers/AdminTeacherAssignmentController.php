<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminTeacherAssignmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $teacherId = $this->teacherIdForUser($request);

        $query = TeacherAssignment::query()
            ->with(['teacher', 'subject', 'class'])
            ->orderBy('academic_year')
            ->orderBy('class_id');

        if ($teacherId) {
            $query->where('teacher_id', $teacherId);
        }

        $assignments = $query->get()->map(fn (TeacherAssignment $assignment): array => [
            'id' => $assignment->id,
            'teacher_id' => $assignment->teacher_id,
            'teacher_name' => $assignment->teacher?->name,
            'subject_id' => $assignment->subject_id,
            'subject_name' => $assignment->subject?->nama,
            'class_id' => $assignment->class_id,
            'class_name' => $assignment->class?->name,
            'academic_year' => $assignment->academic_year,
            'is_homeroom_teacher' => $assignment->is_homeroom_teacher,
            'assignment_title' => $assignment->assignment_title,
            'status' => $assignment->status,
        ]);

        return response()->json([
            'data' => $assignments,
            'meta' => [
                'teachers' => Teacher::query()
                    ->with('user')
                    ->when($teacherId, fn ($query) => $query->whereKey($teacherId))
                    ->orderBy('name')
                    ->get(['id', 'name', 'nip', 'user_id'])
                    ->map(fn (Teacher $teacher): array => [
                        'id' => $teacher->id,
                        'name' => $teacher->name,
                        'nip' => $teacher->nip,
                        'email' => $teacher->user?->email,
                    ])
                    ->values(),
                'subjects' => Subject::query()
                    ->when($teacherId, function ($query) use ($teacherId): void {
                        $query->whereHas('teacherAssignments', function ($assignmentQuery) use ($teacherId): void {
                            $assignmentQuery->where('teacher_id', $teacherId);
                        });
                    })
                    ->orderBy('nama')
                    ->get(['id', 'nama']),
                'classes' => SchoolClass::query()
                    ->when($teacherId, function ($query) use ($teacherId): void {
                        $query->whereHas('teacherAssignments', function ($assignmentQuery) use ($teacherId): void {
                            $assignmentQuery->where('teacher_id', $teacherId);
                        });
                    })
                    ->orderBy('name')
                    ->get(['id', 'name']),
                'academic_years' => AcademicYear::query()
                    ->orderByDesc('is_active')
                    ->orderByDesc('name')
                    ->get(['id', 'name', 'is_active']),
                'current_teacher_id' => $teacherId,
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->validated($request);
        $this->overrideTeacherIdForGuru($request, $payload);

        TeacherAssignment::create($payload);

        return response()->json(['message' => 'Penugasan guru berhasil dibuat.'], 201);
    }

    public function update(Request $request, TeacherAssignment $teacherAssignment): JsonResponse
    {
        $this->authorizeOwnership($request, $teacherAssignment);

        $payload = $this->validated($request);
        $this->overrideTeacherIdForGuru($request, $payload);

        $teacherAssignment->update($payload);

        return response()->json(['message' => 'Penugasan guru berhasil diperbarui.']);
    }

    public function destroy(Request $request, TeacherAssignment $teacherAssignment): JsonResponse
    {
        $this->authorizeOwnership($request, $teacherAssignment);
        $teacherAssignment->delete();

        return response()->json(['message' => 'Penugasan guru berhasil dihapus.']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'teacher_id' => ['required', 'integer', Rule::exists('teachers', 'id')],
            'subject_id' => ['required', 'integer', Rule::exists('subjects', 'id')],
            'class_id' => ['required', 'integer', Rule::exists('classes', 'id')],
            'academic_year' => ['required', 'string', 'max:20'],
            'is_homeroom_teacher' => ['nullable', 'boolean'],
            'assignment_title' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }

    private function teacherIdForUser(Request $request): ?int
    {
        if (! $request->user()?->hasRole('guru')) {
            return null;
        }

        return Teacher::query()->where('user_id', $request->user()->id)->value('id');
    }

    private function overrideTeacherIdForGuru(Request $request, array &$payload): void
    {
        $teacherId = $this->teacherIdForUser($request);

        if ($teacherId) {
            $payload['teacher_id'] = $teacherId;
        }
    }

    private function authorizeOwnership(Request $request, TeacherAssignment $teacherAssignment): void
    {
        $teacherId = $this->teacherIdForUser($request);

        if ($teacherId && $teacherAssignment->teacher_id !== $teacherId) {
            abort(403, 'Akses penugasan guru ditolak.');
        }
    }
}
