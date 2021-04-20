<?php 
namespace App\Services;

use App\Repositories\Cars;
use Illuminate\Http\Request;
use App\Repositories\MakeRepository;
use App\VehicleMake;
use App\VehicleModel;
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
	 * this service is for filter compare car results
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function filterCompare( Request $request) {
	
		$attributes = $request->all();
		return $this->carrepository->filterComapreCars($attributes);
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
		return $this->carrepository->UpdateCarById($attributes, $id);
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

	/**
	 * this function get cars with the most views
	 * @return [type] [description]
	 */
	public function hotcars() {
		return $this->carrepository->GetHotCars();	
	}

	/**
	 * this function add view to car
	 * @param  [type] $car_id [description]
	 * @return [type]         [description]
	 */
	public function increment_page($car_id) {
		return $this->carrepository->incrementPageViews($car_id);
	}
	
	/**
	 * This function get inactive cars
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function get_inactive_cars( $user) {
		return $this->carrepository->getUserInactiveCarByUserId($user);
	}

	/**
	 * this function get active cars
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function get_active_cars( $user) {
		return $this->carrepository->GetUserActiveCarByUserId( $user);
	}

	/**
	 * [rotate_image description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function rotate_image($id) {
		return $this->carrepository->RotateImageByImage($id);
	}

	/**
	 * [sold_vechile description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function sold_vechile($id) {
		return $this->carrepository->sold($id);
	}

	public function set_main_image(array $attributes) {
		return $this->carrepository->setMainImage($attributes);
	}
	

	/**
	 * THIS FUNCTION GET ALL CARS FROM JACARS WEBSITE
	 * @param  [type] $attributes [description]
	 * @return [type]             [description]
	 */
	public function compare_cars( array $attributes ) {

		 $filter = array();

		 $vehicleMake = VehicleMake::where('id', '=', $attributes['make'])->first();
		 $vehicleModel = VehicleModel::where('id', '=', $attributes['model'])->first();

		if ( $vehicleMake ) {
			$filter = array( 'make' => $vehicleMake->name );
		}


		if ($vehicleModel) {
			$filter = array( 'make' => $vehicleMake->name, 'model' => $vehicleModel->name );
		}

		return $this->carrepository->jacars($filter);
	}
}


 ?>