<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VehicleModel;
use Response;

class ModelsController extends Controller
{
      /**
     * Model instance.
     *
     * @var mixed
     */
    public $model;

    /**
     * Create a new ModelsController instance.
     *
     * @return void
     */
    public function __construct(VehicleModel $model)
    {
        $this->model = $model;
    }

    /**
     * Show make models list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function models($make)
    {
    	$models = $this->model->byMake($make)->orderBy('name')->get(['id', 'name', 'class']);

    	return response()->json([
    		'models' => $models
    	]);
    }

    /**
     * [VehicleModel description]
     * @param [type] $model [description]
     */
    public function VehicleModel ( $model ) {

        $response = array();
        $model = $this->model::find ( $id );
        if ( isset( $model ) ) {
            return Response::json( $model );
        }
        return Response::json ( $response = array('message' => 'something went wrong'));
    }
}
