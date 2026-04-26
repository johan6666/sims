<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tes_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('ppdb_pendaftar')->onDelete('cascade');
            $table->dateTime('jadwal_tes');
            $table->enum('metode_tes', ['CBT', 'tertulis', 'interview'])->default('CBT');
            $table->string('ruangan', 50)->nullable();
            $table->decimal('nilai_tes', 5, 2)->nullable();
            $table->integer('durasi_tes')->default(90);
            $table->enum('status_tes', ['belum_dimulai', 'berjalan', 'selesai', 'absent'])->default('belum_dimulai');
            $table->enum('hasil', ['lulus', 'tidak_lulus'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tes_masuk');
    }
};
