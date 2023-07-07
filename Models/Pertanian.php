<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanian extends Model
{
    protected $fillable = [
        'nama_tanaman',
        'luas_tanam',
        'luas_panen',
        'daerah_penghasil',
        'harga_jual',
        'foto',
        'deskripsi',
    ];
}