<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_payrolls', function (Blueprint $table): void {
            if (! Schema::hasColumn('teacher_payrolls', 'academic_year_id')) {
                $table->foreignId('academic_year_id')
                    ->nullable()
                    ->after('recorded_by_user_id')
                    ->constrained('academic_years')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('teacher_payrolls', function (Blueprint $table): void {
            if (Schema::hasColumn('teacher_payrolls', 'academic_year_id')) {
                $table->dropConstrainedForeignId('academic_year_id');
            }
        });
    }
};
