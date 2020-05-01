<?php 
namespace App\Repositories;

use App\Credit;
use App\Subscription;
use Carbon\Carbon;
use App\Repositories\Referrals;

class Credits {

	protected $credit;

	public function __construct() {
		$this->credit = new Credit;
	}
	
	/**
	 * ***********************************************
	 * this function get all user credits
	 * ***********************************************
	 * @return [type] [description]
	 * ***********************************************
	 */
	public function index($user_id) {
		
		$credits = $this->credit->where('user_id', '=', $user_id)->get();
		
		$unactive = 0;
		$active = 0;
		$expired = 0;


		foreach($credits as $credit) {

			if ($credit->active == 0) {
				$unactive++;
			}

			if ($credit->active == 1) {
				$active++;
			}

			if ($credit->active == 2) {
				$expired++;
			}
		}

		$response = [
			'unactive' => $unactive,
			'active' => $active,
			'expired' => $expired,
			'all' => count($credits)
		];

		return $response;
	}

	/**
	 * [useUserCredit description]
	 * @param  [type] $user_id [description]
	 * @param  [type] $car_id  [description]
	 * @return [type]          [description]
	 */
	public function useUserCredit($user_id, $car_id) {

		$credit = $this->credit->where('user_id', '=', $user_id)
		->where('active', '=', 0)
		->first();

		if ( $credit ) {

			$start_time = $start_time = Carbon::now();
			$end_time = Carbon::now()->addDays(15);

			$subscribe = new Subscription;

			$subscribe->car_id = $car_id;

			$subscribe->user_id = $user_id;

			$subscribe->credit_id = $user_id;

			$subscribe->start_time = $start_time;

			$subscribe->end_time = $end_time;

			$subscribe->save();

			if ($subscribe->save()) {
				
				$updateCredit = $this->credit->find($credit->id);
				
				$updateCredit->active = 1;
				
				$updateCredit->save();

				$ref = new Referrals;
				$ref->saveReferralPoints($user_id, $user_id );

				$response = [
					'mes' => 'You plan has started'
				];

				return $response;
			}
		}
	}



    /**
     * **************************************************************
     * This function purrchase credit from user
     * @return [type] [description]
     * **************************************************************
     */
    public function purchaseCredit($user_id, $amount) {

        $type = 2;
        $creditAmount = $amount;
  
        for ($x = 0; $x < $creditAmount; $x++) {
            $credit = new Credit;
            $credit->type_id = $type;
            $credit->user_id = $user_id;
            $credit->save();
        }

        $response = [
            'msg' => 'successfully save user credit(s)',
        ];

        return response()->json( $response, 200);
    }


}
 




 ?>