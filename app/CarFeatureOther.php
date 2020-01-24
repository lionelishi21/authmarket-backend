<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarFeatureOther extends Model
{
    protected $table = 'car_features_others';
    protected $fillable = ['car_id', 'name'];
}
