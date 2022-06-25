<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nickname' => 'JuanCa',
            'email' => 'juanca@gmail.com',
            'password' => bcrypt('12345678'),
            'is_admin' => 1,
            'role_id' => 1
        ]);
        
        User::create([
            'nickname' => 'Rubén',
            'email' => 'ruben@gmail.com',
            'password' => bcrypt('12345678'),
            'is_admin' => 1,
            'role_id' => 1
        ]);
    }
}
