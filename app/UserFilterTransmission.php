<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFilterTransmission extends Model
{
    protected $table = 'user_filter_transmissions';
    protected $fillable = ['user_id', 'transmission_id'];
}
