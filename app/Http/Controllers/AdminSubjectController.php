<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminSubjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Subject::query()
                ->orderBy('nama')
                ->get()
                ->map(fn (Subject $subject): array => [
                    'id' => $subject->id,
                    'kode' => $subject->kode,
                    'nama' => $subject->nama,
                    'kelompok' => $subject->kelompok,
                    'kkm' => $subject->kkm,
                ])
                ->values(),
            'meta' => [
                'kelompok_options' => ['A', 'B', 'C'],
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $subject = Subject::query()->create($this->validated($request));

        return response()->json([
            'message' => 'Mata pelajaran berhasil dibuat.',
            'data' => $this->serialize($subject),
        ], 201);
    }

    public function update(Request $request, Subject $subject): JsonResponse
    {
        $subject->update($this->validated($request, $subject->id));

        return response()->json([
            'message' => 'Mata pelajaran berhasil diperbarui.',
            'data' => $this->serialize($subject->fresh()),
        ]);
    }

    public function destroy(Subject $subject): JsonResponse
    {
        $subject->delete();

        return response()->json([
            'message' => 'Mata pelajaran berhasil dihapus.',
        ]);
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:10',
                Rule::unique('subjects', 'kode')->ignore($ignoreId),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'kelompok' => ['required', Rule::in(['A', 'B', 'C'])],
            'kkm' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);
    }

    private function serialize(Subject $subject): array
    {
        return [
            'id' => $subject->id,
            'kode' => $subject->kode,
            'nama' => $subject->nama,
            'kelompok' => $subject->kelompok,
            'kkm' => $subject->kkm,
        ];
    }
}
