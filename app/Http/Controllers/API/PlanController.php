<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Response;

class PlanController extends Controller
{
    protected $planservice;

    public function __construct(PlanService $planservice) {
    	$this->planservice = $planservice;
    }

    /**
     * ************************************
     * THis function get all plans
     * @return [type] [description]
     * ************************************
     */
    public function index(){
    	$plans = $this->planservice->index();
    	return Response::json($plans);
    }


    /**
     * this giet plan by song
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function details( $slug) {
        $plan = $this->planservice->plans($slug);
        return Response::json($plan);
    }

    /**
     * *********************************************
     * This fcuntion get all user plans by user is
     * @param  [type] $user [description]
     * @return [type]       [description]
     * *********************************************
     */
    public function userPlans(Request $request) {

    	$response = array();
    	// $user_id = $request->user()->id;
        $user_id = 1;
    	$plans = $this->planservice->userplans($user_id);

    	if ( isset( $plans)) {
    	   return Response::json($plans);
    	}
    	return Resppons::json($response);
    }

    /**
     * [selectPlan description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function selectPlan(Request $request, $id ) {

    	$user_id = $request->user()->id;
    	$plans = $this->planservice->selectuserplan($user_id, $id);
    	return Response::json($plans);
    }
}
