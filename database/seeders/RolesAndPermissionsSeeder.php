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

        // create permissions Permission
        Permission::create(['name' => 'permission_create']);
        Permission::create(['name' => 'permission_edit']);
        Permission::create(['name' => 'permission_show']);
        Permission::create(['name' => 'permission_delete']);
        Permission::create(['name' => 'permission_access']); // submenu

        // create permissions Role
        Permission::create(['name' => 'role_create']);
        Permission::create(['name' => 'role_edit']);
        Permission::create(['name' => 'role_show']);
        Permission::create(['name' => 'role_delete']);
        Permission::create(['name' => 'role_access']); // submenu

        // create permissions Users
        Permission::create(['name' => 'user_management_access']); // menu utama
        Permission::create(['name' => 'user_create']);
        Permission::create(['name' => 'user_edit']);
        Permission::create(['name' => 'user_show']);
        Permission::create(['name' => 'user_delete']);
        Permission::create(['name' => 'user_access']); // index // submenu

        // create roles and assign created permissions

        // this can be done as separate statements
        $RoleAdmin = Role::create(['name' => 'admin']);
        $RoleSiswa = Role::create(['name' => 'siswa']);
        $RoleGuru = Role::create(['name' => 'guru']);
        $RoleKepalaSekolah = Role::create(['name' => 'kepala sekolah']);

        $RoleAdmin->givePermissionTo(Permission::all());
        $RoleKepalaSekolah->givePermissionTo([
            'user_management_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access'
        ]);
    }
}
