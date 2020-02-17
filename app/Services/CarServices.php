<?php 
namespace App\Services;

use App\Repositories\Cars;
use Illuminate\Http\Request;
use App\Repositories\MakeRepository;

class CarServices {


	protected $carservices;
	/**
	 * [__construct description]
	 * @param Cars $cars [description]
	 */
	public function __construct(Cars $cars) {
		$this->carrepository = $cars;
	}

	/**
	 * **************************************************
	 * [index description]
	 * **************************************************
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function index(Request $request) {
		$filter = $request->filter;
		return $this->carrepository->all($filter);
	}

	/**
	 * this function filter cars for user
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function filter(Request $request) {
		$attributes = $request->all();
		return $this->carrepository->filterCarsByMake($request);
	}

	/**
	 * THis service get car details
	 * @param  [type] $batch_id [description]
	 * @return [type]           [description]
	 */
	public function show_details ( $batch_id ) {
		return $this->carrepository->getCarDetailsByBatchId( $batch_id);
	}

	/**
	 * this function create car ads
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function create( Request $request) {

		$attributes = $request->all();
		$user_id = $request->user()->id;
		return $this->carrepository->create($attributes, $user_id);
	}

	/**
	 * THis function updatea cares add
	 * @param  Request $request [description]
	 * @param  [type]  $id      [description]
	 * @return [type]           [description]
	 */
	public function update (Request $request, $id) {
		$attributes = $request->all();
		return $this->carrepository->update($id, $attributes);
	}

	/**
	 * [edit description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function edit( $id ) {
		return $this->carrepository->show( $id );
	}

	/**
	 * His function read cars detao;s
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function read ( $id ) {
		return $this->carrepository->find( $id );
	}

	/**
	 * [showAllUserCars description]
	 * @param  Request $request [description]
	 * @param  [type]  $user    [description]
	 * @return [type]           [description]
	 */
	public function showAllUserCars(Request $request, $user) {
		$attributes = $request->all();
		return $this->carrepository->getUserCarsById($attributes, $user);
	}

	/**
	 * [getFilterCars description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function getFilterCars(Request $request) {
		$attributes = $request->all();
		return $this->carrepository->filterCarsByMake();
	}

	/**
	 * This function delete user cars
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete ( $id) {
		return $this->carrepository->delete($id);
	}
}


 ?>