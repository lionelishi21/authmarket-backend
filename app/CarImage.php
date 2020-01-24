<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class CarImage extends Model
{
   use LogsActivity;
   protected $table = 'car_images';

    protected $fillable = ['user.name', 'car_id', 'image'];
 
    protected static $logAttributes = ['user.name', 'image'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    public function user() {
    	return $this->hasOne('App\User', 'user_id');
    }
}

