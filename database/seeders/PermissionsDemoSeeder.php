<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $roleSuperAdmin = Role::create([
                    'name'          => 'superadmin',
                    'display_name'  => 'Super Admin',
            ]);

        // Permission List as array
        $permissions = [

            [
                'group_name' => 'Dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ],
                'display_name' => [
                    'Dashboard View',
                    'Dashboard Edit',
                ]
            ],
            [
                'group_name' => 'User',
                'permissions' => [
                    // user Permissions
                    'user.view',
                    'user.create',
                    'user.edit',
                    'user.delete',
                ],
                'display_name' => [
                    'User View',
                    'User Create',
                    'User Edit',
                    'User Delete',
                ]

            ],

            [
                'group_name' => 'Role',
                'permissions' => [
                    // role Permissions
                    'role.view',
                    'role.create',
                    'role.edit',
                    'role.delete',
                ],
                'display_name' => [
                    'Role View',
                    'Role Create',
                    'Role Edit',
                    'Role Delete',
                ]
            ],

            [
                'group_name' => 'Permission',
                'permissions' => [
                    // role Permissions
                    'permission.view',
                    'permission.create',
                    'permission.edit',
                    'permission.delete',
                ],
                'display_name' => [
                    'Permission View',
                    'Permission Create',
                    'Permission Edit',
                    'Permission Delete',
                ]
            ],
            [
                'group_name' => 'Profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                    'profile.changePassword',
                ],
                'display_name' => [
                    'Profile View',
                    'Profile Edit',
                    'Profile Change Password',
                ]

            ],
        ];


        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create([
                        'name' => $permissions[$i]['permissions'][$j],
                        'display_name'=> $permissions[$i]['display_name'][$j],
                        'group_name' => $permissionGroup
                    ]);
                $roleSuperAdmin->givePermissionTo($permission);
                // $permission->assignRole($roleSuperAdmin);
            }
        }
        // gets all permissions via Gate::before rule; see AuthServiceProvider


        $user = User::create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole($roleSuperAdmin);
    }
}
