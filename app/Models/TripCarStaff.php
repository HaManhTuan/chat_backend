<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripCarStaff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'staff_id', 'trip_id', 'car_id', 'assistant_driver_id', 'datetime', 'schedule_id', 'type_car_id'];

    public function staff() {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function assistant() {
        return $this->belongsTo(Staff::class, 'assistant_driver_id');
    }

    public function trip() {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function car() {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function seat() {
        return $this->hasMany(Seat::class, 'trip_car_staff_id', 'id');
    }
}
