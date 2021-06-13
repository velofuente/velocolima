<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\MyResetPassword;
use App\Purchase;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable;
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'birth_date', 'phone', 'gender', 'shoe_size', 'role_id', 'id_cart', 'share_code','customer_id','conekta_token_user_id'//'weight', 'height',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }
    public function purchase(){
        return $this->hasMany(Purchase::class, 'user_id', 'id');
    }

    public function cards(){
        return $this->hasMany(Card::class);
    }
}