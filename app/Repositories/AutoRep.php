<?php 
namespace  App\Repositories;

use App\User;


class AutoRep {


	public $user;

	public function __construct() {

		$this->user = new User;
	}

	public function index(array $attributes) {

		$response = array();
		$users = $this->user->where('role_id', '=', 3)->get();
		foreach ($users as $user) {
			$response[] = array(
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username
			);
		}

	    return $response;
	}
}


