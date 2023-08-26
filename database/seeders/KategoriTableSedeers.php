<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//model
use App\Models\Kategori;

class KategoriTableSedeers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Print Lembaran',
            ],
            [
                'nama' => 'Stationery',
            ],
            [
                'nama' => 'Print Kain',
            ],
            [
                'nama' => 'Large Format',
            ],
            [
                'nama' => 'Proomo dan Gift',
            ],
            [
                'nama' => 'Foto',
            ],
            [
                'nama' => 'Marketing Tools',
            ],
            [
                'nama' => 'Printerior',
            ],
            [
                'nama' => 'Coworking Space',
            ],
            [
                'nama' => 'Signage',
            ],
            [
                'nama' => 'Packaging',
            ],
            [
                'nama' => 'UMKM',
            ],
        ];

        foreach ($data as $d) {
            Kategori::create($d);
        }
    }
}
