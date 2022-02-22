<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'Administer roles & permissions',
            'List users',
            'Create users',
            'Edit users',
            'Delete users',
            'List machines',
            'Create machines',
            'Edit machines',
            'Delete machines',
            'Checkout/Checkin machines',
            'List licenses',
            'Create licenses',
            'Edit licenses',
            'Delete licenses',
            'Install/Uninstall licenses',
            'Administer requests',
            'Administer work orders',
            'Administer settings',
            'View reports',
            'Create requests'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'Asset Manager']);
        $permissions = [
            'List users',
            'List machines',
            'Create machines',
            'Edit machines',
            'Delete machines',
            'Checkout/Checkin machines',
            'List licenses',
            'Create licenses',
            'Edit licenses',
            'Delete licenses',
            'Install/Uninstall licenses',
            'Administer requests',
            'Administer work orders',
            'View reports',
            'Create requests'
        ];
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'IT Support']);
        $permissions = [
            'List users',
            'List machines',
            'Checkout/Checkin machines',
            'List licenses',
            'Install/Uninstall licenses',
            'Administer work orders',
            'Create requests'
        ];
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'User']);
        $permissions = [
            'Create requests'
        ];
        $role->syncPermissions($permissions);
    }
}
