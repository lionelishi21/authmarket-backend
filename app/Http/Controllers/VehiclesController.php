<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VehicleMake;
use App\Vehicle;
use Response;

class VehiclesController extends Controller
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
    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    /**
     * Show vehicles list.
     *
     * @param int $make_id
     * @param int $model_id
     * @param int $year_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function vehicles($make_id, $model_id, $year_id)
    {
     //    $eagerLoading = [
     //        'make' => function($query)
     //        {
     //            $query->select('id', 'name');
     //        },
     //        'model' => function($query)
     //        {
     //            $query->select('id', 'name', 'class');
     //        },
     //        'year' => function($query)
     //        {
     //            $query->select('id', 'year');
     //        }
     //    ];
        
     //    $vehicles = $this->model->with($eagerLoading)
     //        ->byMake($make_id)
     //        ->byModel($model_id)
     //        ->byYear($year_id)
     //        ->get([
     //            'id',
     //            'name',
     //            'cylinders',
     //            'displacement',
     //            'drive',
     //            'transmission',
     //            'make_id',
     //            'model_id',
     //            'year_id'
     //        ]);

    
    	// 
      // $make = VehicleMake::find($make_id)->id;
      $make = Vehicle::where('model_id', '=', $model_id)->where('make_id', '=', $make_id)->where('year_id', '=', $year_id)->get();
      return response()->json([
		'vehicles' => $make
	  ]);
    }

    /**
     * Show vehicle details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vehicle($vehicle_id)
    {
        $eagerLoading = [
            'make' => function($query)
            {
                $query->select('id', 'name');
            },
            'model' => function($query)
            {
                $query->select('id', 'name', 'class');
            },
            'year' => function($query)
            {
                $query->select('id', 'year');
            }
        ];

        $vehicle = $this->model->with($eagerLoading)->select([
            'id',
            'name',
            'cylinders',
            'displacement',
            'drive',
            'transmission',
            'make_id',
            'model_id',
            'year_id'
        ])->find($vehicle_id);

        return response()->json([
            'vehicle' => $vehicle
        ]);
    }

    /**
     * [VehicleDetails description]
     * @param [type] $id [description]
     */
    public function VehicleDetails( $id ) {

        $response = array();
        $details = $this->model::find ( $id );
        if ( isset( $details) ) {
            return Response::json( $details );
        }
        return Response::json ( $response = array ('message' => 'something went wrong'));
    }
}
