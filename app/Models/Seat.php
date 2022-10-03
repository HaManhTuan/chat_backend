<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    const SEAT_IS_ACTIVE = [
        'DE_ACTIVE' => 0,
        'ACTIVE' => 1
    ];

    protected $fillable = ['trip_car_staff_id', 'seat_id', 'status', 'customer_id'];
}
