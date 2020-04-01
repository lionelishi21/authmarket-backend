<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Response;

class UserController extends Controller
{

	protected $model;

	/**
	 * ******************************************************
	 * [__construct description]
	 * @param UserService $userservice [description]
	 * ******************************************************
	 */
    public function __construct(UserService $userservice ) {
    	$this->model = $userservice;
    }

    /**
     * ********************************************************
     * THis fuction save user filter
     * ********************************************************
     * @param  Request $request [description]
     * @return [type]           [description]
     * ********************************************************
     */
    public function saveUserFilter(Request $request) {
    	$save = $this->model->savefilter($request);
    	return Response::json($save);
    }

    /**
     * This function get user filter settings
     * @param Request $request [description]
     */
    public function GetUserFilter(Request $request) {

        $filter = $this->model->filters($request);
        return Response::json($filter);
    }

    /**
     * this function get parishes
     * @param Request $request [description]
     */
    public function Parish(Request $request){

        $user = $request->user();
        if ( isset($user )) {
            $parishes = $this->model->get_parishes($user->id);
        } else {
            $user_id = null; 
            $parishes = $this->model->get_parishes($user_id);
        }
        return Response::json($parishes);
    }

    /**
     * [Bodystyles description]
     * @param Request $request [description]
     */
    public function Bodystyles(Request $request) {

        $user = $request->user(); 
        if ( isset( $user )) {
            $parishes = $this->model->get_bodystyles($user_id);
        } else {
             $user_id = null; 
             $parishes = $this->model->get_bodystyles($user_id);
        }
        return Response::json($parishes);
    }
}
