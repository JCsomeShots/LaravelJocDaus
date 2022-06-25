<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;


class GameTest extends TestCase
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
    public function test_a_user_or_an_admin_can_throw_the_dices()
    {

        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
        $user = User::factory()->create();
        $user = Passport::actingAs($user);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->post(route('games.store', $user->id));
            $response->assertOk();
        } 

        $response = $this->actingAs($user, 'api')->post(route('games.store', $user->id));
        $response->assertOk();
    
    }
   
    /** @test */
    public function test_a_user_or_an_admin_can_show_a_user_behavior()
    {

        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
        $user = User::factory()->create();
        $user = Passport::actingAs($user);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->get(route('games.show', $user->id));
            $response->assertOk();
        } 

        $response = $this->actingAs($user, 'api')->get(route('games.show', $user->id));
        $response->assertOk();
    
    }
    
    /** @test */
    public function test_a_user_or_an_admin_can_delete_a_user_behavior()
    {

        $admin = User::factory()->create(['is_admin' => 1 ]);
        $admin = Passport::actingAs($admin);
        $user = User::factory()->create();
        $user = Passport::actingAs($user);
       
        if ($admin['is_admin'] === 1) {
            $response = $this->actingAs($admin, 'api')->delete(route('games.delete', $user->id));
            $response->assertOk();
        } 

        $response = $this->actingAs($user, 'api')->delete(route('games.delete', $user->id));
        $response->assertOk();
    
    }
}
