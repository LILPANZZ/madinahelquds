<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $fillable = [
        'berita_id',
        'parent_id',
        'nama',
        'email',
        'komentar',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    public function parent()
    {
        return $this->belongsTo(Komentar::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Komentar::class, 'parent_id');
    }
}
