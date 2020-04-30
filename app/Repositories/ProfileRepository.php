<?php 
namespace App\Repositories;

use App\Subscription;
use App\Repositories\Helper;
use Carbon\Carbon;
use App\Profile;
use App\Car;
use App\Activity;
use App\User;
use App\FilterMake;
use App\FilterParish;
use App\Bodystyle;
use App\Parish;
use App\UserFilter;
use App\Credit;

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
	          'isVerify' => $user->email_verified_at,
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
	          'credits_counts' => $this->userCreditCount($user_id),
	          'activity' => $this->getUserActivities($user_id)
	        );

	        return $response;
	  }
	  /**
	   * [userCreditCount description]
	   * @return [type] [description]
	   */
	  public function userCreditCount($user) {
	  		
	  		$credits = Credit::where('user_id', '=', $user)->get();
	  		if ( $credits ){
	  			return count($credits);
	  		}
	  		return 0;
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
	 * *****************************************************
	 * This function save user makes filter
	 * *****************************************************
	 * @param  [type] $user       [description]pp/m
	 * @param  [type] $attributes [description]
	 * @return [type]             [description]
	 */
	public function saveUserFilter($user, $attributes){
		
		$response = array();
		
		$user = 1;
		$make = $attributes['makes'];

		if ( $make ) {
			$check = $this->removeMakeFilter($user, $make);
			if ( $check == false) {
				$filter = new FilterMake; 
				$filter->make_id = $make;
				$filter->user_id = $user;  
				$filter->save();
				if ($filter->save()) {
					$response = array('message' => 'User filter has been succesfully saved');
					return $response; 
				}
			} 
		}
	}

	/**
	 * ******************************************************
	 * This function remove make filter if already set
	 * ******************************************************
	 * @param  [type] $user_id [description]
	 * @param  [type] $make_id [description]
	 * @return [type]          [description]
	 * ******************************************************
	 */
	public function removeMakeFilter($user_id, $make_id) {

		$filtermake = FilterMake::where('user_id', '=', $user_id)->where('make_id', '=', $make_id)->first();
		if ($filtermake) {
			$deleted = $filtermake->delete();
			return $deleted;
		}
		return false;
	}

	/**
	 * *********************************************************************
	 * This function get user filters
	 * *********************************************************************
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 * *********************************************************************
	 */
	public function getUserFilterByUserId($user_id) {
		$response = array();
		$userFilter = UserFilrer::where('user_id', '=', $user_id)->first();

		$response = array(  
			'parish' => $userFilter->parish, 
			'makes' => '',
			'min_year' => $userFilter->min_year,
			'max_year' => $userFilter->max_year,
			'drive_type' => $userFilter->drive_type,
			'min_price' => $userFilter->min_price,  
			'max_price' => $userFilter->max_price,
			'seller_type' => $userFilter->seller_type
		);
		return $response;
	}

	public function getAllParishes($user_id) {

		$parishes = Parish::get();
		$response = array();

		foreach($parishes as $parish) {

			$response[] = array(
			     'id' => $parish->id,
    			'name' => $parish->name, 
    			'filter' => $this->checkIfParishIsFilter($user_id, $parish->id)
			);
		}
		return $response;
	}

	/**
	 * ****************************************************************
	 * This function get all body styles
	 * ****************************************************************
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 * ***************************************************************
	 */
	public function getAllBodyStyle($user_id) {

    	$bodystyles = Bodystyle::get();
    	$response = array(); 

    	foreach( $bodystyles as $bodystyle) {
    		$response[] = array(
    			'id' => $bodystyle->id, 
    			'name' => $bodystyle->name, 
    			'filter' => $this->checkIdBodyStyleFilter($user_id, $bodystyle->id)
    		);
    	}
    	return $response;
	}

	 /**
	  * ******************************************************
     * [checkIfParishIsFilter description]
     * *******************************************************
     * @param  [type] $user   [description]
     * @param  [type] $parish [description]
     * @return [type]         [description]
     * *******************************************************
     */
    public function checkIfParishIsFilter($user, $parish) {
    	if ( isset($user)) { 
	    	$filterParish = FilterParish::where('user_id', '=', $user)->where('parish_id', '=', $parish)->get(); 
	    	if ($filterParish) {
	    		return true;
	    	}	
	    	return false;
         }
    }

    /**
     * [checkIdBodyStyleFilter description]
     * @param  [type] $user      [description]
     * @param  [type] $bodystyle [description]
     * @return [type]            [description]
     */
    public function checkIdBodyStyleFilter($user, $bodystyle) {
    	if ( isset($user)) { 
	    	$filterBodyStyle = BodystyleFilter::where('user_id', '=', $user)->where('bodystyle_id', '=', $bodystyle)->first();
	    	if ($filterBodyStyle) {
	    		return true;
	    	}
	    	return false;
        }
    }

}


 ?>

 