<?php
 
namespace App\Models;
 
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
 
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //   protected $primaryKey = 'key';
    //   public $incrementing = false;
    //   protected $keyType = 'string';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'password',
        'community_type',
        'community_name',
        'image'
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
 
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Car(){
        return $this->hasMany(Car::class);
    }

    public function OwnerCarPooling(){
        return $this->hasMany(OwnerCarPooling::class);
    }

    public function UserCarPooling(){
        return $this->hasMany(UserCarPooling::class);
    }

    public function message(){
        return $this->hasMany(message::class);
    }



    
}