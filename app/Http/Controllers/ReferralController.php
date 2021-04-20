<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bitly;
use App\User;
use App\Repositories\Referrals;

class ReferralController extends Controller
{

	protected $referral;

	public function __construct() {

		$this->referral = new Referrals;
	}

   /**
    * this function get nitlit
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function index(Request $request) {

    	$user = User::find($request->user()->id);
    	$url = Bitly::getUrl('https://automarketjm.com/signup?referral_id='.$user->uuid);

    	$response = [
    		'bitly_link' => $url
    	];
    	return response()->json($response);
    }

    /**
     * [referees description]
     * @param  Reques $request [description]

     * @return [type]          [description]
     */
  
    public function referees(Request $request) {

    	$refs = $this->referral->getUserReferrals($request->user()->id);
    	return response()->json($refs);
    }

    /**
     * [points description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function points(Request $request) {
   		
   		$response = $this->referral->getReferralPointsByUserId(2);
   		return response()->json($response);
    }


}
