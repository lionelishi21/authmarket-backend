<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Cars;
use App\Repositories\Scraper;
use App\Services\CarServices;
use App\VehicleMake;

class CarComparisonController extends Controller {
    

     protected $carservice;

     public function __construct(CarServices $carservice) {
     	$this->carservice = $carservice;
     }


    public function index() {

    	$cars = new Scraper;
    	$compare =  $cars->FetchJaCars();
    	return $compare;
    }

    /**
     * THIS FUNCTION COMPARES CARS 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function compareCars(Request $request) {

    	$attributes = $request->all();

    	$response = array();

    	$jacars = $this->carservice->compare_cars($attributes);
        $cars = $this->carservice->filterCompare($request);

    	$response = array(
    		'cars' => $cars,
    		'jacars' => $jacars
    	);

    	return $response;
    }
}
