<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Response;
use App\Credit;
use App\Invoice;
use App\InvoiceLine;
use App\Payment;

class SubscriptionController extends Controller
{

	protected $subscriptions;

    public function __construct(SubscriptionService $subscriptions){
    	$this->subscriptions = $subscriptions;
    }


    public function subscribe(Request $request) {

    	$store = $this->subscriptions->save($request);
    	return Response::json($store);
    }

    /**
     * [checkSubscription description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function checkSubscription(Request $request) {
    	$user_id = $request->user()->id;
    	$subscriptions = $this->subscriptions->checkForSubscription($user_id);
    	return Response::json($subscriptions);
    }

    /**
     * **************************************************************
     * This function purrchase credit from user
     * @return [type] [description]
     * **************************************************************
     */
    public function purchaseCredit(Request $request) {

        $type = 1;
        $creditAmount = $request->amount;
        $creditCost = $request->cost;
        $paymentDetails = $request->payments;

        $user = $request->user();
        $user_id = $user->id; 

        for ($x = 0; $x < $creditAmount; $x++) {
            $credit = new Credit;
            $credit->type_id = $type;
            $credit->user_id = $user_id;
            $credit->save();
        }

        $invoice = Invoice::get();
        $count_invoices = 1;
        if (isset( $invoice)) {
          $count_invoices = count($invoice) + 1;
        } 

        $invoice = new Invoice;
        $invoice->user_id = $request->user()->id;
        $invoice->reference = 'INV-0'.$user_id.''.$count_invoices;
        $invoice->save();

        if ($invoice->save()) {
            $line = new InvoiceLine;
            $line->title = 'Credit Order';
            $line->unitPrice =  $creditCost;
            $line->save();
        }

        $payment = new Payment;
        $payment->payment_gateway = 'paypal'; 
        $payment->invoice_id = $invoice->id;
        $payment->credits = $creditAmount;
        $payment->amount =  $creditCost;
        $payment->user_id = $user_id;
        $payment->save();

        $response = [
            'msg' => 'successfully save user credit(s)',
            'status' => $credit->save()
        ];

        return response()->json( $response, 200);
    }




    /**
     * this function get user credits
     * @param  Request $user [description]
     * @return [type]        [description]
     */
    public function getUserCredit(Request $user) {

    }   
}
