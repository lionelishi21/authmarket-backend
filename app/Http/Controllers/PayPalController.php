<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Plan;
use App\Car;

use Response;
class PayPalController extends Controller
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request){
    	

    	$user = $request->user();
    	$plan_id = $request->plan_id;
    	$car_id = $request->car_id;
       	

       	$plan = Plan::find($plan_id);
       	$amount_payed = $plan->amount;

       	$car = Car::find($car_id);
       	$name = $car->make->name;




        $data = [];
        $data['items'] = [
            [
                'name' => $name,
                'price' => 1000.00,
                'desc'  => 'Description for ItSolutionStuff.com',
                'qty' => 1
            ]
        ];
  
        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('/');
        $data['cancel_url'] = url('/');
        $data['total'] = 1000.00;
  
        $provider = new ExpressCheckout;
  
        // $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
  		
  		// $responses = array('link' => $response['paypal_link']);

          return $response;
    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $response = $provider->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            dd('Your payment was successfully. You can create success page here.');
        }
  
        dd('Something is wrong.');
    }
}
