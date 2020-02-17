<?php
namespace App\Services;

use App\Http\Requests;
use App\Repositories\MakeRepository;

class MakeService {
	
	protected $model;

	public function get_makes_type( $request  ) {
		$this->model = new MakeRepository;

		if ($request == 'popular') {
			return $this->model->list();
		} else {
			return $this->model->all();
		}
	
	}
}

?>