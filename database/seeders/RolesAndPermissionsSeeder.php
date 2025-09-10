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
        // reset cached roles and permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // define permission
        $permissions = [
            'view dashboard',
            'manage users',
            'manage positions',
            'manage units',
            'manage master data',

            // PK permission
            'view pk',
            'create pk',
            'approve pk',
            'edit pk',

            // SKP permission
            'view skp',
            'create skp',
            'edit skp',
            'approve skp',
            'submit skp',
            'revert skp',

            // cascading dan evaluation permission
            'manage cascading',
            'fill realization',
            'evaluate skp',
            'view reports',
            'print documents',
        ];

        //buat permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // define role
        $roles = [
            'Rektor' => [
                'view dashboard', 'view pk', 'create pk', 'approve pk', 'edit pk', 'manage cascading', 'view skp', 'view reports', 'print documents' 
            ],
            'Dekan' => [
                'view dashboard', 'view pk', 'create skp', 'edit skp', 'submit skp', 
                'approve skp', 'manage cascading', 'view skp', 'view reports', 'print documents'
            ],
            'Kaprodi' => [
                'view dashboard', 'view pk', 'create skp', 'edit skp', 'submit skp', 
                'approve skp', 'manage cascading', 'view skp', 'view reports', 'print documents'
            ],
            'Dosen' => [
                'view dashboard', 'view skp', 'create skp', 'edit skp', 'submit skp', 
                'fill realization', 'print documents'
            ],
            'Tendik' => [
                'view dashboard', 'view skp', 'create skp', 'edit skp', 'submit skp', 
                'fill realization', 'print documents'
            ],
            'Pejabat Penilai' => [
                'view dashboard', 'view skp', 'approve skp', 'revert skp', 'evaluate skp', 
                'view reports', 'print documents'
            ],
            'Admin' => array_column(Permission::all()->toArray(), 'name'),
        ];

        // buat permission dan assign role ke permission
        foreach ($roles as $roleName => $permissionNames) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($permissionNames);
        }
    }
}