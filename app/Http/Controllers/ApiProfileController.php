<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Response;

class ApiProfileController extends Controller
{

	protected $userservice;

	public function __construct(UserService $service) {
		$this->userservice = $service;
	}


    function getUser(Request $request){
      return  json_encode($request->user);
    }

    /**
     * [profile description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function profile(Request $request) {
    	$user_id = $request->user()->id;
    	$profile = $this->userservice->user_profile_details($user_id);
    	return Response::json($profile);
    }

    /**
     * ********************************************************************************************
     * Thsi function update profile information
     * @param  Request $request [description]
     * @return [type]           [description]
     * ********************************************************************************************
     */
    public function update(Request $request) {
    	$user_id = $request->user()->id;
    	$update_user_profile = $this->userservice->update_user_profile($user_id,  $request);
    	return Response::json($update_user_profile);
    }

}
