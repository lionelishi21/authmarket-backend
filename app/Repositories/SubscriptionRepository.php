<?php 
namespace App\Repositories;

use App\Subscription;
use Carbon\Carbon;
use App\Plan;

class SubscriptionRepository {
	
	protected $model;

	public function __construct(Subscription $subscription){
		$this->model = $subscription;
	}

	/**
	 * This function subscribe a user
	 * @param  array  $array [description]
	 * @return [type]        [description]
	 */
	public function subscribe( array $array) {

		$plan = Plan::find($array['plan_id']);
		$array['start_time'] = Carbon::now();
		$array['end_time'] = $array['start_time']->addDays($plan->duration);

		$save = $this->model->create($array);
		if ($save) {
			return $save;
		}
	}

	/**
	 * Tjos fimctopm cjecl of sibscription is active
	 * @param  [type] $car_id [description]
	 * @return [type]         [description]
	 */
	public function checkForFreeSubByUser($user_id) {
		$sub = $this->model->where('user_id', '=', $user_id)->where('slug', '=', 'starter-plan')->count();
		if ( $sub > 0) {
			$response = array( 'message' => 'has started plan', 'status' => true);
			return $response;
		} else {
		    $response = array(  'message' => 'has no started plan','status' => false);
			return $response;
		}
	}

	/**
	 * ************************************************
	 * [getActiveSubByUserId description]
	 * ***********************************************
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function getActiveSubByUserId( $user_id ) {

		$response = array();
		$subs = Subscriptions::where('user_id', '=', $user_id)->get();

		foreach( $subs as $sub ) {

			$response[] = array(
				'car' => Car::find($sub->car_id),
				'id' => $sub->id,
				'plan' => Plan::find($sub->plan_id),
				'start_time' => $sub->start_time,
				'end_time' => $sub->end_time
			);
		}
		return $response;
	}
}
 ?>
