<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $fillable = [
        'nama','alamat','no_hp','status_member', 'jumlah_pesanan',
    ];

    public $timestamps = true;

    public function pesanan(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}
