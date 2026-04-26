<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'nama_pelatihan',
        'deskripsi',
        'penyelenggara',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_jam',
        'lokasi',
        'sertifikat_url',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
