<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasTableSeeder extends Seeder
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
                'nama_kelas' => 'Kelas 1',
                'rombel'    => 'A',
                'kapasitas_kls' => 28,
                'tahun_ajaran_id' => 1,
                'kurikulum_id' => 1,
            ],
            [
                'id' => 2,
                'nama_kelas' => 'Kelas 1',
                'rombel'    => 'B',
                'kapasitas_kls' => 28,
                'tahun_ajaran_id' => 1,
                'kurikulum_id' => 1,
            ],
            [
                'id' => 3,
                'nama_kelas' => 'Kelas 2',
                'rombel'    => 'A',
                'kapasitas_kls' => 28,
                'tahun_ajaran_id' => 2,
                'kurikulum_id' => 2,
            ],
            [
                'id' => 4,
                'nama_kelas' => 'Kelas 3',
                'rombel'    => 'A',
                'kapasitas_kls' => 28,
                'tahun_ajaran_id' => null,
                'kurikulum_id' => null,
            ],
            [
                'id' => 5,
                'nama_kelas' => 'Kelas 4',
                'rombel'    => 'A',
                'kapasitas_kls' => 28,
                'tahun_ajaran_id' => null,
                'kurikulum_id' => null,
            ],
            [
                'id' => 6,
                'nama_kelas' => 'Kelas 5',
                'rombel'    => 'A',
                'kapasitas_kls' => 28,
                'tahun_ajaran_id' => null,
                'kurikulum_id' => null,
            ],
        ];

        foreach ($data as $item) {
            Kelas::create($item);
        }
    }
}
