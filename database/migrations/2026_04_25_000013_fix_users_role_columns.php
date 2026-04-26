<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'guru', 'siswa', 'orang_tua', 'alumni'])->after('email');
            }

            if (! Schema::hasColumn('users', 'nip_nis')) {
                $table->string('nip_nis')->nullable()->unique()->after('role');
            }

            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('nip_nis');
            }

            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('avatar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $drop = [];

            foreach (['role', 'nip_nis', 'phone', 'avatar', 'is_active'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $drop[] = $column;
                }
            }

            if ($drop) {
                $table->dropColumn($drop);
            }
        });
    }
};
