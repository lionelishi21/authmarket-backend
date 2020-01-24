<?php 

namespace App\Traits;

trait HasModel
{
	public function model()
	{
		return $this->belongsTo(config('vehicles.models.VehicleModel'));
	}
}