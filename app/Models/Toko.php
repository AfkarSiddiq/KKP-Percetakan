<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = 'toko';

    protected $fillable = [
        'nama',
        'kode_nota',
        'alamat',
        'no_telp',
        'no_rekening',
        'logo',
        'foto',
        'deskripsi',
    ];
}
