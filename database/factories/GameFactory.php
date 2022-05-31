<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dado1 = rand(1 , 6);
        $dado2 = rand(1 , 6);
        ($dado1 + $dado2 === 7) ? $result = Game::youWin : $result = Game::youLost;



        return [
            'dado1' => $dado1,
            'dado2' => $dado2,
            'result' => $result,
            'user_id' => User::all()->random()->id
        ];
    }
}
