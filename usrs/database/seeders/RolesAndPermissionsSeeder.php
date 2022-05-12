<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function GuzzleHttp\Promise\all;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $permission = [
            'create', 'edit', 'view', 'delete'
        ];

        //Creating permission
        foreach ($permission as $p) {
            Permission::updateOrCreate(['name' => $p]);
        }
        //Creating roles and giving permission_______________________________________________

        //Admin
        $admin = Role::updateOrCreate(['name' => 'Admin']); //creating admin role
        $admin->givePermissionTo(Permission::all()); //giving all permission

        //Manager
        $manager = Role::updateOrCreate(['name' => 'Manager']); //creating manager role
        $manager->givePermissionTo(['create', 'edit', 'view']); //giving permission

        //Normal user
        $normal_usr = Role::updateOrCreate(['name' => 'Normal User']); //creating normal user role
        $normal_usr->givePermissionTo(['view']); //giving view permmission only


    }
}
