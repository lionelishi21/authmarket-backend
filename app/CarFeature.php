<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarFeature extends Model
{
    protected $table = 'car_features';
    protected $fillable = ['car_id', 'name'];
}
