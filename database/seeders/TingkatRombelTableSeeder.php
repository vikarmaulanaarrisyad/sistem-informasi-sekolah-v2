<?php

namespace Database\Seeders;

use App\Models\TingkatRombel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TingkatRombelTableSeeder extends Seeder
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
                'name' => 'I'
            ],
            [
                'id' => 2,
                'name' => 'II'
            ],
            [
                'id' => 3,
                'name' => 'III'
            ],
            [
                'id' => 4,
                'name' => 'IV'
            ],
            [
                'id' => 5,
                'name' => 'V'
            ],
            [
                'id' => 6,
                'name' => 'VI'
            ],
        ];

        foreach ($data as  $value) {
            TingkatRombel::create($value);
        }
    }
}
