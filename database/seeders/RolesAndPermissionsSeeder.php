<?php

namespace Database\Seeders;

use App\Models\User;
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

        Permission::create(['name' => 'campuses.index']);
        Permission::create(['name' => 'campuses.create']);
        Permission::create(['name' => 'campuses.show']);
        Permission::create(['name' => 'campuses.edit']);

        Permission::create(['name' => 'guardhouses.index']);
        Permission::create(['name' => 'guardhouses.show']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'users.index',
            'users.create',
            'users.show',
            'users.edit',
            'users.delete',
            'campuses.index',
            'campuses.create',
            'campuses.show',
            'campuses.edit',
            'guardhouses.index',
            'guardhouses.show',
        ]);

        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
