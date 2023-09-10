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
            'kode_nota' => 'PDP',
            'alamat' => 'Jl. Prof. Ali Hasyimi No.7, Lamteh, Ulee Kareng, Kota Banda Aceh',
            'no_telp' => '0823 2121 6131',
            'no_rekening' => '1234567890',
            'logo' => 'logo.png',
            'foto' => 'about.jpg',
            'deskripsi' => 'Pasific Printing merupakan manajemen percetakan yang bergelut pada bidang percetakan dan memiliki 5000+ pelanggan setia yang berada di seluruh Indonesia. Anda bisa mencetak sesuai keinginan anda dengan hasil yang sangat memuaskan.'
        ]);
    }
}
