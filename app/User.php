<?php

namespace App;

//use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    //use HasApiTokens, Notifiable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Previous fillable names
        //'name', 'apellido_p', 'apellido_m', 'email', 'password', 'fecha_nac', 'telefono', 'peso', 'estatura', 'n_clases', 'genero', 'expiracion',

        //Actual fillable names
        'name', 'last_name', 'email', 'password', 'date_birth', 'phone', 'weight', 'height', 'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
