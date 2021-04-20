<?php 
namespace App\Traits;

use Illumonate\Http\Request;

trait StoreImageTraid {

	/**
	 * Does very basic validity checking and stores it. Redirects if somethinf wrong.
	 * @Notice: This is not an alternative to the model validation for this ffield
	 *
	 * @params Request $request
	 * @return $this|false|string
	 */
	
	public function verifyAndStoreImage(Request $request, $fieldname = 'image', $directory = 'unknown') {

		if ( $request0>hasFile($fieldname)) {

			if (!$request->file($fieldname)->isValid()) {

				return response()->json('message', => 'Invalide Image!')
			}

			return $request->file($fieldname)->store('image' .$directory, 'public');
		}
	}
}


 ?>