<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    use LogsActivity;
    
    protected $fillable = [
    	'user_id',
    	'isDealer',
    	'company',
    	'address',
    	'district',
    	'city',
    	'about'
    ];

    protected static $logAttributes = ['user_id',
    	'isDealer',
    	'company',
    	'address',
    	'district',
    	'city',
    	'about'];

    protected static $logOnlyDirty = true;

}
