<?php 
namespace App\Repositories;

use App\Plan;
use App\User;

class PlanRepository {

	protected $model;

	public function __construct(Plan $plan){
		$this->model = $plan;
	}


	/**
	 * this function get all plans
	 * @return [type] [description]
	 */
	public function getAllPlans() {
		$plans = Plan::get();
		return $plans;
	}

	/**
	 * *****************************************************
	 * This get user plan by user id
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 * *****************************************************
	 */
	public function getUserPlanByUserId($user) {
		$user = User::where('plan_id', '=', $user)->first();
		return $user;
	}

	/**
	 * [electUserPlan description]
	 * @param  array  $array [description]
	 * @return [type]        [description]
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
	 * [getPlanBySlug description]
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
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
			'duration' => $plan->duration
		);

		return $response;
	}

}

 ?>