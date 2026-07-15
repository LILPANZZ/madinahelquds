<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = [
        'judul_prestasi',
        'kategori',
        'deskripsi',
        'gambar',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'gambar' => 'array',
    ];
}
