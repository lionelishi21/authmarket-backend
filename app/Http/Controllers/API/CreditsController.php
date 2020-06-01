<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Credits;


class CreditsController extends Controller
{
   
   protected $credits;

   public function __construct() {
   		$this->credits = new Credits;
   }

   /**
    * [index description]
    * @param  Request $request [description]
    * @return [type]           [description]
    */
   public function index(Request $request) {

   		$user = $request->user();
		$credits = $this->credits->index($user->id);
		
		return $credits;
   }

   /**
    * this function use user credits
    * @param  Request $request [description]
    * @return [type]           [description]
    */
   public function useCredit(Request $request) {

   		$user = $request->user();

   		if ( $user ) {
   			$response = $this->credits->useUserCredit($user->id, $request->car_id);
   			return $response;
   		}
   }	 
}
