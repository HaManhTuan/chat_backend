<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeCar extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];

    public function car() {
        return $this->hasMany(Car::class);
    }
}
