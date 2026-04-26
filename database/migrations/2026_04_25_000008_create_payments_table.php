<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->enum('jenis', ['spp', 'uang_gedung', 'seragam', 'buku', 'kegiatan', 'lainnya']);
            $table->string('bulan', 20)->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('jumlah');
            $table->date('tanggal_bayar')->nullable();
            $table->enum('status', ['belum_bayar', 'lunas', 'cicilan'])->default('belum_bayar');
            $table->enum('metode', ['tunai', 'transfer', 'ewallet'])->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
