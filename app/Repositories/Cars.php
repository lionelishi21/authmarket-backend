<?php 
namespace App\Repositories;

use App\CarFeatureEntertainment;
use App\CarFeatureSafety;
use App\CarFeatureOther;
use App\CarFeatureSeat;
use App\Activity;
use App\CarFeature;
use App\Bodystyle;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use App\CarImage;
use Response;
use App\Car;
use Image;


class Cars extends Helper {


	protected $cars;

	public function __construct(Car $cars){
		$this->cars = $cars;
	}
	/**
	 * [create description]
	 * @param  array  $array [description]
	 * @return [type]        [description]
	 */	
	public function createCar($array) {
		 $response = array();
		 $car = Car::create($array);
		 if ($car) {
			$response = array('message' => 'Successfully', 'car_id' => $car->batch_id);
		 }
		  return $response;
	}

	/**
	 * ************************************************************************
	 * This function create new car listings
	 * ************************************************************************
	 * @param  array $attributes post request array from mobile 
	 * @return [type]             [description]
	 * *************************************************************************
	 */
	public function create( $attributes, $user_id ) {


		$main = json_decode($attributes['main']);
		$main->added_by = $user_id;
		$batch_id = uniqid();

		$randomNum = substr(str_shuffle("0123456789"), 0, 10);
		$main->price = $this->getAmount($main->price);

		$response = array();

		// Convet object to array
		$details = (array) $main;
		$created = Car::create( $details );
		$car_id = $created->id;

		$update = Car::find($car_id);
		$update->batch_id = 'ATJ-'.$car_id.''.$batch_id;
		$update_info = $update->update();

		$car_features = $attributes['car_features'];
		$car_seats = $attributes['car_seats'];
		$car_others = $attributes['car_others'];
		$car_safety = $attributes['car_safety'];
		$car_entertainment  = $attributes['car_entertainment'];


		// $profile = $attributes['profile'];

		if ( isset($car_features) ) {
			$features = explode(',', $car_features);
			$this->saveCarFeatures($features, $car_id);
		}

		if ( isset($car_seats )){
			$seats = explode(',', $car_seats);
			$this->saveCarFeatures($seats, $car_id, 'seats');
		}

		if ( isset( $car_others )) {
			
			$others = explode(',', $car_others);
			$this->saveCarFeatures($others, $car_id, 'others');
		}

		if ( isset( $car_entertainment) ) {

			$entertainment = explode(',', $car_entertainment);
			$this->saveCarFeatures($entertainment, $car_id, 'entertainment');
		}

		if ( isset( $car_safety)) {

			$safety = explode(',', $car_safety);
			$this->saveCarFeatures($safety, $car_id, 'safety');
		}

	   if ( isset( $attributes['image1'])) {

		  $save_image = $this->saveImages($attributes['image1'], $car_id, $user_id );
		}

	   if ( isset( $attributes['image2'])) {
		  $save_image = $this->saveImages($attributes['image2'], $car_id, $user_id );
		}

		if ( isset( $attributes['image3'])) {
		  $save_image = $this->saveImages($attributes['image3'], $car_id, $user_id );
		}

		if ( isset( $attributes['image4'])) {
		  $save_image = $this->saveImages($attributes['image4'], $car_id, $user_id );
		}

		if ( isset( $attributes['image5'])) {
		  $save_image = $this->saveImages($attributes['image5'], $car_id, $user_id );
		}

		return $response = array('response' => $update->batch_id);
	}

	/**
	 * [show description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function show( $batch_id ) {

		$response = array();
		$attributes = Car::where('batch_id', '=', $batch_id)->first();
		$response = array(
			'id' => $attributes->id,
			'batch_id' => $attributes->batch_id,
			'make_id' => $attributes->make_id,
			'model_id' => $attributes->model_id,
			'year_id' => $attributes->year_id,
			'vehicle_id' => $attributes->vehicle_id,
			'make' => $this->getMakeById($attributes->make_id)->name,
			'model' => $this->getModelById($attributes->model_id),
			'year' => $this->getModelYearById ($attributes->year_id),
			'color' => $attributes->color,
			'location' => $attributes->parish,
			'steering' => $attributes->steering,
			'price' => $attributes->price,
		);

		if ( isset($response)) {
			return $response;
		}
		return $response;
	}


	/**
	 * THis function get user ars
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function getUserCars($user, $filter) {
		$cars = Car::where('added_by', '=', $user)->get();
		return $cars;
	}


	/**
	 * [getCarDetailsById description]
	 * @return [type] [description]
	 */
	public function getCarDetailsById($id) {

		$carDetails = Car::find($id);
		$response = array(
			'id' => $carDetails->id,
			'subscribe' => $this->checkIfSubscribe($carDetails->id),
			'batch_id' => $carDetails->batch_id,
			'make_id' => $carDetails->make_id,
			'pageviews' => $carDetails->pageviews,
			'model_id' => $carDetails->model_id,
			'milage' => $carDetails->milage,
			'year_id' => $carDetails->year_id,
			'vehicle_id' => $carDetails->vehicle_id,
			'make' => $this->getMakeById($carDetails->make_id)->name,
			'model' => $this->getModelById($carDetails->model_id),
			'year' => $this->getModelYearById ($carDetails->year_id),
			'color' => $carDetails->color,
			'location' => $carDetails->parish.', '. $carDetails->district,
			'district' => $carDetails->district,
			'parish' => $carDetails->parish,
			'steering' => $carDetails->steering,
			'price' => $carDetails->price,
			'profile' => $this->getUserProfileByUserId($carDetails->added_by)
		);

		if (isset($response)) {
			return $response;
		}
	}

	/**
	 * [UpdateCarById description]
	 * @param [type] $carId  [description]
	 * @param [type] $params [description]
	 */
	public function UpdateCarById($params, $carId) {
		$response = array();
		if (isset ($carId) ) {
			$car = Car::where('id', '=', $carId);
			$update = $car->update($params);
			if ($update) {
				$response = array('message' => 'Car details has been succesfully updatedsss');
				return $response;
			}
		}
		return $response;
	}

	/**
	 * [all description]
	 * @param  [type] $filter [description]
	 * @return [type]         [description]
	 */
	public function all( $filter ) {

		$response = array();
		$car = $this->car::orderBy('id', ', desc');

		if ($filter['make'] != '') {
			$car = $car->where('make_id', '=', $filter['make']);
		}

		if ($filter['model'] != '') {
			$car = $car->where('model_id', '=', $filter['model']);
		}

		if ($filter['price'] != '') {
			//TODO
			//Add where betweent fucntionalilty
		}

		if ( $filter['year'] != '') {
			//TODO
			//Add where betweeb functionality
		}

		$cars = $car->get();

		foreach( $cars as $car) {

			$response[] = array(
				'id' => $car->id,
				'make' => $this->getMakeById($car->make_id),
				'model' => $this->getModelById($car->model_id),
				'year' => $this-> getModelYearById($car->year_id),
				'pageviews' => $car->pageviews,
				// 'vehicle' => $this->getVehicleById($vehicle->id),
				'location' => $car->parsih,
				'price' => $car->price,
				'color' => $car->color,
				'description' => $car->description
			);
		}

		return $response;
	}

	/**
	 * This function get user listing by id
	 * @param  [type] $filter  [description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function getUserCarsById($filter, $user_id) {

		$response = array();
		$listing = $this->cars->where('added_by', '=', $user_id)->get();
		foreach( $listing as $car) {

			$response[] = array(
				'id' => $car->id,
				'subscribe' => $this->checkIfSubscribe($car->id),
				'batch_id' => $car->batch_id,
				'make_id' => $car->make_id,
				'make' => $this->getMakeById($car->make_id),
				'model' => $this->getModelById($car->model_id),
				'year' => $this->getYearById($car->year_id),
				// 'vehicle' => $this->getVehicleById($car->vehicle_id),
				'location' => $car->parsih,
				'pageviews' => $car->pageviews,
				'price' => $car->price,
				'interior_color' => $car->interior_color,
				'exterior_color' => $car->exterior_color,
				'description' => $car->description,
				'location' => $car->parish.', '. $car->district,
				'district' => $car->district,
				'parish' => $car->parish,
				'milage' => $car->milage,
				'steering' => $car->steering,
				'image' => $this->getCarImage($car->id),
				'images' => $car->images,
				'profile' => $this->getUserProfileByUserId($car->added_by)

			);
		}
		return $response;
	}

	/**
	 * *******************************************************************
	 * [getCarDetailsBy description]
	 * *******************************************************************
	 * @param  [type] $batch_id [description]
	 * @return [type]           [description]
	 * *******************************************************************
	 */
	public function getCarDetailsByBatchId( $batch_id ) {

		$response = array();

		$car = $this->cars->where('batch_id', '=', $batch_id)->first();
			$response = array(
				'id' => $car->id,
				'subscribe' => $this->checkIfSubscribe($car->id),
				'batch_id' => $car->batch_id,
				'make_id' => $car->make_id,
				'make' => $this->getMakeById($car->make_id),
				'model' => $this->getModelById($car->model_id),
				'model_id' => $car->model_id,
				'year_id' =>  $car->year_id,
				'year' => $this->getYearById($car->year_id),
				'vehicle' => $this->getVehicleById($car->make_id, $car->model_id, $car->year_id),
				'profile' => $this->getUserProfileByUserId($car->added_by),
				'bodystyle_id' => $car->body_type,
				//'bodystyle' => Bodystyle::find($car->body_type)->name,
				'location' => $car->parsih,
				'pageviews' => $car->pageviews,
				'price' => $car->price,
				'doors' => $car->doors,	
				'interior_color' => $car->interior_color,
				'exterior_color' => $car->exterior_color,
				'desc' => $car->description,
				'location' => $car->parish.', '. $car->district,
				'parish' => $car->parish,
				'district' => $car->district,
				'drive_type' => $car->drive_type,
				'fuel_type' => $car->fuel_type,
				'parish' => $car->parish,
				'milage' => $car->milage,
				'steering' => $car->steering,
				'image' => $this->getCarImage($car->id),
				'images' => $car->images,
				'features' => $car->feature,
				'safety' => $car->safety,
				'entertainment' => $car->entertainment,
				'other' => $car->other,
				'seat' => $car->seat
			);
		return $response;
	}

	/**
	 * ******************************************************************
	 * This filter car by make name
	 * ******************************************************************
	 * @param  [type] $filter [description]
	 * @return [type]         [description]
	 * ******************************************************************
	 */
	public function filterCarsByMake($attributes, $offset = 15) {

		$listings = $this->cars->with(['year', 'make']);
		
		$make ='';	

		if ( $attributes['parish'] ) {
			$listings = $listings->where('parish', '=',$attributes['parish'] );
		}

		if ( $attributes['make'] ) {
			$make_count = count($attributes['make']);
			for ($i = 0; $i < $make_count; $i++) {
				$listings = $listings->orWhere('make_id', '=', $attributes['make'][$i]);
			}
		}
		
		if ($attributes['maxPrice']) {
			$listings = $listings->where('price', '<=', $attributes['maxPrice']);
		}

		if ( $attributes['minPrice']) {
			$listings = $listings->where('price', '>=', $attributes['minPrice']);
		}

		if ( $attributes['bodyType']) {
			$listings = $listings->where('body_type', '=', $attributes['bodyType']);
		}


		// return $listings;

		$response = array();
		$listings = $listings->get();

		foreach( $listings as $car) {

			if ( isset( $attributes['minYear']) ) {
				$carYear = $this->getYearById($car->year_id);
				$filterMinYear = $attributes['minYear'];

				if ($carYear < $filterMinYear){
				  continue;
				}
			}


			if ( isset ( $attributes['maxYear'])) {
				$carYear = $this->getYearById($car->year_id);
				$filterMinYear = $attributes['minYear'];

				if ($carYear < $filterMinYear){
				  continue;
				}
			}

			
			$response[] = array(
				'id' => $car->id,
				'subscribe' => $this->checkIfSubscribe($car->id),
				'batch_id' => $car->batch_id,
				'make_id' => $car->make_id,
				'pageviews' => $car->pageviews,
				'make' => $this->getMakeById($car->make_id),
				'model' => $this->getModelById($car->model_id),
				'year' => $this->getYearById($car->year_id),
				'vehicle' => $this->getVehicleById($car->make_id, $car->model_id, $car->year_id),
				'profile' => $this->getUserProfileByUserId($car->added_by),
				'location' => $car->parsih,
				'price' => $car->price,
				'interior_color' => $car->interior_color,
				'exterior_color' => $car->exterior_color,
				'desc' => $car->description,
				'location' => $car->parish.', '. $car->district,
				'district' => $car->district,
				'fuel_type' => $car->fuel_type,
				'parish' => $car->parish,
				'milage' => $car->milage,
				'steering' => $car->steering,
				'image' => $this->getCarImage($car->id),
				'images' => $car->images,
				'features' => $car->feature,
				'safety' => $car->safety,
				'entertainment' => $car->entertainment,
				'other' => $car->other,
				'seat' => $car->seat
			);
		}
		return $response;
	}

	/**
	 * *********************************************************************
	 * this function save car features
	 * *********************************************************************
	 * @param  array  $arry [description]
	 * @param  [type] $id   [description]
	 * @param  string $type [description]
	 * @return [type]       [description]
	 * *********************************************************************
	 */
	public function saveCarFeatures(array $array, $id, $type = 'default') {

		 $array_count  = count($array);
		 for($i = 0; $i < $array_count; $i++) {

			switch ($type) {
			   case "seats":
					$model = new CarFeatureSeat;
					break;

			   case "safety":
					$model = new CarFeatureSafety;
					break;

			   case "others";
					$model = new CarFeatureOther;
					break;

			   case "entertainment":
					$model = new CarFeatureEntertainment;
					break;

			   default:
				   $model = new CarFeature;
				   break;
			}

			$model->car_id = $id;
			$model->name = $array[$i];
			$model->save();
		 }
	}

	/**
	 * ********************************************
	 * this function save car images
	 * ********************************************
	 * @param  [type] $image  [description]
	 * @param  [type] $car_id [description]
	 * @return [type]         [description]
	 * ********************************************
	 */
	public function saveImages($images, $car_id, $user_id) {

		$originalImage = $images;
	  
		$thumbnailImage = Image::make($originalImage);
		$thumbnailPath = public_path().'/storage/thumbnail/';
		$originalPath  = public_path().'/storage/images/';
		$thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
		$thumbnailImage->resize(480,320);
		$thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName()); 

		$imagemodel=  new CarImage();
		$imagemodel->image =time().$originalImage->getClientOriginalName();
		$imagemodel->car_id = $car_id;
		$imagemodel->user_id = $user_id;

		$imagemodel->save();
	}


	public function getUserDashBoardWidgets($user) {

		$response = array();

		$today = Carbon::now();

		$car_count = Car::wehere('added_by', '=', $user_id)->count();
		$actve_car = Subscription::where('added_by', '=', $user)->count();

		$cars = Cars::where('added_by', '=', $user)->get(3);

		foreach($cars as $car) {

		  $subscription = Subscription::where('car_id', '=', $car->id)->first();

		  if ( $subscription ) {
			$response = array(
			'id' => $car->id,
				'subscribe' => $this->checkIfSubscribe($car->id),
				'batch_id' => $car->batch_id,
				'make_id' => $car->make_id,
				'make' => $this->getMakeById($car->make_id),
				'model' => $this->getModelById($car->model_id),
				'year' => $this->getYearById($car->year_id),
				'vehicle' => $this->getVehicleById($car->make_id, $car->model_id, $car->year_id)
			);
		  }
		  
		}

		$responses = array(
			'cars' => $response,
			 count => $car_count,
			 active => $car_active,
		);
		
		return $responses;
	}


	/**
	   * [getUserProfileByUserId description]
	   * @param  [type] $user_id [description]
	   * @return [type]          [description]
	   */
	  public function getUserProfileByUserId( $user_id ) {

	       $user = User::find($user_id);
	       $response = array(
	          'name' => $user->name,
	          'username' => $user->username,
	          'email' => $user->email,
	          'dealer' => $user->isDealer,
	          'company' => $user->company,
	          'address' => $user->address,
	          'district' => $user->district,
	          'parish' => $user->city,
	          'about' => $user->about,
	          'name' => $user->name,
	          'email' => $user->email,
	          'phone' => $user->phone,
	          'user_cars_count' => $this->userCars($user_id, 'count'),
	          'user_active_count' => $this->userCars($user_id, 'active'),
	          'cars' => $this->userCars($user_id, 'cars'),
	          'user_inactive_count' => $this->userCars($user_id, 'inactive'),
	          'activity' => $this->getUserActivities($user_id)
	        );

	        return $response;
	  }

  /**
   * get user activites by user id
   * @param  [type] $user_id [description]
   * @return [type]          [description]
   */
  public function getUserActivities( $user_id ) {
  	$activity = new Activity;
  	return $activity::find($user_id);
  }

  /**
   * This function get user cars details
   * @param  [type] $user_id [description]
   * @param  [type] $options [description]
   * @return [type]          [description]
   */
  public function userCars($user_id, $options) {
    $car = new Car;
    $subscription = new Subscription;
    $now = Carbon::now()->toDateTimeString();

    $cars = $car->where('added_by', '=', $user_id);

    if ( $options == 'count') {
      return $car->count();
    }

    if ($options == 'active') {
      return $subscription->where('user_id', '=', $user_id)->where('end_time', '<', $now)->count();
    } 

    if ( $options == 'inactive') {
        return $subscription->where('user_id', '=', $user_id)->where('end_time', '>', $now)->count();
    }

    if ($options == 'cars') {
        
        $response = array();     
        $active_cars = $cars->get();
        foreach ( $active_cars as $usercar ) {
            
            $sub = $subscription->where('user_id', '=', $user_id)->count();
            if ( $sub < 1 ) {
               continue;
            }  

            $response[] =  array (
                'id' => $usercar->id,
                'subscribe' => $this->checkIfSubscribe($usercar->id),
                'make' => $this->getMakeById($usercar->make_id),
                'model' => $this->getModelById($usercar->model_id),
                'vehicle' => $this->getVehicleById($usercar->make_id, $usercar->model_id, $usercar->year_id),
                'price' => $usercar->price,
                'image' => $this->getCarImage($usercar->id)
            );     
        }
        return $response;
    }
    
  }

  /**
   * ***************************************************
   * this function get the top 10 must view cars
   * ***************************************************
   * @param  [type] $attributes [description]
   * @return [type]             [description]
   * ***************************************************ß
   */
  public function GetHotCars() {

  	  $response = array();
  	  $car = new Car;
  	  $cars = $car->orderBy('pageviews', 'desc')->get();

  	  foreach($cars as $car ) {
  		$response[] = array(
	        'id' => $car->id,
			'subscribe' => $this->checkIfSubscribe($car->id),
			'batch_id' => $car->batch_id,
			'make_id' => $car->make_id,
			'make' => $this->getMakeById($car->make_id),
			'model' => $this->getModelById($car->model_id),
			'year' => $this->getYearById($car->year_id),
			'vehicle' => $this->getVehicleById($car->make_id, $car->model_id, $car->year_id),
			'profile' => $this->getUserProfileByUserId($car->added_by),
			'location' => $car->parsih,
			'price' => $car->price,
			'pageviews' => $car->pageviews,
			'interior_color' => $car->interior_color,
			'exterior_color' => $car->exterior_color,
			'desc' => $car->description,
			'location' => $car->parish.', '. $car->district,
			'district' => $car->district,
			'fuel_type' => $car->fuel_type,
			'parish' => $car->parish,
			'milage' => $car->milage,
			'steering' => $car->steering,
			'image' => $this->getCarImage($car->id),
			'images' => $car->images,
			'features' => $car->feature,
			'safety' => $car->safety,
			'entertainment' => $car->entertainment,
			'other' => $car->other,
			'seat' => $car->seat
  		);
  	  }
  	  return $response;
  }

  /**
   * *********************************************************************
   * This function get all inactive car
   * *********************************************************************
   * @param  [type] $user_id [description]
   * @return [type]          [description]
   * *********************************************************************
   */
  public function getUserInactiveCarByUserId( $user_id ){

  		$response = array();
  		$cars = $this->cars->where('added_by', '=', $user_id)->get();
  		foreach ( $cars as $car) {
  			
  			$isSubscribe = $this->checkIfSubscribe($car->id);
  			if ($isSubscribe == true) {
  				continue;
  			}

  			$response[] = array( 
  				'id' => $car->id,
  				'image' => $this->getCarImage($car->id),
  				'batch_id' => $car->batch_id,
  				'make' => $this->getMakeById($car->make_id),
				'model' => $this->getModelById($car->model_id),
				'year' => $this->getYearById($car->year_id),
				'vehicle' => $this->getVehicleById($car->make_id, $car->model_id, $car->year_id),
				'profile' => $this->getUserProfileByUserId($car->added_by),
				'location' => $car->parish.', '. $car->district,
				'pageviews' => $car->pageviews, 
				'interior_color' => $car->interior_color,
				'exterior_color' => $car->exterior_color,
				'price' => $car->price
  			);
  		}

  		return $response;
  }

  /**
   * ******************************************************
   * This function get active car user
   * ******************************************************
   * @param  [type] $user_id [description]
   * @return [type]          [description]
   * ******************************************************
   */
  public function getUserActiveCarByUserId($user_id) {

  		$response = array();
  		$now = Carbon::now();

  		$cars = $this->cars->where('added_by', '=', $user_id)->get();
  		foreach ( $cars as $car) {
  			$isSubscribe = $this->checkIfSubscribe($car->id);
  			if ($isSubscribe == false) {
  				continue;
  			}

  			$sub_details = Subscription::where('car_id', '=', $car->id)->first();
  			$response[] = array( 
				'id' => $car->id,
				'sub' => $this->checkIfSubscribe($car->id),
				'make' => $this->getMakeById($car->make_id),
				'image' => $this->getCarImage($car->id),
				'days' => $now->diffInDays($sub_details->end_time),
				'batch_id' => $car->batch_id,
				'model' => $this->getModelById($car->model_id),
				'year' => $this->getYearById($car->year_id),
				'vehicle' => $this->getVehicleById($car->make_id, $car->model_id, $car->year_id),
				'profile' => $this->getUserProfileByUserId($car->added_by),
				'location' => $car->parish.', '. $car->district,
				'pageviews' => $car->pageviews, 
				'interior_color' => $car->interior_color,
				'exterior_color' => $car->exterior_color,
				'price' => $car->price
  			);
  		}
  		return $response;
  }

  /**
   * this fumnction increment the car page
   * @return [type] [description]
   */
  public function incrementPageViews($car_id) {

  		$car = $this->cars->where('batch_id', '=', $car_id)->first();
  		$response = array();

		if ($car->pageviews == 0) {
			$car->pageviews = 1; 
			$car->save();
		} else {
			$increment = $car->pageviews + 1;
  			$car->pageviews = $increment;
  			$car->save();
		}
  			
    //  	return $response; 
  }

}


 ?>