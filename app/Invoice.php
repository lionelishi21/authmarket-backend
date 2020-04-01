<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    
    public function user() {
		return $this->hasOne('App\User', 'id', 'user_id');    	
    }

    public function plan(){
    	return $this->hasOne('App\Plan', 'id', 'plan_id');
    }
    // public function payment() {
    // 	return $this->hasOne('App\Payment', 'id', 'payment_id');
    // }
}
 
