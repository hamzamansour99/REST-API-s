<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'chat_message',
        'chat_id',
        'date',
        'time',
    ];

    public function User(){
        return $this->belongsto(User::class);
    }

}
