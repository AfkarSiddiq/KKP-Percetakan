<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//model
use App\Models\Toko;

class TokoTableSedeers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Toko::create([
            'nama' => 'Pacific Printing',
            'alamat' => 'Jl. Prof. Ali Hasyimi No.7, Lamteh, Ulee Kareng, Kota Banda Aceh',
            'no_telp' => '0823 2121 6131',
            'no_rekening' => '1234567890',
            'logo' => 'logo.png',
            'foto' => 'about.jpeg',
        ]);
    }
}
