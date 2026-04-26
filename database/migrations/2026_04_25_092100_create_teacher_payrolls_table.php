<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_payrolls', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('recorded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('period_month', 20);
            $table->unsignedSmallInteger('period_year');
            $table->string('teacher_name_snapshot');
            $table->string('teacher_nip_snapshot')->nullable();
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('tunjangan', 15, 2)->default(0);
            $table->decimal('potongan', 15, 2)->default(0);
            $table->decimal('total_gaji', 15, 2)->default(0);
            $table->enum('status_pembayaran', ['draft', 'proses', 'paid'])->default('draft');
            $table->dateTime('paid_at')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['teacher_id', 'period_month', 'period_year'], 'teacher_payroll_period_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_payrolls');
    }
};
