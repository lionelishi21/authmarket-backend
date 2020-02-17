<?php
namespace App\Repositories;

use App\Repositories\Helrper;
use App\VehicleMake;
use App\Car;

class MakeRepository extends Helper {
	
	protected $model;

	/**
	 * **********************************************
	 * This function list on all models
	 ************************************************
	 * @param  {[type]} $data [description]
	 * @return {[type]}       [description]
	 ************************************************
	 */
	public function list( ) {

		$response = array();

		$this->model = new VehicleMake;
		$makes = $this->model->orderBy('name')->get(['id', 'name']);

		foreach( $makes as $make) {
			$car_count = Car::where('make_id', '=', $make->id)->count();

			if ( $car_count < 1) {
				 continue;
			}

		    $response[] = array(
				'id' => $make->id,
				'name' => $make->name,
				'count' => $car_count
			);
		}
		return $response;
	}


	public function all() {

	   $response = array();

	   $this->model = new VehicleMake;
	   $makes = $this->model->orderBy('name')->get(['id', 'name']);
	   foreach( $makes as $make ) {

	   	   $car_count = Car::where('make_id', '=', $make->id)->count();
	   	   $response[] = array(
				'id' => $make->id,
				'name' => $make->name,
				'count' => $car_count
			);
	   }
	   return $response;
	}
}