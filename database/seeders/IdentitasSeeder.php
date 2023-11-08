<?php

namespace Database\Seeders;

use App\Models\Identitas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IdentitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Identitas::create([
            'nama_app' => '64 Mart',
            'alamat' => 'Gifted School, Jl. Jaani Nasir, RT.5/RW.11, Cawang, Kec. Kramat jati, Daerah Khusus Ibukota Jakarta 13630',
            'logo' => 'default.png',
            'background_login' => 'default.jpg'
        ]);
    }
}
