<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//model
use App\Models\Bahan;

class BahanTableSedeers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_bahan' => 'Vinyl Frontlit 280g',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'Vinyl Frontlit 340g',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'Vinyl Frontlit 440g',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'Vinyl Backlit 610g',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'PVC Card',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'Satin',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'Ritrama',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'One Way Vision',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'Matte 220g',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'Art Carton 260g',
                'jumlah' => 224,
                'satuan' => 'meter',
            ],
            [
                'nama_bahan' => 'PIN',
                'jumlah' => 224,
                'satuan' => 'pcs',
            ],
        ];

        foreach ($data as $key => $value) {
            Bahan::create($value);
        }
    }
}
