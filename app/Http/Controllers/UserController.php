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

}
