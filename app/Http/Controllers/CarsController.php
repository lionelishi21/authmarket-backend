<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use Illuminate\Http\Request;
use App\Repositories\Cars;
use App\Services\CarServices;
use Response;
use App\Car;


class CarsController extends Controller
{

    protected $carservice;

    /**
     * *************************************************************
     * [__construct description]
     * *************************************************************
     * @param CarServices $carservice [description]
     * *************************************************************
     */
	public function __construct(CarServices $carservice) {
        $this->carservice = $carservice;
	}

    /**
     * *************************************************************
     * this function filter all cars result on the user side
     * ************************************************************
     * @param  Request $request [description]
     * @return [type]           [description]
     * ************************************************************
     */
    public function index(Request $request) {

        $filter = $request->all();
        $cars = $this->carservice->index($filter);
        if (isset ($cars)) {
            return $cars;
        }

        $response = array('message' => 'No response');
        return $response;
    }

	/**
     ****************************************************************** 
	 * [show description]
     ****************************************************************** 
	 * @param  Request $request [description]
	 * @param  [type]  $user_id [description]
	 * @return [type]           [description]
     ******************************************************************** 
	 */
    public function show(Request $request, $user_id = null) {

       $response = array();
      
       $user_id = $request->user()->id;
       if ($user_id) {
       	 $cars =  $this->carservice->showAllUserCars($request, $user_id);
       	 return Response::json($cars);
       }

       $cars = $cars->getFilterCars($request);
       return Response::json($cars);
    }


    /**
     * *************************************************************
     * [details description]
     * *************************************************************
     * @param  [type] $batch_id [description]
     * @return [type]           [description]
     * *************************************************************
     */
    public function details ( $batch_id ) {
        $details = $this->carservice->show_details( $batch_id);
        if ( $details ) {
            return Response::json( $details );
        }
    }


    /**
     * [create description]
     * @param  Request $request [description]
     * @param  [type]  $user_id [description]
     * @return [type]           [description]
     */
    public function create(Request $request) {
    	$response = $this->carservice->create($request);
    	return Response::json($response);
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $user_id [description]
     * @return [type]           [description]
     */
    public function  update(Request $request, $car_id) {

    	$response = $this->carservice->update($request, $car_id);
    	return Response::json($response);
    }

    /**
     * [destroy description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function destroy($car_id) {

    	if ($car_id) {
    		$response = Car::find($car_id);
    		if ($response) {
    			$response->delete();
    			return Response::json($response);
    		}
    		return Response::json($response);
    	}
    	return Response::json($response);
    }

    /**
     * [vehicles description]
     * @return [type] [description]
     */
    public function vehicles() {
        return 'Yes';
    }

    /**
     * [carDetailsById description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function carDetails($id) {

        $response = array();
        $cars = new Cars;

        if (isset($id)) {
            $response = $cars->getCarDetailsById($id);
            return Response::json($response);
        }

        $response = array('message' => 'Something went wrong');
        return Response::json($response);
    }

    /**
     * Show edit Car
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit( $id ) {
        $edit = $this->carservice->edit( $id );
        if ( isset($edit) ) {
            return $edit;
        }
    }

    /**
     * [incrementPageview description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function countPageviews($car_id) {

        $response = $this->carservice->increment_page($car_id);
        return $response;
    }
    /**
     * [filterCars description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function filterCars(Request $request) {
        return $this->carservice->filter($request);
    }

    /**
     * this function get most view cars
     * @return [type] [description]
     */
    public function mostViewCars() {
        $cars = $this->carservice->hotcars();
        return Response::json($cars);
    }

    /**
     * ****************************************************
     * This function get active cars
     * @param  Request $request [description]
     * @return [type]           [description]
     *****************************************************x
     */
    public function getUserActiveCars(Request $request) {

        $user_id = $request->user()->id;
        $cars = $this->carservice->get_active_cars($user_id);
        return Response::json($cars);
    }

    /**
     * This function get all inactive cars
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getUserInactiveCars(Request $request) {

        $user_id = $request->user()->id;
        $cars = $this->carservice->get_inactive_cars($user_id);
        return Response::json($cars);

    }

    public function rotate(Request $request, $id) {

        $user = $request->user();
        if ( $user ) {
           $rotate = $this->carservice->rotate_image($id);
           return $rotate;
        }
    }
}
