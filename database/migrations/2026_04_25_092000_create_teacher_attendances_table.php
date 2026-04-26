<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('recorded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('attendance_date');
            $table->dateTime('check_in_at')->nullable();
            $table->dateTime('check_out_at')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'dinas_luar', 'cuti', 'alpha'])->default('hadir');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['teacher_id', 'attendance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_attendances');
    }
};
