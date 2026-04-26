<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesMasuk extends Model
{
    use HasFactory;

    protected $table = 'tes_masuk';

    protected $fillable = [
        'pendaftar_id',
        'jadwal_tes',
        'metode_tes',
        'ruangan',
        'nilai_tes',
        'durasi_tes',
        'status_tes',
        'hasil',
    ];

    protected $casts = [
        'jadwal_tes' => 'datetime',
        'nilai_tes' => 'decimal:2',
    ];
}
