<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =\App\User::insert([
            'name' => 'root',
            'email' => 'root@sample.com',
            'password' => \Hash::make('123456'),
            'user_type'=>'root',
            'status'=> "active"
        ]);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionlist =\App\System::GetAllRouteNameListWithPrefix('Sales');
        $role = Role::create(['name' => 'root']);

        foreach ($permissionlist as $permission)
        Permission::findOrCreate($permission);

        $role = Role::findByName('root');
        $user = \App\User::where('name','root')->first();
        $role->givePermissionTo(Permission::all());
        $user->assignRole($role->name);
        $user->givePermissionTo(Permission::all());

    }
}
