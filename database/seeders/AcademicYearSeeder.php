<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            ['name' => '2025/2026', 'is_active' => false],
            ['name' => '2026/2027', 'is_active' => true],
            ['name' => '2027/2028', 'is_active' => false],
        ];

        foreach ($years as $year) {
            AcademicYear::query()->updateOrCreate(
                ['name' => $year['name']],
                ['is_active' => $year['is_active']]
            );
        }
    }
}
