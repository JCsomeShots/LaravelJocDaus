<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $index_players = Permission::create(['name' => 'index players']);
        $average_players = Permission::create(['name' => 'average players']);
        $average_list = Permission::create(['name' => 'average list']);
        $ranking = Permission::create(['name' => 'ranking']);
       
        $admin->syncPermissions([
            $index_players, 
            $average_players, 
            $average_list, 
            $ranking
        ]);
        // $permission->syncRoles($roles);
    }
}
