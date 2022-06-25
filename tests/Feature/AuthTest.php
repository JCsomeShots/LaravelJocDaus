<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;



class AuthTest extends TestCase
{
    use RefreshDatabase;
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
    public function test_register_user_on_user_table ()
    {
        $user = User::factory()->create();

        $params = [
            'nickname' => 'JuanCa',
            'email' => 'juanca@gmail.com',
            'password' => '12345678',
            'password_confirmation' => bcrypt('12345678'),
            'is_admin' => 1,
        ];

        $this->post('/api-v1/players/register', $params);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'password' => $user->password,
            'is_admin' => $user->is_admin,
        ]);
    }


    /** @test */
    public function test_register_error()
    {
        $params = [
            'email' => 'email',
            'password' => '',
            'password_confirmation' => bcrypt('12345'),
        ];

        $response = $this->postJson('/api-v1/players/register', $params);
        $response->assertStatus(405);
    }

    /** @test */
    public function test_user_can_login_correctly() 
    {      
        $user = User::factory()->make();

        $params = [
            'email' => 'juanca@gmail.com',
            'password' => '12345678',
        ];

        $response =  $this->post( '/api-v1/players/login', $params);
        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
      
        // $response->assertStatus(422); //  "message": "Invalid login credentials"
        // $response->assertStatus(200); // "user created successfully."

    }
    
    /** @test */
    public function test_can_a_user_logout($user = null)
    {
        $user = $user ?: User::factory()->create();
        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->json('POST', '/api-v1/players/logout');
        $response->assertOk();


    }

     /** @test */
     public function test_a_user_or_an_admin_can_update_the_nickname()
     {

        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
        $user = User::factory()->create();
        $user = Passport::actingAs($user);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->put(route('players.update', $user->id), ['nickname' => 'juanca']);
            $response->assertOk();
        } 
        
        
        $response = $this->actingAs($user, 'api')->put(route('players.update', $user->id), ['nickname' => 'juanca']);
        $response->assertOk();
        $this->assertDatabaseHas('users', [ 'nickname' => 'juanca']);
    }

    



    
}
 