<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuanganTableSeeder extends Seeder
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
                'jenis_ruang_id' => 1,
                'nama_ruangan' => 'Kelas 1',
                'penggunaan_ruangan' => 1,
                'tahun_dibangun' => '2021-01-11',
                'panjang_ruangan' => 7,
                'lebar_ruangan' => 8,
            ],
            [
                'id' => 2,
                'jenis_ruang_id' => 1,
                'nama_ruangan' => 'Kelas 2',
                'penggunaan_ruangan' => 1,
                'tahun_dibangun' => '2021-01-11',
                'panjang_ruangan' => 7,
                'lebar_ruangan' => 8,
            ],
            [
                'id' => 3,
                'jenis_ruang_id' => 2,
                'nama_ruangan' => 'Ruang Kepala Sekolah',
                'penggunaan_ruangan' => 0,
                'tahun_dibangun' => '2021-01-11',
                'panjang_ruangan' => 7,
                'lebar_ruangan' => 8,
            ],
            [
                'id' => 4,
                'jenis_ruang_id' => 3,
                'nama_ruangan' => 'Ruang Guru',
                'penggunaan_ruangan' => 0,
                'tahun_dibangun' => '2021-01-11',
                'panjang_ruangan' => 7,
                'lebar_ruangan' => 8,
            ],
        ];

        foreach ($data as $value) {
            Ruangan::create($value);
        }
    }
}
