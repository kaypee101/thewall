<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userPermissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
        ];
        $permissions = array_merge($userPermissions);

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => User::ADMIN]);
        $adminRole->syncPermissions($permissions);

        $userRole = Role::create(['name' => User::USER]);
        $userRole->syncPermissions(['name' => 'user-list']);
    }
}
