<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Teacher;
use App\Models\TeacherPayroll;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class AdminTeacherPayrollController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $payrolls = TeacherPayroll::query()
            ->with(['teacher.user', 'academicYear', 'recordedByUser'])
            ->orderByDesc('academic_year_id')
            ->orderByDesc('id')
            ->get()
            ->map(fn (TeacherPayroll $payroll): array => $this->serialize($payroll))
            ->values();

        return response()->json([
            'data' => $payrolls,
            'meta' => [
                'teachers' => Teacher::query()
                    ->with('user')
                    ->orderBy('name')
                    ->get(['id', 'name', 'nip', 'user_id'])
                    ->map(fn (Teacher $teacher): array => [
                        'value' => (string) $teacher->id,
                        'label' => trim($teacher->name.($teacher->nip ? ' - '.$teacher->nip : '')),
                    ])
                    ->values()
                    ->all(),
                'academic_years' => AcademicYear::query()
                    ->orderByDesc('is_active')
                    ->orderByDesc('name')
                    ->get(['id', 'name', 'is_active'])
                    ->map(fn (AcademicYear $year): array => [
                        'value' => (string) $year->id,
                        'label' => $year->name,
                        'is_active' => $year->is_active,
                    ])
                    ->values()
                    ->all(),
                'now' => now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->validated($request);
        $teacher = Teacher::query()->findOrFail((int) $payload['teacher_id']);
        $academicYear = $this->resolveAcademicYear($payload['academic_year_id'] ?? null);
        $periodYear = (int) substr((string) $academicYear->name, 0, 4);
        $teacherNameSnapshot = $this->teacherNameSnapshot($payload, $teacher);

        $payroll = TeacherPayroll::updateOrCreate(
            [
                'teacher_id' => $teacher->id,
                'period_month' => $payload['periode_bulan'],
                'academic_year_id' => $academicYear->id,
            ],
            [
                'academic_year_id' => $academicYear->id,
                'recorded_by_user_id' => $request->user()?->id,
                'period_year' => $periodYear,
                'teacher_name_snapshot' => $teacherNameSnapshot,
                'teacher_nip_snapshot' => $teacher->nip,
                'gaji_pokok' => $this->money($payload['gaji_pokok'] ?? 0),
                'tunjangan' => $this->money($payload['tunjangan'] ?? 0),
                'potongan' => $this->money($payload['potongan'] ?? 0),
                'total_gaji' => $this->money($payload['total_gaji'] ?? 0),
                'status_pembayaran' => $payload['status_pembayaran'],
                'keterangan' => $payload['keterangan'] ?? null,
                'paid_at' => $payload['status_pembayaran'] === 'paid' ? now() : null,
            ]
        );

        $payroll->forceFill([
            'total_gaji' => $this->money($payload['total_gaji'] ?? $this->calculateTotal($payload)),
        ])->save();

        return response()->json([
            'message' => 'Data penggajian berhasil disimpan.',
            'data' => $this->serialize($payroll->fresh(['teacher.user', 'recordedByUser'])),
        ], 201);
    }

    public function update(Request $request, TeacherPayroll $teacherPayroll): JsonResponse
    {
        $payload = $this->validated($request, $teacherPayroll->id);
        $teacher = Teacher::query()->findOrFail((int) $payload['teacher_id']);
        $academicYear = $this->resolveAcademicYear($payload['academic_year_id'] ?? null, $teacherPayroll->academic_year_id);
        $periodYear = (int) substr((string) $academicYear->name, 0, 4);
        $teacherNameSnapshot = $this->teacherNameSnapshot($payload, $teacher);

        $teacherPayroll->update([
            'teacher_id' => $teacher->id,
            'academic_year_id' => $academicYear->id,
            'recorded_by_user_id' => $request->user()?->id,
            'period_month' => $payload['periode_bulan'],
            'period_year' => $periodYear,
            'teacher_name_snapshot' => $teacherNameSnapshot,
            'teacher_nip_snapshot' => $teacher->nip,
            'gaji_pokok' => $this->money($payload['gaji_pokok'] ?? 0),
            'tunjangan' => $this->money($payload['tunjangan'] ?? 0),
            'potongan' => $this->money($payload['potongan'] ?? 0),
            'total_gaji' => $this->money($payload['total_gaji'] ?? $this->calculateTotal($payload)),
            'status_pembayaran' => $payload['status_pembayaran'],
            'keterangan' => $payload['keterangan'] ?? null,
            'paid_at' => $payload['status_pembayaran'] === 'paid' ? ($teacherPayroll->paid_at ?? now()) : null,
        ]);

        return response()->json([
            'message' => 'Data penggajian berhasil diperbarui.',
            'data' => $this->serialize($teacherPayroll->fresh(['teacher.user', 'recordedByUser'])),
        ]);
    }

    public function destroy(TeacherPayroll $teacherPayroll): JsonResponse
    {
        $teacherPayroll->delete();

        return response()->json(['message' => 'Data penggajian berhasil dihapus.']);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'teacher_id' => ['required', 'integer', Rule::exists('teachers', 'id')],
            'academic_year_id' => ['nullable', 'integer', Rule::exists('academic_years', 'id')],
            'periode_bulan' => ['required', 'string', Rule::in(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])],
            'nama_pegawai' => ['nullable', 'string', 'max:255'],
            'gaji_pokok' => ['nullable'],
            'tunjangan' => ['nullable'],
            'potongan' => ['nullable'],
            'total_gaji' => ['nullable'],
            'status_pembayaran' => ['required', Rule::in(['draft', 'proses', 'paid'])],
            'keterangan' => ['nullable', 'string'],
        ]);
    }

    private function resolveAcademicYear(mixed $academicYearId, ?int $fallbackId = null): AcademicYear
    {
        if ($academicYearId !== null && $academicYearId !== '') {
            return AcademicYear::query()->findOrFail((int) $academicYearId);
        }

        if ($fallbackId) {
            $academicYear = AcademicYear::query()->find($fallbackId);

            if ($academicYear) {
                return $academicYear;
            }
        }

        $academicYear = AcademicYear::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->first()
            ?? AcademicYear::query()
                ->orderByDesc('is_active')
                ->orderByDesc('name')
                ->first();

        if (! $academicYear) {
            throw ValidationException::withMessages([
                'academic_year_id' => 'Tahun ajaran aktif belum tersedia.',
            ]);
        }

        return $academicYear;
    }

    private function teacherNameSnapshot(array $payload, Teacher $teacher): string
    {
        $name = trim((string) ($payload['nama_pegawai'] ?? ''));

        return $name !== '' ? $name : $teacher->name;
    }

    private function serialize(TeacherPayroll $payroll): array
    {
        return [
            'id' => $payroll->id,
            'teacher_id' => $payroll->teacher_id,
            'teacher_name' => $payroll->teacher?->name ?? $payroll->teacher_name_snapshot,
            'teacher_nip' => $payroll->teacher?->nip ?? $payroll->teacher_nip_snapshot,
            'nama_pegawai' => $payroll->teacher_name_snapshot,
            'academic_year_id' => $payroll->academic_year_id,
            'academic_year_label' => $payroll->academicYear?->name,
            'periode_bulan' => $payroll->period_month,
            'periode_tahun' => $payroll->period_year,
            'periode_label' => $payroll->period_month.' '.($payroll->academicYear?->name ?? $payroll->period_year),
            'gaji_pokok' => (float) $payroll->gaji_pokok,
            'tunjangan' => (float) $payroll->tunjangan,
            'potongan' => (float) $payroll->potongan,
            'total_gaji' => (float) $payroll->total_gaji,
            'status_pembayaran' => $payroll->status_pembayaran,
            'paid_at' => optional($payroll->paid_at)->format('Y-m-d H:i:s'),
            'keterangan' => $payroll->keterangan,
            'recorded_by_name' => $payroll->recordedByUser?->name,
            'slip_number' => sprintf('SLIP-%04d-%03d', $payroll->period_year, $payroll->id),
        ];
    }

    private function money(mixed $value): float
    {
        return (float) preg_replace('/[^\d-]/', '', (string) $value) ?: 0.0;
    }

    private function calculateTotal(array $payload): float
    {
        return max(0, $this->money($payload['gaji_pokok'] ?? 0) + $this->money($payload['tunjangan'] ?? 0) - $this->money($payload['potongan'] ?? 0));
    }
}
