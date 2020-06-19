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


    /**
     * [Filter description]
     * @param Request $request [description]
     */
    public function Filter(Request $request) {

    	$user_id = $request->user()->id;  
    	$filter = $this->model->getUserFilterByUserId($user_id);
    	return $filter;
    }

    /**
     * THis function get all parishes and attach if filtered
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function  get_parishes($user_id) {
    	$parishes = $this->model->getAllParishes($user_id);  
    	return $parishes;
    }

    /**
     * This function get all body styles
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function get_bodystyles($user_id) {
    	return $this->model->getAllBodyStyle( $user_id );
    }

    /**
     * This function get auto rep information by id
     * @param  [type] $uuid [description]
     * @return [type]       [description]
     */
    public function get_auto_rep($uuid) {
        return $this->model->getAutoRepDetailsById($uuid);
    }

}
?>
