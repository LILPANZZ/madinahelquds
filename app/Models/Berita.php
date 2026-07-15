<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'gambar',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'gambar' => 'array',
    ];

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }
}
