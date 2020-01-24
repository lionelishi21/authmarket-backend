<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarFeatureSafety extends Model
{
    protected $table = 'car_features_safety';
    protected $fillable = ['car_id', 'name'];
}
