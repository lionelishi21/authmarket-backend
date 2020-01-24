<?php 
namespace App\Repositories;

use App\Subscription;
use App\Repositories\Helper;
use Carbon\Carbon;
use App\Profile;
use App\Car;
use App\User;

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
}


 ?>

 