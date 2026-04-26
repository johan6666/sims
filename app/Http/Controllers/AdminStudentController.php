<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class AdminStudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::query()
            ->with('class')
            ->orderBy('name')
            ->get()
            ->map(fn (Student $student): array => [
                'id' => $student->id,
                'nis' => $student->nis,
                'nisn' => $student->nisn,
                'nama_lengkap' => $student->name,
                'tempat_lahir' => $student->tempat_lahir,
                'tanggal_lahir' => optional($student->tanggal_lahir)->format('Y-m-d'),
                'jenis_kelamin' => $student->gender === 'P' ? 'perempuan' : 'laki-laki',
                'alamat' => $student->alamat,
                'no_telepon' => $student->phone,
                'class_id' => $student->class_id,
                'class_name' => $student->class?->name,
                'status' => $student->status,
            ])
            ->all();

        return response()->json([
            'data' => $students,
            'meta' => [
                'classes' => SchoolClass::query()->orderBy('name')->get(['id', 'name']),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->validated($request);

        $student = Student::query()->create([
            'nis' => $payload['nis'],
            'nisn' => $payload['nisn'] ?? null,
            'name' => $payload['nama_lengkap'],
            'gender' => $payload['jenis_kelamin'] === 'perempuan' ? 'P' : 'L',
            'tempat_lahir' => $payload['tempat_lahir'] ?? null,
            'tanggal_lahir' => $payload['tanggal_lahir'] ?? null,
            'alamat' => $payload['alamat'] ?? null,
            'phone' => $payload['no_telepon'] ?? null,
            'class_id' => $payload['class_id'],
            'status' => $payload['status'] ?? 'aktif',
        ]);

        return response()->json([
            'message' => 'Data siswa berhasil dibuat.',
            'data' => ['id' => $student->id],
        ], 201);
    }

    public function update(Request $request, Student $student): JsonResponse
    {
        $payload = $this->validated($request, $student->id);

        $student->update([
            'nis' => $payload['nis'],
            'nisn' => $payload['nisn'] ?? null,
            'name' => $payload['nama_lengkap'],
            'gender' => $payload['jenis_kelamin'] === 'perempuan' ? 'P' : 'L',
            'tempat_lahir' => $payload['tempat_lahir'] ?? null,
            'tanggal_lahir' => $payload['tanggal_lahir'] ?? null,
            'alamat' => $payload['alamat'] ?? null,
            'phone' => $payload['no_telepon'] ?? null,
            'class_id' => $payload['class_id'],
            'status' => $payload['status'] ?? 'aktif',
        ]);

        return response()->json([
            'message' => 'Data siswa berhasil diperbarui.',
        ]);
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json([
            'message' => 'Data siswa berhasil dihapus.',
        ]);
    }

    public function downloadTemplate(): Response
    {
        $rows = [
            ['nis', 'nisn', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_telepon', 'kelas', 'status'],
        ];

        return $this->csvResponse('template-import-siswa.csv', $rows);
    }

    public function downloadSampleTemplate(): Response
    {
        $rows = [
            ['nis', 'nisn', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_telepon', 'kelas', 'status'],
            ['2026001', '9988776601', 'Andi Pratama', 'laki-laki', 'Kroya', '2009-01-10', 'Jl. Melati 1', '081234567890', 'X-A', 'aktif'],
            ['2026002', '9988776602', 'Salsa Nabila', 'perempuan', 'Cilacap', '2009-03-21', 'Jl. Kenanga 2', '081234567891', 'X-B', 'aktif'],
        ];

        return $this->csvResponse('contoh-import-siswa.csv', $rows);
    }

    private function validated(Request $request, ?int $studentId = null): array
    {
        return $request->validate([
            'nis' => ['required', 'string', 'max:50', Rule::unique('students', 'nis')->ignore($studentId)],
            'nisn' => ['nullable', 'string', 'max:50', Rule::unique('students', 'nisn')->ignore($studentId)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['laki-laki', 'perempuan'])],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
            'class_id' => ['required', 'integer', Rule::exists('classes', 'id')],
            'status' => ['nullable', Rule::in(['aktif', 'nonaktif', 'lulus', 'keluar'])],
        ]);
    }

    /**
     * @param  array<int, array<int, string>>  $rows
     */
    private function csvResponse(string $filename, array $rows): Response
    {
        $lines = array_map(function (array $row): string {
            $escaped = array_map(function (string $value): string {
                return '"'.str_replace('"', '""', $value).'"';
            }, $row);

            return implode(',', $escaped);
        }, $rows);

        $content = "\xEF\xBB\xBF".implode("\r\n", $lines)."\r\n";

        return response($content, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
