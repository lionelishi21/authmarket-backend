<?php

namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
  use LogsActivity;
    protected $table = 'cars';

    protected $fillable = [
        'model_id', 'make_id', 'year_id', 'vehicle_id', 'added_by', 'batch_id',
        'price', 'color', 'steering', 'parish', 'district', 'description', 
        'milage', 'interior_color', 'exterior_color', 'doors', 'drive_type',
        'fuel_type', 'negotiable'
    ];

    protected static $logAttributes = [   'model.name', 'make.name', 'year.year', 'user.name', 'batch_id',
        'price', 'color', 'steering', 'parish', 'district', 'description', 
        'milage', 'interior_color', 'exterior_color', 'doors', 'drive_type',
        'fuel_type', 'negotiable'];

   protected static $logOnlyDirty = true; 

    public function name() {
      return $this->hasOne('App\User', 'added_by');
    }

    public function images() {
    	  return $this->hasMany('App\CarImage', 'car_id');
    }

    public function make() {
    	return $this->hasOne ('App\VehicleMake', 'id', 'make_id');
    }

    public function model() {
	  	return $this->hasOne('App\VehicleModel', 'id', 'model_id');
    }

    public function year() {
    	return $this->hasOne('App\VehicleModelYear', 'id', 'year_id');
    }

    public function feature() {
        return $this->hasMany('App\CarFeature', 'id', 'car_id');
    }

   public function safety() {
        return $this->hasMany('App\CarFeatureSafety', 'id', 'car_id');
   }

   public function entertainment() {
        return $this->hasMany('App\CarFeatureEntertainment', 'id', 'car_id');
   }

   public function other() {
        return $this->hasMany('App\CarFeatureOther', 'id', 'car_id');
   }

   public function seat() {
        return $this->hasMany('App\CarFeatureSeat', 'id', 'car_id');
   }

   public function vehicle() {
   
   }
}
