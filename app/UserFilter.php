<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFilter extends Model
{
    protected $table = 'user_filter';

    protected $fillable = ['user_id', 'parish', 'district', 'min_year', 'max_year', 'drive_type', 'min_price', 'max_price', 'seller_type'];
}
