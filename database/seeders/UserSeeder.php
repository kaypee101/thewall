<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(5)->create();
        $role = Role::where(['name' => User::USER])->first();
        if ($role) {
            foreach ($users as $key => $user) {
                $user->assignRole($role->name);
            }
        }
    }
}
