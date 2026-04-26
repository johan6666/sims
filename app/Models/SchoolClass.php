<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'tingkat',
        'jurusan',
        'wali_kelas_id',
        'kapasitas',
        'ruang_kelas',
        'tahun_ajaran',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'wali_kelas_id');
    }

    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class, 'class_id');
    }

    public function teacherAssignments(): HasMany
    {
        return $this->hasMany(TeacherAssignment::class, 'class_id');
    }
}
