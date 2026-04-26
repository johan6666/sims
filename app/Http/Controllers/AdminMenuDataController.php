<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Teacher;
use App\Models\TeacherTraining;
use App\Support\AdminMenuRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMenuDataController extends Controller
{
    public function index(Menu $menu): JsonResponse
    {
        return response()->json([
            'data' => $this->rows($menu),
            'meta' => $this->meta($menu),
        ]);
    }

    public function store(Request $request, Menu $menu): JsonResponse
    {
        $payload = $this->payload($request);
        $id = $this->persist($menu, $payload);

        return response()->json([
            'message' => 'Data berhasil dibuat.',
            'data' => ['id' => $id] + $payload,
        ], 201);
    }

    public function update(Request $request, Menu $menu, int $recordId): JsonResponse
    {
        $payload = $this->payload($request);
        $this->persist($menu, $payload, $recordId);

        return response()->json([
            'message' => 'Data berhasil diperbarui.',
            'data' => ['id' => $recordId] + $payload,
        ]);
    }

    public function destroy(Menu $menu, int $recordId): JsonResponse
    {
        if ($menu->slug === 'kepegawaian.pelatihan-guru') {
            TeacherTraining::query()->findOrFail($recordId)->delete();
        } else {
            DB::table($this->table($menu))->where('id', $recordId)->delete();
        }

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    private function rows(Menu $menu): array
    {
        if ($menu->slug === 'kepegawaian.pelatihan-guru') {
            return TeacherTraining::query()
                ->with('teacher.user')
                ->orderByDesc('tanggal_mulai')
                ->orderByDesc('id')
                ->get()
                ->map(fn (TeacherTraining $training): array => $this->serializeTraining($training))
                ->all();
        }

        return DB::table($this->table($menu))
            ->orderBy('id')
            ->get()
            ->map(function ($row): array {
                $payload = json_decode($row->payload, true) ?? [];

                return ['id' => $row->id] + $payload;
            })
            ->all();
    }

    private function table(Menu $menu): string
    {
        return AdminMenuRegistry::tableNameForMenuSlug($menu->slug);
    }

    private function meta(Menu $menu): array
    {
        if (! in_array($menu->slug, ['kepegawaian.penggajian', 'kepegawaian.pelatihan-guru'], true)) {
            return [];
        }

        $teachers = Teacher::query()
            ->with('user')
            ->orderBy('name')
            ->get()
            ->map(fn (Teacher $teacher): array => [
                'value' => $teacher->id,
                'label' => trim($teacher->name.($teacher->nip ? ' - '.$teacher->nip : '')),
            ])
            ->values()
            ->all();

        return [
            'teachers' => $teachers,
        ];
    }

    private function payload(Request $request): array
    {
        if ($request->route('menu')?->slug === 'kepegawaian.pelatihan-guru') {
            return $request->validate([
                'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
                'nama_pelatihan' => ['required', 'string', 'max:255'],
                'deskripsi' => ['nullable', 'string'],
                'penyelenggara' => ['nullable', 'string', 'max:255'],
                'tanggal_mulai' => ['nullable', 'date'],
                'tanggal_selesai' => ['nullable', 'date'],
                'durasi_jam' => ['nullable', 'integer', 'min:0'],
                'lokasi' => ['nullable', 'string', 'max:255'],
                'sertifikat_url' => ['nullable', 'string', 'max:255'],
                'keterangan' => ['nullable', 'string'],
            ]);
        }

        return $request->except(['id']);
    }

    private function persist(Menu $menu, array $payload, ?int $recordId = null): int
    {
        if ($menu->slug === 'kepegawaian.pelatihan-guru') {
            $training = $recordId
                ? TeacherTraining::query()->findOrFail($recordId)
                : new TeacherTraining();

            $training->fill($payload)->save();

            return $training->id;
        }

        if ($recordId) {
            DB::table($this->table($menu))
                ->where('id', $recordId)
                ->update([
                    'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                    'updated_at' => now(),
                ]);

            return $recordId;
        }

        return DB::table($this->table($menu))->insertGetId([
            'payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function serializeTraining(TeacherTraining $training): array
    {
        return [
            'id' => $training->id,
            'teacher_id' => $training->teacher_id,
            'teacher_name' => $training->teacher?->name,
            'teacher_nip' => $training->teacher?->nip,
            'nama_pelatihan' => $training->nama_pelatihan,
            'deskripsi' => $training->deskripsi,
            'penyelenggara' => $training->penyelenggara,
            'tanggal_mulai' => optional($training->tanggal_mulai)->format('Y-m-d'),
            'tanggal_selesai' => optional($training->tanggal_selesai)->format('Y-m-d'),
            'durasi_jam' => $training->durasi_jam,
            'lokasi' => $training->lokasi,
            'sertifikat_url' => $training->sertifikat_url,
            'keterangan' => $training->keterangan,
        ];
    }
}
