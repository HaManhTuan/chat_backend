<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type_car_id', 'license_plates', 'color', 'seat'];

    public function typeCar() {
        return $this->belongsTo(TypeCar::class);
    }
}
