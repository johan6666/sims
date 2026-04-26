<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_trainings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('nama_pelatihan');
            $table->text('deskripsi')->nullable();
            $table->string('penyelenggara')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->unsignedInteger('durasi_jam')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('sertifikat_url')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['teacher_id', 'tanggal_mulai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_trainings');
    }
};
