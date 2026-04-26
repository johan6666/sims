<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'recorded_by_user_id',
        'attendance_date',
        'check_in_at',
        'check_out_at',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
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
}
