<?php 
namespace App\Repositories;
use App\Referral;
use App\ReferralPoint;
use App\User;

class Referrals {

	protected $model;

	public function __construct() {

		$this->model = new Referral;
	}

	/**
	 * [getUserReferrals description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function getUserReferrals( $user_id ) {

		$referrals = $this->model->with('user')->where('referer_id', '=', $user_id)->get();

		$response = [
			'msg' => 'list all referee',
			'user' => $referrals
		];

		return $response;
	}

	/**
	 * This function save user referral use
	 * @param  [type] $referee_id    [description]
	 * @param  [type] $referral_slug [description]
	 * @return [type]                [description]
	 */
	public function saveReferral($referee_id, $referral_uuid) {

		$referer_id = User::where('uuid', '=', $referral_uuid)->first()->id;

		$data['referee_id'] = $referee_id;
		
		$data['referer_id'] = $referer_id;

		$save = $this->model->create($data);

		$response = [
			'msg' => 'Save Referrals',
			'save' => $save 
		];

		return $response;
	}

	/**
	 * [saveReferralPoints description]
	 * @param  [type] $user_id [description]
	 * @param  [type] $credit  [description]
	 * @return [type]          [description]
	 */
	public function saveReferralPoints($user_id, $credit) {

		$onlyIfIsReferee = $this->model->where('referee_id', '=', $user_id)->first();

		if ($onlyIfIsReferee) {

			$data['referral_id'] = $onlyIfIsReferee->id;
			// $data['referer_id'] = $onlyIfIsReferee->referer;
			// $data['referee_id'] = $user_id;
			$data['credit_id'] = $credit;

			$referral_points = new ReferralPoint;
			$savePoinst = $referral_points->create($data);

			$response = [
				'msg' => 'Save Refferals point'
			];

			return $response;

		}
	}	

	/**
	 * [getReferralPointsByUserId description]
	 * @return [type] [description]
	 */
	public function getReferralPointsByUserId( $user_id ) {

		$referers = $this->model->where('referer_id', '=', $user_id)->get();

		$points = 0;
		foreach( $referers as $referer ) {

			$points += ReferralPoint::where('referral_id', '=', $referer->id)->count();
			
		}

		return $points;
	}	
}


?>