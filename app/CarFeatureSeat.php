<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarFeatureSeat extends Model
{
    protected $table = 'car_features_seats';
    protected $fillable = ['car_id', 'namess'];
}