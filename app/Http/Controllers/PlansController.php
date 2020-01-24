<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlanService;


class PlansController extends Controller
{
    protected $planservice;

    public function __construct(PlanService $planservice) {
    	$this->planservice = $planservice;
    }

    /**
     * ***************************************************
     * [index description]
     * ***************************************************
     * @return [type] [description]
     * ***************************************************
     */
    public function index() {
    	$plans = $this->planservice->index();
    	return Response::json($plans);
    }
}
