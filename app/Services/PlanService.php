<?php 
namespace App\Services;

use App\Repositories\PlanRepository;
use Illuminate\Http\Request;

class PlanService {

  protected $planrepository;

  /**
   * ************************************************************
   * [__construct description]
   * @param PlanRepository $planrepository [description]
   * ************************************************************
   */
  public function __construct(PlanRepository $planrepository) {
  	$this->planrepository = $planrepository;
  }

  /**
   * **********************************************
   * THis function get all plans
   * @return [type] [description]
   * **********************************************
   */
  public function index(Request $request) {

    $user = $request->user();
    if ( $user ) {
      $user_id = $user->id;
      $plans = $this->planrepository->getAllPlans($user_id);
      return $plans;
    }
  }

  /**
   * ***************************************************************
   * this function get plan by user id
   * @param  [type] $user_id [description]
   * @return [type]          [description]
   * ***************************************************************
   */
  public function userplans( $user_id ) {
 	$plans = $this->planrepository->getUserPlanByUserId( $user_id );
 	return $plans;
  }

  /**
   * **************************************************************
   * [selectuserplan description]
   * @param  Request $request [description]
   * @return [type]           [description]
   * **************************************************************
   */
  public function selectuserplan($user_id, $plan_id) {
  	
  	$attributes['plan_id'] = $plan_id;
  	$attributes['user_id'] = $user_id;
  	
  	$plan = $this->planrepository->selectUserPlan($attributes);
  	return $plan;
  }

  /**
   * ********************************************************
   * [plans_service description]
   * @return [type] [description]
   * ********************************************************
   */
  public function plans($slug) {
      $plan = $this->planrepository->getPlanBySlug($slug);
      return $plan;
  }

}

 ?>