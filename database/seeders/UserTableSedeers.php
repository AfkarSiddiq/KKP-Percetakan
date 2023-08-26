<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSedeers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'level' => 'admin',
            'alamat' => 'Darussalam',
            'no_hp' => '081234567890',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('yokbisayok'),
          ]);
    }
}
