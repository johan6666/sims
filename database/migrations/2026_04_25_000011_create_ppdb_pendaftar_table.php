<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_pendaftar', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('no_hp', 20);
            $table->string('asal_sekolah');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->enum('pilihan_jurusan', ['IPA', 'IPS']);
            $table->string('nama_ayah');
            $table->string('no_hp_ayah', 20);
            $table->enum('status', ['pending', 'submitted', 'verified', 'approved', 'rejected'])->default('pending');
            $table->decimal('nilai_tes', 5, 2)->nullable();
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_pendaftar');
    }
};
