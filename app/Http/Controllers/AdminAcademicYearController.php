<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAcademicYearController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => AcademicYear::query()
                ->orderByDesc('is_active')
                ->orderByDesc('name')
                ->get()
                ->map(fn (AcademicYear $year): array => $this->serialize($year))
                ->values(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->validated($request);
        $this->clearActiveFlagIfNeeded($payload);

        $year = AcademicYear::query()->create($payload);

        return response()->json([
            'message' => 'Tahun berhasil dibuat.',
            'data' => $this->serialize($year),
        ], 201);
    }

    public function update(Request $request, AcademicYear $academicYear): JsonResponse
    {
        $payload = $this->validated($request, $academicYear->id);
        $this->clearActiveFlagIfNeeded($payload, $academicYear->id);

        $academicYear->update($payload);

        return response()->json([
            'message' => 'Tahun berhasil diperbarui.',
            'data' => $this->serialize($academicYear->fresh()),
        ]);
    }

    public function destroy(AcademicYear $academicYear): JsonResponse
    {
        $academicYear->delete();

        return response()->json([
            'message' => 'Tahun berhasil dihapus.',
        ]);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:20',
                Rule::unique('academic_years', 'name')->ignore($ignoreId),
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function clearActiveFlagIfNeeded(array $payload, ?int $ignoreId = null): void
    {
        if (!($payload['is_active'] ?? false)) {
            return;
        }

        AcademicYear::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->update(['is_active' => false]);
    }

    private function serialize(AcademicYear $year): array
    {
        return [
            'id' => $year->id,
            'name' => $year->name,
            'is_active' => $year->is_active,
        ];
    }
}
