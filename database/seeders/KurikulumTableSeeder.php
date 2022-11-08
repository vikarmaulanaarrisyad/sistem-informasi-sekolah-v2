<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KurikulumTableSeeder extends Seeder
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
                'nama_kurikulum' => 'Kurikulum 2013',
                'tahun_ajaran_id' => 1
            ],
            [
                'id' => 2,
                'nama_kurikulum' => 'Kurikulum KTSP',
                'tahun_ajaran_id' => 1
            ],
            [
                'id' => 3,
                'nama_kurikulum' => 'Kurikulum Merdeka',
                'tahun_ajaran_id' => 2
            ]
        ];

        foreach ($data as $item) {
            Kurikulum::create($item);
        }
    }
}
