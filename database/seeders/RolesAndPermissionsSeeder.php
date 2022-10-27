<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'tambah users']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $RoleAdmin = Role::create(['name' => 'admin']);
        $RoleSiswa = Role::create(['name' => 'siswa']);
        $RoleGuru = Role::create(['name' => 'guru']);
        $RoleKepalaSekolah = Role::create(['name' => 'kepala sekolah']);

        $RoleAdmin->givePermissionTo(Permission::all());
        $RoleKepalaSekolah->givePermissionTo('tambah users');
    }
}
