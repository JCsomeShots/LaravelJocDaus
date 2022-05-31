<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Game;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('user_id')->rconstrained()->onDelete('cascade');
            $table->tinyInteger('dado1');
            $table->tinyInteger('dado2');
            $table->enum('result' , [Game::youWin , Game::youLost])->default(Game::youLost);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game');
    }
};
