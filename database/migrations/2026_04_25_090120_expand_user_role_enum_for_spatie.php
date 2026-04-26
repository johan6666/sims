<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'super_admin',
                'admin',
                'guru',
                'siswa',
                'staff',
                'orang_tua',
                'alumni'
            ) NOT NULL DEFAULT 'siswa'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'guru',
                'siswa',
                'orang_tua',
                'alumni'
            ) NOT NULL DEFAULT 'siswa'
        ");
    }
};
