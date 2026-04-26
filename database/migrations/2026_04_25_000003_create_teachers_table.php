<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nip', 30)->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('phone', 20);
            $table->string('pendidikan_terakhir', 10);
            $table->string('mata_pelajaran')->nullable();
            $table->enum('status_kepegawaian', ['PNS', 'CPNS', 'GTY', 'GTT'])->default('GTT');
            $table->date('tmt')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
