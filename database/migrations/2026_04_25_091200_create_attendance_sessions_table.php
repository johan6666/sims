<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('substitute_teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('student_officer_id')->nullable()->constrained('students')->nullOnDelete();
            $table->foreignId('recorded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('attendance_taker_type', ['teacher', 'substitute_teacher', 'student_officer', 'staff'])->default('teacher');
            $table->enum('teacher_attendance_status', ['hadir', 'izin', 'sakit', 'dinas_luar', 'alpha'])->default('hadir');
            $table->date('attendance_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('meeting_title')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['class_id', 'attendance_date']);
            $table->index(['teacher_id', 'attendance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};
