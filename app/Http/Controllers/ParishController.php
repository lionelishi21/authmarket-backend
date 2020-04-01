<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Response; 

class ParishController extends Controller
{
    
    protected $user;
   	
   	public function __construct(UserService $userservice) {
   		$this->user = $userservice;
   	}

   	/**
   	 * [index description]
   	 * @param  Request $request [description]
   	 * @return [type]           [description]
   	 */
    public function index(Request $request){
    	$parish = $this->user->parishes(); 
    	return Response::json($parishes)	
    }

    /**
     * this functiong et bodystles
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function bodystyles(Request $request) {
    	$bodystyles = $this->user->bodystyles();  
    	return Response::json($bodystyles):
    }
}
