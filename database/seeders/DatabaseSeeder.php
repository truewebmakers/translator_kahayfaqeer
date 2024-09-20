<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->PermissionSeeder();
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'email_verified_at' =>now()
        ]);

        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
        $roles = [
            'proof_reader',
            'editor'
        ];
        foreach ($roles as $role) {
            $r = Role::create(['name' => $role]);
            $permissions = Permission::pluck('id','id')->all();

            $r->syncPermissions($permissions);

            $user->assignRole([$r->id]);
        }

    }

    public function PermissionSeeder(){
        $permissions = [
            'create_book_sentence',
            'read_book_sentence',
            'update_book_sentence',
            'delete_book_sentence',
            'create_comment',
            'read_comment',
            'update_comment',
            'delete_comment',
            'create_user',
            'read_user',
            'update_user',
            'delete_user',
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}


