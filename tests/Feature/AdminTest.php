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
        $menj = "eres admin y puedes acceder a esta ruta";
        $menj2 = "No eres admin";
        
        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players/index');
            var_dump($menj);
            $response->assertStatus(201);
        } else {
            var_dump($menj2);
        }
    }

    public function test_average_list_game_can_be_retraived()
    {
        $this->withoutExceptionHandling();
        $menj = "eres admin y puedes acceder a esta ruta";
        $menj2 = "No eres admin";
        
        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players');
            var_dump($menj);
            $response->assertStatus(200);
        } else {
            var_dump($menj2);
        }
    }
    public function test_average_list_player_inArray_can_be_retraived()
    {
        $this->withoutExceptionHandling();
        $menj = "eres admin y puedes acceder a esta ruta";
        $menj2 = "No eres admin";
        
        //Datos de prueba
        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->json('GET', '/api-v1/players/average');
            var_dump($menj);
            $response->assertStatus(200);
        } else {
            var_dump($menj2);
        }
    }
}
