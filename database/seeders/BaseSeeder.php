<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);

        $manageRentsPermission = Permission::create(['name' => 'manage_rents']);
        $manageUsersPermission = Permission::create(['name' => 'manage_users']);
        $manageRolesPermission = Permission::create(['name' => 'manage_roles']);
        $managePermissionsPermission = Permission::create(['name' => 'manage_permissions']);
        $managePropertiesPermission = Permission::create(['name' => 'manage_properties']);
        
        $adminRole->givePermissionTo($manageRentsPermission);
        $adminRole->givePermissionTo($manageUsersPermission);
        $adminRole->givePermissionTo($manageRolesPermission);
        $adminRole->givePermissionTo($managePermissionsPermission);
        $adminRole->givePermissionTo($managePropertiesPermission);
        
        $sellerRole = Role::create(['name' => 'seller']);
        $renterRole = Role::create(['name' => 'renter']);

        $seeRentsPermission = Permission::create(['name' => 'see_my_rents']);
        
        $sellerRole->givePermissionTo($seeRentsPermission);
        $renterRole->givePermissionTo($seeRentsPermission);

        $adminExists = User::where('email', 'superadmin@gmail.com')->first();
        if(!$adminExists){
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password')
            ]);
            $adminUser->assignRole('admin');
        }

    }
}
