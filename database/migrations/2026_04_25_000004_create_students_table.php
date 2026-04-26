<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('phone', 20)->nullable();
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->enum('status', ['aktif', 'lulus', 'pindah', 'keluar'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
