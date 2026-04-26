<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminClassController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => SchoolClass::query()
                ->orderBy('name')
                ->get()
                ->map(fn (SchoolClass $class): array => $this->serialize($class))
                ->values(),
            'meta' => [
                'jurusan_options' => ['IPA', 'IPS'],
                'academic_years' => AcademicYear::query()
                    ->orderByDesc('is_active')
                    ->orderByDesc('name')
                    ->get(['id', 'name', 'is_active']),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $class = SchoolClass::query()->create($this->validated($request));

        return response()->json([
            'message' => 'Kelas berhasil dibuat.',
            'data' => $this->serialize($class),
        ], 201);
    }

    public function update(Request $request, SchoolClass $class): JsonResponse
    {
        $class->update($this->validated($request));

        return response()->json([
            'message' => 'Kelas berhasil diperbarui.',
            'data' => $this->serialize($class->fresh()),
        ]);
    }

    public function destroy(SchoolClass $class): JsonResponse
    {
        $class->delete();

        return response()->json([
            'message' => 'Kelas berhasil dihapus.',
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'tingkat' => ['required', 'integer', 'min:1', 'max:12'],
            'jurusan' => ['required', 'in:IPA,IPS'],
            'kapasitas' => ['nullable', 'integer', 'min:1'],
            'ruang_kelas' => ['nullable', 'string', 'max:255'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
        ]);
    }

    private function serialize(SchoolClass $class): array
    {
        return [
            'id' => $class->id,
            'name' => $class->name,
            'tingkat' => $class->tingkat,
            'jurusan' => $class->jurusan,
            'kapasitas' => $class->kapasitas,
            'ruang_kelas' => $class->ruang_kelas,
            'tahun_ajaran' => $class->tahun_ajaran,
        ];
    }
}
