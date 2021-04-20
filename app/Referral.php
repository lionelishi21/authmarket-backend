<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    
	protected $fillable = ['referee_id', 'referer_id'];
   
    public function user() {
    	return $this->hasOne ('App\User', 'id', 'referee_id');
    }

    public function points() {
    	return $this->hasMany('App\ReferralPoint', 'id', 'id');
    }
}
