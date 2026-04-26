<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->unique()->constrained('roles')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_profiles');
    }
};
