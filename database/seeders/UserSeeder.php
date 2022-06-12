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
        User::create([
            'nickname' => 'juanca',
            'email' => 'juanca@gmail.com',
            'password' => bcrypt('12345678'),
            'is_admin' => 1
        ]);

        User::factory(3)->create();
    }
}
