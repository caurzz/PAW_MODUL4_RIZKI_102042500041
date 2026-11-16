<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    // TODO 2
    protected $fillable = [
        'judul',
        'penulis',
        'tahun',
        'stok',
        'cover',
    ];
}