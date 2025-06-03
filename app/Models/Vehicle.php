<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'license_plate',
        'brand',
        'model',
        'color',
        'student_name',
        'student_id',
        'vehicle_type',
    ];
} 