<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VehicleModelYear;
use Response;

class ModelsYearsController extends Controller
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
    public function __construct(VehicleModelYear $model)
    {
        $this->model = $model;
    }

    /**
     * Show make/model years list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function years($make, $model)
    {
    	$years = $this->model->byModel($model)
            ->orderBy('year', 'DESC')
            ->get(['id', 'year']);

    	return response()->json([
    		'years' => $years
    	]);
    }

    /**
     * [VehicleYear description]
     * @param [type] $id [description]
     */
    public function VehicleYear ( $id ) {

        $response = array();
        $year = $this->model::find( $id );
        if ( isset( $year ) ) {
            return Response::json ($year);
        }
        return Response::json( $response = array('message' => 'something went wrong'));
    }
}
