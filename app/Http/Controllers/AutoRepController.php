<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AutoRep;

class AutoRepController extends Controller
{
   	
   	public $model;

	public function __construct() {
		$this->model = new AutoRep;
	}

	public function index( Request $request) {
		$attribues = $request->all();
		return $this->model->index($attribues);
	}

	
}
