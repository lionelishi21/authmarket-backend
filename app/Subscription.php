<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['car_id', 'plan_id', 'user_id', 'start_time', 'end_time'];
}
