<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /** @test */
    public function register_user_on_user_table()
    {
        $user = User::factory()->create();
        $this->withoutExceptionHandling()->post(route('register'), [
            'email' => $user->email,
            'password' => $user->password
        ]
        // , 
        // ['Accept' => 'application/json']
    );

        // $this->assertDatabaseHas('users', [
        //     'email' => $user->email
        // ]);

       

        $response->assertOk(); 
    }
}
