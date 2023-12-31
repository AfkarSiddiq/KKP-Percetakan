<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;
    protected $table = 'pemasukan';

    protected $fillable = [
        'transaksi_id', 'jumlah', 'pembayaran', 'tgl'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
