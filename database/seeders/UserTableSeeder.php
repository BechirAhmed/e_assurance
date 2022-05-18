<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'first_name'           => 'Super',
                'last_name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'phone_number'   => '21212121',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);

        $role = Role::firstOrCreate(['title' => 'Admin']);
        $role->permissions()->sync(Permission::all());

        $user = User::first();
        $user->roles()->sync($role->id);
    }
}
