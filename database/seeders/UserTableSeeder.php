<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create();

        $userAdmin = User::first();
        $userAdmin->name = 'Operator Sekolah';
        $userAdmin->email = 'admin@gmail.com';
        $userAdmin->username = 'admin';
        $userAdmin->save();

        $userKepalaSekolah = User::find(2);
        $userKepalaSekolah->name = 'Kurniati';
        $userKepalaSekolah->username = 'kurniati';
        $userKepalaSekolah->email = 'kurniati@gmail.com';

        $userKepalaSekolah->save();

        $userGuru = User::find(3);
        $userGuru->name = 'Vikar Maulana Arrisyad';
        $userGuru->email = 'vikar@gmail.com';
        $userGuru->username = 'vikar';

        $userGuru->save();

        $userSiswa = User::find(4);
        $userSiswa->name = 'Emi Fatikha';
        $userSiswa->email = 'emifatikha@gmail.com';
        $userSiswa->username = 'emi';

        $userSiswa->save();


        $userAdmin->assignRole('admin');
        $userKepalaSekolah->assignRole('kepala sekolah');
        $userGuru->assignRole('guru');
        $userSiswa->assignRole('siswa');
    }
}
