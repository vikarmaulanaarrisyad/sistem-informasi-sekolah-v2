<?php

namespace Database\Seeders;

use App\Models\Tahunajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAjaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nama' => 'Tahun Pelajaran 2021/2022',
                'is_semester' => 1,
                'is_active' => 0
            ],

            [
                'id' => 2,
                'nama' => 'Tahun Pelajaran 2021/2022',
                'is_semester' => 2,
                'is_active' => 0
            ],

            [
                'id' => 3,
                'nama' => 'Tahun Pelajaran 2022/2023',
                'is_semester' => 1,
                'is_active' => 0
            ],

            [
                'id' => 4,
                'nama' => 'Tahun Pelajaran 2022/2023',
                'is_semester' => 2,
                'is_active' => 1
            ],
        ];
        
      foreach ($data as $value) {
        Tahunajaran::create($value);
      }
    }
}
