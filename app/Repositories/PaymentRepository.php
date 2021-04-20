<?php 
namespace App\Repositories;

use App\Invoice;

class PaymentRepository {

	protected $invoice;

	public function __construct() {

		$this->invoice = new Invoice;
	}
	/**
	 * this function is use to get invoice details
	 *
	 * 
	 * @param  [type] $invoice_id [description]
	 * @return [type]             [description]
	 */
	public function details( $invoice_id ) {

		$invoice = $this->invoice->with(['user', 'plan', 'payment', 'line'])->where('id', '=', $invoice_id)->first();
		if ( $invoice ) {
			return $invoice;
		}	
	}
}


 ?>