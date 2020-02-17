<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFilterCyclinder extends Model
{
    protected $table = 'user_filter_cyclinders';
    protected $fillable = ['user_id', 'cyclinder_id'];
}
