<?php 
namespace App\Repositories;

use App\Subscription;
use App\Repositories\Helper;
use Carbon\Carbon;
use App\Profile;
use App\Car;
use App\Activity;
use App\User;
use App\UserFilter;

class ProfileRepository extends Helper{

	protected $model;

	public function __construct(Profile $profile) {
		$this->model = $profile;
	}

	/**
	 * [getAllUserCars description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function getAllCountUserCars( $user_id) {
		$cars = Car::where('added_by', '=', $user_id)->count();
		return $cars;
	}

	/**
	 * GEt all active Car counts
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function getAllActiveCar( $user ) {
		$now = Carbon::now();
		$active_car = Subscription::where('user_id', '=', $user_idr)->where('end_date', '>', $now)->count();
		return $active_car;
	}


	/**
	 * **********************************************************
	 * get alll inactive car counts
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 * ***********************************************************
	 */
	public function getAllInactiveCar( $user ) {
		$now = Carbon::now();
		$active_car = Subscription::where('user_id', '=', $user_idr)->where('end_date', '<', $now)->count();
		return $active_car;
	}

	/**
	 * **************************************************************
	 * get auser profiles details
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 * *************************************************************
	 */
	public function getUserProfile( $user_id ){
		return $this->getUserProfileByUserId($user_id);
	}

	/**
	 * *********************************************************
	 * update user
	 * @param  [type] $attributes [description]
	 * @param  [type] $user_id    [description]
	 * @return [type]             [description]
	 * *********************************************************
	 */
	public function updateUser($attributes, $user_id) {

		$update_user = User::find($user_id);
		$update_user->name = $attributes->name;
		$update_user->username = $attributes->username;
		$update_user->email = $attributes->email;
		$update_user->phone = $attributes->phone;
		$update_user->company = $attributes->company;
		$update_user->address = $attributes->address;
		$update_user->district = $attributes->district;
		$update_user->city = $attributes->parish;
		$update_user->about = $attributes->about;
		$update_user->save();

		return $update_user;
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
	   * ************************************************************
	   * THis function get all user activities
	   * @param  {[type]} $user_id [description]
	   * @return {[type]}          [description]
	   **************************************************************
	   */
	  public function getUserActivities( $user_id ) {
	  	
	  	$response = array();

	  	$activity = new Activity;
	  	$activities = $activity->where('causer_id', '=', $user_id)->orderBy('created_at', 'desc')->get();

	  	/** TODO Limit Activity feed to 5 */
	  	foreach( $activities as $activity) {
	  		$response[] = array(
	  			'description' => $activity->description,
	  			'date' => $activity->created_at
	  		);
	  	}
	  	return $response;
	  }

	  /**
	   * *****************************************************
	   * this function save user filter
	   * @param  [type] $attributes [description]
	   * @param  [type] $user       [description]
	   * @return [type]             [description]
	   * ****************************************************
	   */
	  public function saveUserFilters($attributes, $user) {

	  	$makes = $attributes['makes'];
	  	$parish = $attributes['parishes'];
	  	$year = $attributes['years'];
	  	$price = $attributes['prices'];
	  	$bodystyle = $attributes['bodystyles'];


		$userfilter = UserFilter::where('user_id', '=', $user)->first();
		
		$filter = new UserFilter;
		if ( isset($userfilter)) {
			$filter = UserFilter::find($user);
		}

 		$filter->makes = $makes;
 		$filter->parish = $parish;
 		$filter->min_year = $minyear;
 		$filter->max_year = $maxyear;
 		$filter->min_price = $min_price;
 		$filter->body_style = $bodystyles;
 		$filter->drive_type = $drive_type;
 		$filter->max_price = $max_price;
 		$filter->save();

 		if ($filter->save()){
 			$response = array('message' => 'User filter save succesfully');
 			return $response;
 		}

 		$response = array('message' => 'Something went wrong');
 		return $response;
	  }



	/**
	 * THis check user filter
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	public function checkIsUserFilter($user, $make_id) {

		$userfilter = UserFilter::where('user_id', '=', $user)->first();

		if (isset($userfilter)) {
			$filters = $userfilter->makes;
				foreach($filters as $filter) {
					if ($filter->id == $make_id) {
						return true;
					}
					return false;
				}
		}
		return false;
	}

	/**
	 * this function save user's filter
	 * @param  [type] $user       [description]
	 * @param  [type] $attributes [description]
	 * @return [type]             [description]
	 */
	public function saveUserFilter($user, $attributes){

		$response = array();
		$userfilter = UserFilter::where('user_id','=', $user)->first();
		if ( !isset($userfilter)) {
			$saveFilter = new UserFilter;
			$saveFilter->user_id = $user;
			$saveFilter->makes = $attributes['makes'];
			$saveFilter->save();

			if ($saveFilter->save()){
				$response = array('message' => 'Filter saved');
				return $response;
			}
		}
	}
}


 ?>

 