<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlanService;
use Response;   


class PlansController extends Controller
{
    protected $planservice;

    public function __construct(PlanService $planservice) {
    	$this->planservice = $planservice;
    }

    /**
     * ***************************************************
     * [index description]
     * ***************************************************
     * @return [type] [description]
     * ***************************************************
     */
    public function index(Request $request) {
        $plans = $this->planservice->index($request);
    	return Response::json($plans);
    }

    /**
     * This function get user plans
     * @param  {[type]} Request $request      [description]
     * @return {[type]}         [description]
     */
    public function userPlans(Request $request) {
        $user_id = $request->user()->id;
        $plans = $this->planservice->userplans($user_id);
        return $plans;
    }
}
