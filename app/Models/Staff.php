<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'gender',
        'birthday',
        'avatar',
        'phone',
        'address',
        'description',
    ];

    const STAFF_IS_ACTIVE = [
        'OFFLINE' => 0,
        'ONLINE' => 1
    ];
}
