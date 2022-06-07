<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'active',
        'car_number',
        'type',
        'category',
        'owner_id',
        'zip',
        'country',
        'state',
        'image',
    
    ];
     
    protected $table="cars";

    public function User(){
        return $this->belongsto(User::class);
    }

    


}
