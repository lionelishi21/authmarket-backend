<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function invoice() {
    	return $this->hasOne('App\Invoice', 'id', 'invoice_id');
    }

    public function user() {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }
}
