<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerCarPooling extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id',
        'car_capacity',
        'required_date',
        'required_time',
        'comment',
        'smoking',
        'ac',
        'only_girls',
        'current_longitude',
        'current_latitude',
        'destination_longitude',
        'destination_latitude',
    ];

    public function User(){
        return $this->belongsto(User::class);
    }

}
