<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bahan;

class SuplaiBahan extends Model
{
    use HasFactory;
    protected $table = 'suplai_bahan';
    
    protected $fillable = [
        'bahan_id',
        'jumlah',
        'tgl',
        'keterangan'
    ];

    function bahan(){
        return $this->belongsTo(Bahan::class);
    }
}
