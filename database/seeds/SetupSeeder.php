<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Permission;
use App\Role;
use YoHang88\LetterAvatar\LetterAvatar;
use Illuminate\Support\Facades\DB;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "user-" . uniqid() . ".png";
        $avatar = new LetterAvatar('Dev', 'square', 250);
        $avatar->saveAs(storage_path('app') . path() . media_path() . path() . config('starter.path.images') . path() . $filename, "image/png");

    	$user = User::create([
    		'name' => 'Dev',
    		'email' => 'dev@starterkit.io',
    		'password' => bcrypt('123456'),
            'visible' => 0,
            'picture' => $filename
    	]);

        $role = new Role();
        $role->name = 'developer';
        $role->display_name = 'Developer';
        $role->save();

        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id
        ]);

        $permission = [
            [
                'name' => 'setting_list',
                'display_name' => 'List setting',
                'description' => 'Access settings page'
            ],
            [
                'name' => 'setting_edit',
                'display_name' => 'Edit setting',
                'description' => 'Change settings'
            ],
            // Users
            [
                'name' => 'user_list',
                'display_name' => 'List user',
                'description' => 'See a list of all user accounts'
            ],
            [
                'name' => 'user_create',
                'display_name' => 'Create user',
                'description' => 'Create new user account'
            ],
            [
                'name' => 'user_edit',
                'display_name' => 'Edit user',
                'description' => 'Edit all user accounts'
            ],
            [
                'name' => 'user_just_edit_itself',
                'display_name' => 'Just Edit Itself',
                'description' => 'Just edit their own account, don\'t check the `Edit user` permissions if using this'
            ],
            [
                'name' => 'user_delete',
                'display_name' => 'Delete user',
                'description' => 'Delete all user accounts'
            ],
            // Roles
            [
                'name' => 'role_list',
                'display_name' => 'List role',
                'description' => 'See a list of all roles'
            ],
            [
                'name' => 'role_create',
                'display_name' => 'Create role',
                'description' => 'Create new role'
            ],
            [
                'name' => 'role_edit',
                'display_name' => 'Edit role',
                'description' => 'Edit all roles'
            ],
            [
                'name' => 'role_delete',
                'display_name' => 'Delete role',
                'description' => 'Delete all roles'
            ],
            // Dev zone
            [
                'name' => 'dev_setting_group_list',
                'display_name' => 'List setting group',
                'description' => 'Create new setting group'
            ],
            [
                'name' => 'dev_setting_group_edit',
                'display_name' => 'Edit setting group',
                'description' => 'Edit all settings groups'
            ],
            [
                'name' => 'dev_setting_group_create',
                'display_name' => 'Create setting group',
                'description' => 'Create new setting group'
            ],
            [
                'name' => 'dev_setting_group_delete',
                'display_name' => 'Delete setting group',
                'description' => 'Delete all settings groups'
            ],
            // Setting items
            [
                'name' => 'dev_setting_item_list',
                'display_name' => 'List setting item',
                'description' => 'Create new setting item'
            ],
            [
                'name' => 'dev_setting_item_edit',
                'display_name' => 'Edit setting item',
                'description' => 'Edit all settings items'
            ],
            [
                'name' => 'dev_setting_item_create',
                'display_name' => 'Create setting item',
                'description' => 'Create new setting item'
            ],
            [
                'name' => 'dev_setting_item_delete',
                'display_name' => 'Delete setting item',
                'description' => 'Delete all settings items'
            ],
            // Modules
            [
                'name' => 'dev_module_list',
                'display_name' => 'List module',
                'description' => 'Create new module'
            ],
            [
                'name' => 'dev_module_edit',
                'display_name' => 'Edit module',
                'description' => 'Edit all modules'
            ],
            [
                'name' => 'dev_module_create',
                'display_name' => 'Create module',
                'description' => 'Create new module'
            ],
            [
                'name' => 'dev_module_delete',
                'display_name' => 'Delete module',
                'description' => 'Delete all modules'
            ],
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }

        $perms = [];
        foreach(Permission::all() as $perm) {
            if($perm->name !== 'user_just_edit_itself') {
                $perms[] = $perm->id;
            }
        }

        $role->perms()->sync($perms);
    }
}
