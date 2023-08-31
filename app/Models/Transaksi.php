<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = [
        'barang_id', 'pelanggan_id', 'tgl', 'jumlah', 'harga', 'panjang', 'lebar', 'luas', 'total_harga', 'keterangan', 'total_bayar', 'status','sisa'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
