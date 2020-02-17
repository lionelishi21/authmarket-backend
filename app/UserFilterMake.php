<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFilterMake extends Model
{
    protected $table = 'user_filter_makes';
    protected $fillable = ['user_id', 'make_id'];
}
