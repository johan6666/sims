<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_session_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained('attendance_sessions')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->enum('status', ['hadir', 'sakit', 'izin', 'bolos', 'terlambat'])->default('hadir');
            $table->boolean('is_late')->default(false);
            $table->unsignedSmallInteger('late_minutes')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['attendance_session_id', 'student_id'], 'attendance_session_student_unique');
            $table->index(['student_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_session_students');
    }
};
