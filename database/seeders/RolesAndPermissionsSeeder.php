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
        Permission::create(['name' => 'guardhouses.create']);
        Permission::create(['name' => 'guardhouses.edit']);

        Permission::create(['name' => 'keys.index']);
        Permission::create(['name' => 'keys.create']);
        Permission::create(['name' => 'keys.show']);
        Permission::create(['name' => 'keys.edit']);

        Permission::create(['name' => 'keyauthorizations.index']);
        Permission::create(['name' => 'keyauthorizations.create']);
        Permission::create(['name' => 'keyauthorizations.show']);
        Permission::create(['name' => 'keyauthorizations.edit']);

        Permission::create(['name' => 'coordinatorkeys.index']);
        Permission::create(['name' => 'coordinatorkeys.create']);
        Permission::create(['name' => 'coordinatorkeys.show']);
        Permission::create(['name' => 'coordinatorkeys.edit']);

        Permission::create(['name' => 'loans.index']);
        Permission::create(['name' => 'loans.create']);
        Permission::create(['name' => 'loans.show']);
        Permission::create(['name' => 'loans.edit']);

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
            'guardhouses.create',
            'guardhouses.edit',
            'keys.index',
            'keys.create',
            'keys.show',
            'keys.edit',
            'keyauthorizations.index',
            'keyauthorizations.create',
            'keyauthorizations.show',
            'keyauthorizations.edit',
            'coordinatorkeys.index',
            'coordinatorkeys.create',
            'coordinatorkeys.show',
            'coordinatorkeys.edit',
            'loans.index',
            'loans.create',
            'loans.show',
            'loans.edit',
        ]);

        $user = User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }

        $coordenadorRole = Role::create(['name' => 'Coordenador']);
        $coordenadorRole->givePermissionTo([
            'keyauthorizations.index',
            'keyauthorizations.create',
            'keyauthorizations.show',
            'keyauthorizations.edit',
        ]);
        $coordenadorUser = User::find(2);
        if ($coordenadorUser) {
            $coordenadorUser->assignRole('Coordenador');
        }
        $coordenadorUser = User::find(3);
        if ($coordenadorUser) {
            $coordenadorUser->assignRole('Coordenador');
        }

        $discenteRole = Role::create(['name' => 'Discente']);
        $discenteRole->givePermissionTo([]);
        $discenteUser = User::find(4);
        if ($discenteUser) {
            $discenteUser->assignRole('Discente');
        }
        $discenteUser = User::find(5);
        if ($discenteUser) {
            $discenteUser->assignRole('Discente');
        }
        $discenteUser = User::find(6);
        if ($discenteUser) {
            $discenteUser->assignRole('Discente');
        }
        $discenteUser = User::find(7);
        if ($discenteUser) {
            $discenteUser->assignRole('Discente');
        }

        $guardaRole   = Role::create(['name' => 'Guarda']);
        $guardaRole->givePermissionTo([
            'loans.index',
            'loans.create',
            'loans.show',
            'loans.edit',
        ]);
        $guardaUser = User::find(8);
        if ($guardaUser) {
            $guardaUser->assignRole('Guarda');
        }
        $guardaUser = user::find(8);
        if ($guardaUser) {
            $guardaUser->assignRole('Guarda');
        }

    }
}
