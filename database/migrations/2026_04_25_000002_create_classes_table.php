<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('classes')) {
            return;
        }

        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('tingkat');
            $table->enum('jurusan', ['IPA', 'IPS']);
            $table->foreignId('wali_kelas_id')->nullable()->index();
            $table->integer('kapasitas')->default(36);
            $table->string('ruang_kelas')->nullable();
            $table->string('tahun_ajaran', 20)->default('2026/2027');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
