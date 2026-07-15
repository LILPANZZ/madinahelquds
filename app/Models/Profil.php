<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = [
        'nama_pondok',
        'pengasuh',
        'tahun_berdiri',
        'jumlah_santri',
        'jumlah_ustadz',
        'alamat',
        'telepon',
        'email',
        'website',
        'visi',
        'misi',
        'sejarah',
    ];
}
