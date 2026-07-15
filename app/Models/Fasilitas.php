<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'jumlah_kapasitas',
        'deskripsi',
        'gambar',
    ];

    protected $casts = [
        'gambar' => 'array',
    ];
}
