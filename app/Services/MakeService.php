<?php
namespace App\Services;

use App\Http\Requests;
use App\Repositories\MakeRepository;

class MakeService {
	
	protected $model;

	public function get_makes_type( $request , $user_id ) {

		$this->model = new MakeRepository;

		if ( $request == 'popular') {
			return $this->model->list($user_id);
		}

		if ( $request == 'custom') {
			return $this->model->custom($user_id);
		}

		if ( $request == 'all') {
			return $this->model->all($user_id);
		}

		return $this->model->all($user_id);
	}
}
?>

