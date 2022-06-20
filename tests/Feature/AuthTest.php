<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\HttpFoundation\Response;


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
            'role_id' => 1
        ];

        $this->post('/api-v1/players/register', $params);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'password' => $user->password,
            'is_admin' => $user->is_admin,
            'role_id' => $user->role_id
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

        $await = [

            "The email must be a valid email address. (and 1 more error)",
            "The password field is required." 
        ];

        $response->assertStatus(405)
        // ->assertJsonFragment($await)
        ;   

    }



     /** @test */
     public function test_login_user()
     {
         $user = User::factory()->make();
 
        //  $this->createAccessClient();
 
        $response = $this->post('/api-v1/players/login', [
             'email' => $user->email,
             'password' => $user->password,
             'is_admin' => $user->is_admin,
             'role_id' => $user->role_id
         ]);
 
         $hasUser = $user ? true : false;

         $this->assertTrue($hasUser);
 
         $response = $this->actingAs($user)->get('/home');
 
         $response->assertStatus(200);
         
        //  $user = User::where('is_admin', '=', 1)->first();
        //  $this->actingAs($user)
        // ; 
 
        //  var_dump($response);
 
        //  $response->assertStatus(200);

        //  $response->assertJsonStructure([
        //      'user' => [
        //          'created_at',
        //          'updated_at',
        //          'email',
        //          'id',
        //          'is_admin',
        //          'nickname'
        //      ],
        //      'access_token'
        //  ]);
     }


     /** @test */
    // public function a_visitor_can_able_to_login()
    // {
    //     $user = factory('App\User')->create();

    //     $hasUser = $user ? true : false;

    //     $this->assertTrue($hasUser);

    //     $response = $this->actingAs($user)->get('/home');

    //     $response->assertStatus(200);
    // }

    /** @test */
    public function test_user_can_login_correctly() 
    {
        
         User::factory()->make();

        $params = [
            'email' => 'juanca@gmail.com',
            'password' => '12345678',
        ];

        // $this->post('/api-v1/players/login', $params); 

        // $this->post(route('register'), [
        //     'email' => $user->email,
        //     'password' => $user->password
        // ]);
    
        $response =  $this->post( '/api-v1/players/login', $params);

        $response->assertStatus(Response::HTTP_OK)
             ->assertJsonStructure(
                 [
                    'user' => [
                        'email',
                        'password',
                    ]
                 ]
            );
    }
    


    
}
