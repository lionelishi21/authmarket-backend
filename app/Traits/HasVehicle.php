<?php 

namespace App\Traits;

trait HasVehicle
{
	public function vehicle()
	{
		return $this->belongsTo(config('vehicles.models.vehicle'));
	}
}