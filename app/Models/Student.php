<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'name',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'phone',
        'class_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function attendanceItems(): HasMany
    {
        return $this->hasMany(AttendanceSessionStudent::class);
    }

    public function officerAttendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class, 'student_officer_id');
    }
}
