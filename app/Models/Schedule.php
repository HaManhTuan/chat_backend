<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['trip_id', 'from', 'to', 'date'];

    public function trips() {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
