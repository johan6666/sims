<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'substitute_teacher_id',
        'student_officer_id',
        'recorded_by_user_id',
        'attendance_taker_type',
        'teacher_attendance_status',
        'attendance_date',
        'start_time',
        'end_time',
        'meeting_title',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
        ];
    }

    public function attendanceItems(): HasMany
    {
        return $this->hasMany(AttendanceSessionStudent::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function substituteTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'substitute_teacher_id');
    }

    public function studentOfficer(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_officer_id');
    }

    public function recordedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by_user_id');
    }
}
