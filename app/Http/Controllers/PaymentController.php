<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Payment;
use App\Plan;
use Response;

class PaymentController extends Controller {
    
    
    private $_api_context;

    public function __construct() {

    }

    public function index(Request $request) {
       
        $user = $request->user();
        $payments = Payment::where('user_id', '=', $user->id)->get();
        $response = array();

        foreach( $payments as $payment) {

            $amount = Plan::find($payment->plan_id)->cost;
            $response[] = array( 
                'id' => $payment->id,   
                'gateway' => $payment->payment_gateway,
                'amount' => $amount,
                'date'=> Carbon::parse($payment->created_at)->toFormattedDateString(),
                'invoice_id' => $payment->invoice_id, 
                'invoice' => $payment->invoice,
                'user' => $payment->user
            );
        }
        return Response::json($response);
    }

    /**
     * Create Payments
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create(Request $request) {
        return Redirect::route('paywithpaypal');
    }


    public function payWithpaypal(Request $request){

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');


        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
            ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        
        try { 
           $payment->create($this->_api_context);
       } catch ( \PayPal\Exception\PPConnectionException $ex) {
        if (\Config::get('app.debug')) {
            \Session::put('error', 'Connection timeout');
                return Redirect::route('paywithpaypal');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('paywithpaypal');
            }
       }

       foreach ($payment->getLinks() as $link) { 
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                break;
            }
        }/** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {/** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('paywithpaypal');}
}
