<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//model
use App\Models\Pelanggan;

class PelangganTableSedeers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Faris',
                'alamat' => 'Aceh Besar',
                'no_hp' => '081234567890',
                'status_member' => 1,
            ],
            [
                'nama' => 'Farah',
                'alamat' => 'Ajun',
                'no_hp' => '081234567891',
                'status_member' => 2,
            ],
        ];

        foreach ($data as $d) {
            Pelanggan::create($d);
        }
    }
}
