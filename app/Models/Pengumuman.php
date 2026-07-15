<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
        'status',
        'lampiran'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public const KATEGORI = [
        'umum' => 'Umum',
        'akademik' => 'Akademik',
        'kegiatan' => 'Kegiatan',
        'penting' => 'Penting'
    ];

    public const STATUS = [
        'aktif' => 'Aktif',
        'nonaktif' => 'Nonaktif'
    ];
}
