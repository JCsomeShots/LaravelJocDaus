<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    const youWin = 1;
    const youLost = 2;

    protected $fillable = [
        'dado1',
        'dado2',
        'result',
        'user_id'
    ];

    public function user (){
        return $this->belongsTo(User::class);
    }
}
