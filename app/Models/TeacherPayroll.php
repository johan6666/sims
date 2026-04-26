<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AcademicYear;

class TeacherPayroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'academic_year_id',
        'recorded_by_user_id',
        'period_month',
        'period_year',
        'teacher_name_snapshot',
        'teacher_nip_snapshot',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_gaji',
        'status_pembayaran',
        'paid_at',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'gaji_pokok' => 'decimal:2',
            'tunjangan' => 'decimal:2',
            'potongan' => 'decimal:2',
            'total_gaji' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function recordedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by_user_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
