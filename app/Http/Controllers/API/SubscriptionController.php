<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Response;

class SubscriptionController extends Controller
{

	protected $subscriptions;

    public function __construct(SubscriptionService $subscriptions){
    	$this->subscriptions = $subscriptions;
    }


    public function subscribe(Request $request) {

    	$store = $this->subscriptions->save($request);
    	return Response::json($store);
    }

    /**
     * [checkSubscription description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkSubscription(Request $request) {
    	$user_id = $request->user()->id;
    	$subscriptions = $this->subscriptions->checkForSubscription($user_id);
    	return REsponse::json($subscriptions);
    }
}
