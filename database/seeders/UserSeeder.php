<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 =  User::create([
            'nickname' => 'JuanCa',
            'email' => 'juanca@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $user2 =  User::create([
            'nickname' => 'Rubén',
            'email' => 'ruben@gmail.com',
            'password' => bcrypt('12345678')
        ]);


        $user1->assignRole('admin');
        $user2->assignRole('admin');


        User::factory(10)->create();
    }
}
