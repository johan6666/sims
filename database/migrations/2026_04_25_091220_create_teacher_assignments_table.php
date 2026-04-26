<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('academic_year', 20)->default('2026/2027');
            $table->boolean('is_homeroom_teacher')->default(false);
            $table->string('assignment_title')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->unique(['teacher_id', 'subject_id', 'class_id', 'academic_year'], 'teacher_assignment_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_assignments');
    }
};
