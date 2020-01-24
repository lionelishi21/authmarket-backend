<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarFeatureEntertainment extends Model
{
    protected $table = 'car_features_entertainments';

    protected $fillable = ['car_id', 'name'];
}
