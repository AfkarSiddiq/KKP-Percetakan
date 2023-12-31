<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;
    protected $table = 'bahan';

    protected $fillable = [
        'nama_bahan', 'jumlah', 'satuan',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
