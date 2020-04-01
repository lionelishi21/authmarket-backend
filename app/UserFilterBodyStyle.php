<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFilterBodyStyle extends Model
{
    protected $table = 'user_filter_body_styles';
    protected $fillable = ['user_id', 'body_style_id'];
}
