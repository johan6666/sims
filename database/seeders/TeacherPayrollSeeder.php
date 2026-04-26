<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\TeacherPayroll;
use Illuminate\Database\Seeder;

class TeacherPayrollSeeder extends Seeder
{
    public function run(): void
    {
        $periodMonth = 'April';
        $periodYear = 2026;

        $teachers = Teacher::query()
            ->whereIn('name', ['Ahmad Fauzan', 'Siti Mariani'])
            ->get()
            ->keyBy('name');

        $this->upsertPayroll($teachers->get('Ahmad Fauzan'), $periodMonth, $periodYear, 4500000, 750000, 150000, 'proses', 'Slip gaji bulan berjalan.');
        $this->upsertPayroll($teachers->get('Siti Mariani'), $periodMonth, $periodYear, 4200000, 650000, 100000, 'paid', 'Sudah dibayarkan melalui transfer.');
    }

    private function upsertPayroll(?Teacher $teacher, string $month, int $year, int $base, int $allowance, int $deduction, string $status, string $notes): void
    {
        if (! $teacher) {
            return;
        }

        TeacherPayroll::updateOrCreate(
            [
                'teacher_id' => $teacher->id,
                'period_month' => $month,
                'period_year' => $year,
            ],
            [
                'teacher_name_snapshot' => $teacher->name,
                'teacher_nip_snapshot' => $teacher->nip,
                'gaji_pokok' => $base,
                'tunjangan' => $allowance,
                'potongan' => $deduction,
                'total_gaji' => max(0, $base + $allowance - $deduction),
                'status_pembayaran' => $status,
                'paid_at' => $status === 'paid' ? now() : null,
                'keterangan' => $notes,
            ]
        );
    }
}
