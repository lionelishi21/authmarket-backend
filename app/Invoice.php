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

    public function payment() {
    	return $this->belongsTo('App\Payment', 'id', 'invoice_id');
    }

    public function line() {
    	return $this->hasMany('App\InvoiceLine', 'invoice_id', 'id');
    }
}
 
