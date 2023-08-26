<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//model
use App\Models\Barang;

class BarangTableSedeers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'SP01',
                'nama_barang' => 'Spanduk Vinyl 280g',
                'kategori_id' => 4,
                'bahan_id' => 1,
                'harga' => 25000,
                'harga_member' => 20000,
                'harga_studio' => 15000,
                'satuan' => 'meter',
            ],
            [
                'kode' => 'IDC01',
                'nama_barang' => 'ID Card Tanpa Gantungan',
                'kategori_id' => 2,
                'bahan_id' => 5,
                'harga' => 20000,
                'harga_member' => 20000,
                'harga_studio' => 20000,
                'satuan' => 'pcs',
            ]
        ];

        foreach ($data as $key => $value) {
            Barang::create($value);
        }
    }
}
