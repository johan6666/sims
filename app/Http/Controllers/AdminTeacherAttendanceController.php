<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherAttendance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTeacherAttendanceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $teacherId = $this->teacherIdForUser($request);
        $today = Carbon::today(config('app.timezone'));

        $query = TeacherAttendance::query()
            ->with(['teacher.user', 'recordedByUser'])
            ->orderByDesc('attendance_date')
            ->orderByDesc('check_in_at');

        if ($teacherId) {
            $query->where('teacher_id', $teacherId);
        }

        $rows = $query->limit(30)->get()->map(fn (TeacherAttendance $attendance): array => [
            'id' => $attendance->id,
            'teacher_id' => $attendance->teacher_id,
            'teacher_name' => $attendance->teacher?->name,
            'attendance_date' => optional($attendance->attendance_date)->format('Y-m-d'),
            'check_in_at' => optional($attendance->check_in_at)->format('Y-m-d H:i:s'),
            'check_out_at' => optional($attendance->check_out_at)->format('Y-m-d H:i:s'),
            'status' => $attendance->status,
            'notes' => $attendance->notes,
            'recorded_by_name' => $attendance->recordedByUser?->name,
            'is_completed' => (bool) $attendance->check_in_at && (bool) $attendance->check_out_at,
        ])->values();

        $todayRow = $teacherId
            ? TeacherAttendance::query()->where('teacher_id', $teacherId)->whereDate('attendance_date', $today)->first()
            : null;

        return response()->json([
            'data' => $rows,
            'meta' => [
                'teacher' => $teacherId ? Teacher::query()->with('user')->find($teacherId, ['id', 'user_id', 'name', 'nip']) : null,
                'today' => $todayRow ? [
                    'id' => $todayRow->id,
                    'attendance_date' => optional($todayRow->attendance_date)->format('Y-m-d'),
                    'check_in_at' => optional($todayRow->check_in_at)->format('Y-m-d\TH:i'),
                    'check_out_at' => optional($todayRow->check_out_at)->format('Y-m-d\TH:i'),
                    'status' => $todayRow->status,
                    'notes' => $todayRow->notes,
                ] : null,
                'now' => now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function checkIn(Request $request): JsonResponse
    {
        $teacherId = $this->teacherIdForUser($request);

        if (! $teacherId) {
            abort(403, 'Guru login tidak ditemukan.');
        }

        $attendance = DB::transaction(function () use ($request, $teacherId): TeacherAttendance {
            $today = Carbon::today(config('app.timezone'));

            $attendance = TeacherAttendance::query()->firstOrNew(
                [
                    'teacher_id' => $teacherId,
                    'attendance_date' => $today->toDateString(),
                ],
                [
                    'recorded_by_user_id' => $request->user()?->id,
                    'status' => 'hadir',
                ]
            );

            if ($attendance->check_in_at) {
                abort(422, 'Check in hari ini sudah dilakukan.');
            }

            $attendance->recorded_by_user_id = $request->user()?->id;
            $attendance->status = 'hadir';
            $attendance->check_in_at = now();
            $attendance->save();

            return $attendance->fresh(['teacher', 'recordedByUser']);
        });

        return response()->json([
            'message' => 'Check in berhasil dicatat.',
            'data' => $this->serialize($attendance),
        ], 201);
    }

    public function checkOut(Request $request): JsonResponse
    {
        $teacherId = $this->teacherIdForUser($request);

        if (! $teacherId) {
            abort(403, 'Guru login tidak ditemukan.');
        }

        $attendance = DB::transaction(function () use ($request, $teacherId): TeacherAttendance {
            $today = Carbon::today(config('app.timezone'));

            $attendance = TeacherAttendance::query()
                ->where('teacher_id', $teacherId)
                ->whereDate('attendance_date', $today)
                ->first();

            if (! $attendance || ! $attendance->check_in_at) {
                abort(422, 'Check in belum dilakukan.');
            }

            if ($attendance->check_out_at) {
                abort(422, 'Check out hari ini sudah dilakukan.');
            }

            $attendance->update([
                'recorded_by_user_id' => $request->user()?->id,
                'check_out_at' => now(),
            ]);

            return $attendance->fresh(['teacher', 'recordedByUser']);
        });

        return response()->json([
            'message' => 'Check out berhasil dicatat.',
            'data' => $this->serialize($attendance),
        ]);
    }

    public function manualStore(Request $request): JsonResponse
    {
        $teacherId = $this->teacherIdForUser($request);

        if (! $teacherId) {
            abort(403, 'Guru login tidak ditemukan.');
        }

        $payload = $request->validate([
            'attendance_date' => ['required', 'date'],
            'status' => ['required', 'in:hadir,izin,sakit,dinas_luar,cuti,alpha'],
            'check_in_at' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'check_out_at' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'notes' => ['nullable', 'string'],
        ]);

        $attendance = TeacherAttendance::query()->updateOrCreate(
            [
                'teacher_id' => $teacherId,
                'attendance_date' => Carbon::parse($payload['attendance_date'], config('app.timezone'))->toDateString(),
            ],
            [
                'recorded_by_user_id' => $request->user()?->id,
                'status' => $payload['status'],
                'check_in_at' => $payload['check_in_at'] ? Carbon::parse($payload['check_in_at'], config('app.timezone')) : null,
                'check_out_at' => $payload['check_out_at'] ? Carbon::parse($payload['check_out_at'], config('app.timezone')) : null,
                'notes' => $payload['notes'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Absensi manual berhasil disimpan.',
            'data' => $this->serialize($attendance->fresh(['teacher', 'recordedByUser'])),
        ], 201);
    }

    public function manualUpdate(Request $request, TeacherAttendance $teacherAttendance): JsonResponse
    {
        $teacherId = $this->teacherIdForUser($request);

        if (! $teacherId || $teacherAttendance->teacher_id !== $teacherId) {
            abort(403, 'Akses absensi guru ditolak.');
        }

        $payload = $request->validate([
            'attendance_date' => ['required', 'date'],
            'status' => ['required', 'in:hadir,izin,sakit,dinas_luar,cuti,alpha'],
            'check_in_at' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'check_out_at' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'notes' => ['nullable', 'string'],
        ]);

        $teacherAttendance->update([
            'recorded_by_user_id' => $request->user()?->id,
            'attendance_date' => Carbon::parse($payload['attendance_date'], config('app.timezone'))->toDateString(),
            'status' => $payload['status'],
            'check_in_at' => $payload['check_in_at'] ? Carbon::parse($payload['check_in_at'], config('app.timezone')) : null,
            'check_out_at' => $payload['check_out_at'] ? Carbon::parse($payload['check_out_at'], config('app.timezone')) : null,
            'notes' => $payload['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Absensi manual berhasil diperbarui.',
            'data' => $this->serialize($teacherAttendance->fresh(['teacher', 'recordedByUser'])),
        ]);
    }

    private function teacherIdForUser(Request $request): ?int
    {
        if (! $request->user()?->hasRole('guru')) {
            return null;
        }

        return Teacher::query()->where('user_id', $request->user()->id)->value('id');
    }

    private function serialize(TeacherAttendance $attendance): array
    {
        return [
            'id' => $attendance->id,
            'teacher_id' => $attendance->teacher_id,
            'teacher_name' => $attendance->teacher?->name,
            'attendance_date' => optional($attendance->attendance_date)->format('Y-m-d'),
            'check_in_at' => optional($attendance->check_in_at)->format('Y-m-d H:i:s'),
            'check_out_at' => optional($attendance->check_out_at)->format('Y-m-d H:i:s'),
            'status' => $attendance->status,
            'notes' => $attendance->notes,
            'recorded_by_name' => $attendance->recordedByUser?->name,
        ];
    }
}
