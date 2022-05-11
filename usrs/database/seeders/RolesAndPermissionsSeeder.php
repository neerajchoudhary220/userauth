<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = [
            'create', 'edit', 'view', 'delete'
        ];

        //Creating permission
        foreach ($permission as $p) {
            Permission::create(['name' => $p]);
        }
        //Creating roles and giving permission_______________________________________________
        //all permission given to admin
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

        //Manage have two permission edit and view
        $manager = Role::create(['name' => 'Manager']);
        $manager->givePermissionTo(['create', 'edit', 'view']);

        //Normal user have only one permission only view
        $normal_usr = Role::create(['name' => 'Normal User']);
        $normal_usr->givePermissionTo(['view']);
    }
}
