<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class PlayerTest extends TestCase
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
    public function test_list_can_be_retraived()
    {
        $this->withoutExceptionHandling();

        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players/index');
            $response->assertStatus(201);
        } 
    }

    /** @test */
    public function test_average_list_game_can_be_retraived()
    {
        $this->withoutExceptionHandling();
        
        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players');
            $response->assertStatus(200);
        } 
    }

    /** @test */
    public function test_ranking_list_can_be_retraived()
    {
        $this->withoutExceptionHandling();
       
        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players/ranking');
            $response->assertStatus(200);
        } 
    }
    
    /** @test */
    public function test_ranking_winner_be_retraived()
    {
        $this->withoutExceptionHandling();
        $menj = "eres admin y puedes acceder a esta ruta";
        
        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players/ranking/winner');
            $response->assertStatus(200);
        }
    }
   
    /** @test */
    public function test_ranking_loser_be_retraived()
    {
        $this->withoutExceptionHandling();
        $menj = "eres admin y puedes acceder a esta ruta";
        
        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            // var_dump($menj);
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players/ranking/loser');
            $response->assertStatus(200);
        } 
    }

    /** @test */
    public function test_an_admin_can_update_a_user_to_admin()
    {

        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
        $user = User::factory()->create();
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->put(route('admin.update', $user->id), ['is_admin' => '1']);
            $response->assertOk();
        } 
    
    }








    //*** With out authentification */
    /** @test */
    public function test_index_without_authentification()
    {
        $response = $this->get('/api-v1/players/index', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }
    
    /** @test */
    public function test_average_without_authentification()
    {
        $response = $this->get('/api-v1/players', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }
    
    /** @test */
    public function test_ranking_wihtout_authentification()
    {
        $response = $this->get('/api-v1/players/ranking', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }
    
    /** @test */
    public function test_ranking_winner_without_authentification()
    {
        $response = $this->get('/api-v1/players/ranking/winner', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }
    
    /** @test */
    public function test_ranking_loser_without_authentification()
    {
        $response = $this->get('/api-v1/players/ranking/loser', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }







    /*** Extra function = return an array */
    /** @test */
    // public function test_average_list_player_inArray_can_be_retraived()
    // {
    //     $this->withoutExceptionHandling();
    //     $menj = "eres admin y puedes acceder a esta ruta";
    //     $menj2 = "No eres admin";
        
    //     //Datos de prueba
    //     $admin = User::factory()->create(['is_admin' => 1 ]);
    //     $admin = Passport::actingAs($admin);
       
    //     if ($admin['is_admin'] === 1) {
    //         $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players/average');
    //         // var_dump($menj);
    //         $response->assertStatus(200);
    //     } else {
    //         var_dump($menj2);
    //     }
    // }
}
