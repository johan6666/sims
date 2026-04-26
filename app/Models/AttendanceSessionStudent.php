<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSessionStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_session_id',
        'student_id',
        'status',
        'is_late',
        'late_minutes',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_late' => 'boolean',
        ];
    }

    public function attendanceSession(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
