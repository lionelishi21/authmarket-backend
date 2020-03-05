<?php
namespace App\Services;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use App\Profile;

class UserService {

	protected $model;

	public function __construct(ProfileRepository $profile) {
		$this->model = $profile;
	}

	/**
	 * ***************************************************************
	 * this fucnction get user profile details by user id
	 * ***************************************************************
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 * ***************************************************************
	 */
	public function user_profile_details( $user_id) {
		return $this->model->getUserProfile($user_id);
	}

	/**
	 * **************************************************************
	 * [create_update_user_profile description]
	 * @param  [type]  $user_id [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 */
	public function update_user_profile($user_id, Request $request){

		$attributes = $request->all();
		$profile = json_decode($attributes['profile']);
		$response = $this->model->updateUser($profile, $user_id);

		return $response;
	}


   /**
    * **************************************************
	 * This function user filter
	 * *************************************************
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 * *************************************************
    **/
    public function saveFilter(Request $request) {

    	$attributes = $request->all();
    	$user_id = $request->user()->id;
    	$save = $this->model->saveUserFilter($user_id, $attributes);

    	return $save;
    }
}
?>
