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
     */
    public function run(): void
    {
        //
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);

        Permission::create(['name' => 'campi.index']);
        Permission::create(['name' => 'campi.create']);
        Permission::create(['name' => 'campi.show']);
        Permission::create(['name' => 'campi.edit']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'users.index',
            'users.create',
            'users.show',
            'users.edit',
            'users.delete',
            'campi.index',
            'campi.create',
            'campi.show',
            'campi.edit',
        ]);
    }
}
