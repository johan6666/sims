<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpdbPendaftar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ppdb_pendaftar';

    protected $fillable = [
        'no_pendaftaran',
        'nama_lengkap',
        'email',
        'no_hp',
        'asal_sekolah',
        'tanggal_lahir',
        'jenis_kelamin',
        'pilihan_jurusan',
        'nama_ayah',
        'no_hp_ayah',
        'status',
        'nilai_tes',
        'tanggal_daftar',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'datetime',
        'nilai_tes' => 'decimal:2',
    ];
}
