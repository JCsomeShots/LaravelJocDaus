<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use Illuminate\Support\Facades\DB;



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
    public function can_a_user_logout($user = null)
    {
        $user = $user ?: User::factory()->create();
        $this->actingAs($user);

        $response = $this->actingAs($user)->post('/api-v1/players/logout');
        // $response->assertOk();
        $response->assertStatus(302); // espera una redirección. nos llevaría a un guest page o a un login page
        // $response->assertJsonFragment(["message" => "You have successfully logout"]);


    }

    /** @test */
    // public function list_can_be_retraived()
    // {
    //     $this->withoutExceptionHandling();

    //     //Datos de prueba
    //     $admin = User::factory(5)->create();
    //     $admin = Passport::actingAs($admin, ['administrate']);

    //     //Método HTTP 
    //     $response = $this->get('/api-v1/players/index');
    //     $response->assertOk();

    //     $user = User::all();

    // }



    
}
 