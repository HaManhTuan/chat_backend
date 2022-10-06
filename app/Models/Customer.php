<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    const CUSTOMER_IS_ACTIVE = [
        'DE_ACTIVE' => 0,
        'ACTIVE' => 1
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'old',
        'phone',
        'address',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($pass){

        $this->attributes['password'] = Hash::make($pass);

    }
}
