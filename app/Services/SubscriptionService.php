<?php

namespace App\Services;
use Illuminate\Http\Request;

use App\Repositories\SubscriptionRepository;

class SubscriptionService {

	protected $subscription;

	public function __construct(SubscriptionRepository $subscriptions){
		$this->subscription = $subscriptions;
	}

	/**
	 * *****************************************
	 * this function create subscription
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 * *****************************************
	 */
	public function save(Request $request) {
		$attributes = $request->all();
		$attributes['user_id'] = $request->user()->id;

		$create = $this->subscription->subscribe($attributes);
		return $create;
	}

	/**
	 * [chceckFreeSub description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function checkForSubscription($user_id) {
		$check = $this->subscription->checkForFreeSubByUser($user_id);
		return $check;
	}

}


 ?>