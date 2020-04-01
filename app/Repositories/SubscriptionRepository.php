<?php 
namespace App\Repositories;

use App\Subscription;
use Carbon\Carbon;
use App\Plan;
use App\Payment;
use App\Car;
use App\Invoice;
use App\InvoiceLine;
use App\VehicleMake;


class SubscriptionRepository {
	
	protected $model;

	public function __construct(Subscription $subscription){
		$this->model = $subscription;
	}

	/**
	 * This function subscribe a user
	 * @param  array  $array [description]
	 * @return [type]        [description]
	 */
	public function subscribe( array $array) {

		return $array;
		$plan = $array['car'];
		$payment = $array['payments'];

		$planDetails = Plan::find($plan['plan_id']);
		if ($planDetails) {

			$invoice = Invoice::get();
			$count_invoices = 1;
			if (isset( $invoice)) {
			  $count_invoices = count($invoice) + 1;
			}
		

			$invoice = new Invoice;
			$invoice->status = 'Paid';
			$invoice->user_id = $array['user_id'];
			$invoice->reference = 'INV-00'.$array['user_id'].''.$plan['plan_id'].''.$count_invoices;
			$invoice->save();

			if ($invoice->save()) {

				$make_id = Car::find($plan['car_id'])->make_id;
				$title = VehicleMake::find($make_id)->name;

				$line = new InvoiceLine;
				$line->title = $title;
				$line->unitPrice = $planDetails['cost'];
				$line->save();

				if ( $line->save()) {

					$payment = new Payment;
					$payment->car_id = $plan['car_id'];
					$payment->payment_gateway = $payment['payer']['payment_method']; 
					$payment->invoice_id = $invoice->id;
					$payment->plan_id = $plan['plan_id'];
					$payment->amount = $planDetails['amount'];
					$payment->user_id = $array['user_id'];
					$payment->save();

					if ( $payment->save()) {

						$start_time = Carbon::now();
		                $end_time = Carbon::now()->addDays($planDetails->duration);

		                $plan['start_time'] = $start_time;
						$plan['end_time'] = $end_time;

						// check if an subscription already exists
						$subscription = $this->model->where('car_id', '=', $plan['car_id'])->first()			;
						if ( isset($subscription) ) {
							$subscription->start_time = $start_time;
							$subscription->end_time = $end_time;
							$subscription->save();

							$response = array('message' => 'payments update succesfully');
						    return $response;
						}

		                $save = $this->model->create($plan);
						$response = array('message' => 'payments create succesfully');
						return  $response;
					}
				}
			}
		}
	}

	/**
	 * Tjos fimctopm cjecl of sibscription is active
	 * @param  [type] $car_id [description]
	 * @return [type]         [description]
	 */
	public function checkForFreeSubByUser($user_id) {
		$sub = $this->model->where('user_id', '=', $user_id)->where('slug', '=', 'starter-plan')->count();
		if ( $sub > 0) {
			$response = array( 'message' => 'has started plan', 'status' => true);
			return $response;
		} else {
		    $response = array(  'message' => 'has no started plan','status' => false);
			return $response;
		}
	}

	/**
	 * ************************************************
	 * [getActiveSubByUserId description]
	 * ***********************************************
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function getActiveSubByUserId( $user_id ) {

		$response = array();
		$subs = Subscriptions::where('user_id', '=', $user_id)->get();

		foreach( $subs as $sub ) {

			$response[] = array(
				'car' => Car::find($sub->car_id),
				'id' => $sub->id,
				'plan' => Plan::find($sub->plan_id),
				'duration' => 	$sub->start_time->diffInDays($sub->end_time),
				'start_time' => $sub->start_time,
				'end_time' => $sub->end_time
			);
		}
		return $response;
	}
}
 ?>
