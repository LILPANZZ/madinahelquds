<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'judul',
        'tempat',
        'deskripsi',
        'foto',
    ];

    protected $casts = [
        'foto' => 'array',
    ];
}
