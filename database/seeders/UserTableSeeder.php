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

        $user = User::first();
        $user->name = 'Operator Sekolah';
        $user->email = 'admin@gmail.com';
        $user->username = 'admin';
        $user->save();

        $user->assignRole('admin');
    }
}
