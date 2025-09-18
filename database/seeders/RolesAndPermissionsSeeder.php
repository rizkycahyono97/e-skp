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
            'show',
            'buat',
            'edit',
            'submit',
            'approve',
            'manage',
            'fill',
            'revert',
            'evaluate',
            'print',
        ];

        //buat permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // define role
        $roles = [
            'Admin' => [
                'show', 'buat', 'approve', 'edit', 'manage', 'print', 'submit', 'fill', 'revert', 'evaluate'
            ],
            'Rektor' => [
                'show', 'buat', 'approve', 'edit', 'manage', 'print'
            ],
            'Dekan' => [
                'show', 'buat', 'edit', 'submit', 'approve', 'manage', 'print'
            ],
            'Kaprodi' => [
                'show', 'buat', 'edit', 'submit', 'approve', 'manage', 'print'
            ],
            'Dosen' => [
                'show', 'buat', 'edit', 'submit', 'fill', 'print'
            ],
            'Tendik' => [
                'show', 'buat', 'edit', 'submit', 'fill', 'print'
            ],
            'Pejabat Penilai' => [
                'show', 'approve', 'revert', 'evaluate', 'print'
            ],
            'Super Admin' => array_column(Permission::all()->toArray(), 'name'), // full akses untuk admin
        ];


        // buat permission dan assign role ke permission
        foreach ($roles as $roleName => $permissionNames) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($permissionNames);
        }
    }
}