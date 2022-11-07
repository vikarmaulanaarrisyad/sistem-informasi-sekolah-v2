<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstansiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Instansi::create([
            'nsm_instansi' => '111233230030',
            'npsn_instansi' => '60713624',
            'nama_instansi' => 'MIS Ikhsaniyah Lebeteng',
            'email_instansi' => 'milebeteng@gmail.com',
            'alamat_instansi' => 'Desa Lebeteng'
        ]);
    }
}
