<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'phone',
        'pendidikan_terakhir',
        'mata_pelajaran',
        'status_kepegawaian',
        'tmt',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tmt' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class, 'teacher_id');
    }

    public function substituteAttendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class, 'substitute_teacher_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TeacherAssignment::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(TeacherAttendance::class);
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(TeacherPayroll::class);
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(TeacherTraining::class);
    }
}
