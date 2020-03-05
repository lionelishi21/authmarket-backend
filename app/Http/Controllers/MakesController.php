<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\VehicleMake;
use App\Services\CarServices;
use App\Services\MakeService;
use Response;

class MakesController extends Controller
{
/**
     * Model instance.
     *
     * @var mixed
     */
    public $model;

    /**
     * Create a new ModelsController instance.4
     *
     * @return void
     */
    public function __construct(VehicleMake $model)
    {
        $this->model = $model;
    }

    /**
     * Show makes list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function makes(Request $request)
    {
        $carservice = new MakeService;
        $user = $request->user();
        $user_id = null;

        if (isset($user)) {
            $user_id = $user->id;
        }
        $makes = $carservice->get_makes_type($request->make_type, $user_id);
        return Response::json($makes);
    }

    /**
     * ***************************************************
     * Get Vehicle Make by id
     * ***************************************************
     * @param [type] $id [description]
     * @return [string] vehicle name
     * ***************************************************
     */
    public function VehicleMake ( $id ) {

        $response = array();
        $make = $this->model::find( $id );
        if ( isset($make) ) {
            return Response::json( $make );
        }
        return Response::json( $response = array('message' => 'no make something wrong with make id'));
    }
}
