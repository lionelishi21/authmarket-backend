<?php 
namespace App\Repositories;

use App\Plan;
use App\Subscription;
use App\Repositories\Helper;
use App\User;

class PlanRepository extends Helper {

	protected $model;

	public function __construct(Plan $plan){
		$this->model = $plan;
	}

	/*********************************************************
	 * this function get all plans
	 * *******************************************************
	 * @return [type] [description]
	 * *******************************************************
	 */
	public function getAllPlans($user) {
		
		$response = array();
		$free_plan = $this->checkForFreePlan($user);
		

		$plans = Plan::get();
		foreach( $plans as $plan) {

			$isFree = false; 
			if ($plan->cost == 'free' AND $free_plan == true) {
				$isFree = true;
			}

			$response[] = array ( 
				'name' => $plan->name,  
				'cost' => $plan->cost, 
				'ads_amount' => $plan->ads_amount, 
				'photos_amount' => $plan->photos_amount, 
				'slug' => $plan->slug,
				'duration' => $plan->duration, 
				'free' => $isFree
			);
		}
		return $response;
	}

	/**
	 * *************************************************************
	 * [checkForFreePlan description]
	 * *************************************************************
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 * *************************************************************
	 */
	public function checkForFreePlan($user_id) {
		$subscription = Subscription::where('user_id', '=', $user_id)->where('plan_id', '=', 1)->first();
		if ($subscription) {
			return true;
		}
	}

	/**
	 * *************************************************************
	 * This get user plan by user id
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 * *************************************************************
	 */
	public function getUserPlanByUserId($user) {
		$userplans = $this->userCars($user, 'cars');
		return $userplans;
	}

	/**
	 * *************************************************************
	 * [electUserPlan description]
	 * @param  array  $array [description]
	 * @return [type]        [description]
	 * *************************************************************
	 */
	public function selectUserPlan(array $array) {

		$response = array();
		$user = User::find($array['user_id']);
		$user->plan_id = $array['plan_id'];
		$user->save();

		if ( $user->save()){
			$response = array('status' => true);
			return $response;
		}
		return $response;
	}

	/**
	 * ************************************************************
	 * [getPlanBySlug description]
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 * ************************************************************
	 */
	public function getPlanBySlug( $slug ) {

		$response = array();
		$plan = $this->model->where('slug', '=', $slug)->first();

		$money = '';
	
		if ( $plan->name == 'Starter') {
			$money = $plan->cost;
		} else {
			$money = money_format('$%i', $plan->cost);
		}

		$response = array (
			'id' => $plan->id,
			'name' => $plan->name,
			'cost' =>  $money,
			'price' =>  $plan->cost,
			'duration' => $plan->duration
		);

		return $response;
	}

}

 ?>