<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCarPooling extends Model
{
    use HasFactory;
    protected $fillable = [
        'seats',
        'required_date',
        'required_time',
        'comment',
        'current_longitude',
        'current_latitude',
        'destination_longitude',
        'destination_latitude',
    ];

    public function User(){
        return $this->belongsto(User::class);
    }
}
