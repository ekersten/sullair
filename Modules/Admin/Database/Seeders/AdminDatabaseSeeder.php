<?php

namespace Modules\Admin\Database\Seeders;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $credentials = [
            'first_name' => 'Super',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ];

        $user = Sentinel::registerAndActivate($credentials);

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Superadmin',
            'slug' => 'superadmin',
        ]);


        $role->permissions = [
            'admin.browse' => 'true',

            'users.create' => 'true',
            'users.read' => 'true',
            'users.update' => 'true',
            'users.destroy' => 'true',

            'roles.create' => 'true',
            'roles.read' => 'true',
            'roles.update' => 'true',
            'roles.destroy' => 'true'
        ];

        $role->users()->attach($user);

        $role->save();

        // $this->call("OthersTableSeeder");
    }
}
