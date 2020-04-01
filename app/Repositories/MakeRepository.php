<?php
namespace App\Repositories;

use App\Repositories\Helrper;
use App\VehicleMake;
use App\UserFilter;
use App\FilterMake;
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
	public function list($user) {

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

	/**
	 * Get most puplar car in jamaica
	 * @return [type] [description]
	 */
	public function custom($user) {

		$response = array();
		$this->model = new VehicleMake;
		$makes = $this->model->orderBy('name')->get(['id', 'name']);

		$popular_make = ['Honda', 'Hyundai', 'BMW', 'Audi', 'Ford', 'Jaguar', 'Jeep', 'Kia', 'Lexus', 'Mazda', 'Mercedes-Benz', 'Nissan', 'Subaru', 'Volkswagen', 'Toyota', 'Porsche', 'Suzuki', 'Mitsubishi', 'Dodge', 'Land Rover'];


		foreach( $makes as $make) {
			$car_count = Car::where('make_id', '=', $make->id)->count();

			if ( ! in_array($make->name, $popular_make)) {
				 continue;
			}

		    $response[] = array(
				'id' => $make->id,
				'name' => $make->name,
				'filter' => $this->checkIsUserFilter($user, $make->id),
				'count' => $car_count
			);
		}

		return $response;
	}

	/**
	 * This functuin get all makes
	 * @return [type] [description]
	 */
	public function all($user) {
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

	/**
	 * THis check user filter
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function checkIsUserFilter($user, $make_id) {

		$userfilter = FilterMake::where('user_id', '=', 1)->where('make_id','=',$make_id)->first();
		if ( isset( $userfilter )) {
			return true;
		}
		return false;
	}

}