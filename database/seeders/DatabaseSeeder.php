<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Jenisruang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserTableSeeder::class,
            InstansiTableSeeder::class,
            TahunAjaranTableSeeder::class,
            KurikulumTableSeeder::class,
            JenisRuangTableSeeder::class,
            RuanganTableSeeder::class,
            KelasTableSeeder::class,
        ]);
    }
}
