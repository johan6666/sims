<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->string('semester', 10);
            $table->string('tahun_ajaran', 20);
            $table->integer('nilai_harian')->nullable();
            $table->integer('nilai_uts')->nullable();
            $table->integer('nilai_uas')->nullable();
            $table->integer('nilai_akhir')->nullable();
            $table->string('predikat', 1)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'semester', 'tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
