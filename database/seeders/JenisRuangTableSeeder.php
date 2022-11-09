<?php

namespace Database\Seeders;

use App\Models\Jenisruang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisRuangTableSeeder extends Seeder
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
                'nama_ruang' => 'Ruang Kelas'
            ],
            [
                'id' => 2,
                'nama_ruang' => 'Ruang Kepala'
            ],
            [
                'id' => 3,
                'nama_ruang' => 'Ruang Guru'
            ],
            [
                'id' => 4,
                'nama_ruang' => 'Ruang Tata Usaha'
            ],
            [
                'id' => 5,
                'nama_ruang' => 'Ruang Perpustakaan'
            ],
            [
                'id' => 6,
                'nama_ruang' => 'Ruang UKS'
            ],
            [
                'id' => 7,
                'nama_ruang' => 'Ruang BK'
            ],
            [
                'id' => 8,
                'nama_ruang' => 'Toilet/Kamar Mandi Guru Perempuan'
            ],
            [
                'id' => 9,
                'nama_ruang' => 'Toilet/Kamar Mandi Guru Laki-laki'
            ],
            [
                'id' => 10,
                'nama_ruang' => 'Ruang Laboratorium Komputer'
            ],
            [
                'id' => 11,
                'nama_ruang' => 'Masjid/Mushola'
            ],
            [
                'id' => 12,
                'nama_ruang' => 'Kantin'
            ],
            [
                'id' => 13,
                'nama_ruang' => 'Tempat Parkir'
            ],
            [
                'id' => 14,
                'nama_ruang' => 'Toilet/Kamar Mandi Siswa Perempuan'
            ],
            [
                'id' => 15,
                'nama_ruang' => 'Toilet/Kamar Mandi Siswa Laki-laki'
            ],
            [
                'id' => 16,
                'nama_ruang' => 'Lainnya'
            ],
        ];

        foreach ($data as $item) {
            Jenisruang::create($item);
        }
    }
}
