<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| --------------------------------------------------------------------------
*/

/** Application and **/
Route::middleware('auth:api')->group(function () {

	Route::get('/', 'API\CreditsController@index');
	
	Route::group(['prefix' => 'credits'], function() {
		Route::get('/start', 'API\CreditsController@useCredit');
		Route::post('/create', 'API\SubscriptionController@purchaseCredit');
		Route::get('/', 'API\CreditsController@index');
	});


	Route::get('/referral', 'ReferralController@index');
	Route::get('/referees', 'ReferralController@referees');
	Route::get('/referral-points', 'ReferralController@points');

	Route::group(['prefix' => 'subscriptions'], function() {
		Route::post('/create', 'API\SubscriptionController@subscribe');
		Route::get('/check', 'API\SubscriptionController@checkSubscription');
	});

	Route::group(['prefix' => 'payments'], function() {
		Route::get('/activity', 'PaymentController@index');
		// Route::get('/invoice/{id}', 'PaymentController@invoice');
	});

	Route::group(['prefix' => 'user'],function(){
		
		Route::get('/', function(Request $request){
		    return $request->user();
	  	});

	  	Route::post('/save-userfilter', 'UserController@SaveUserFilter');
	  	Route::post('/save-filter', 'UserController@SaveUserFilter');
	  	Route::get('/get-user-filter', 'UserController@UserFilter');
	  	Route::get('/filters', 'UserController@GetUserFilter');
	});

	Route::get('parishes', 'UserController@Parish');
	Route::get('bodystyles', 'UserController@Bodystyles');

	Route::group(['prefix' => 'plans'], function(){
		Route::get('/select-plan/{id}', 'API\PlanController@selectPlan');
		Route::get('/get-userplans', 'PlansController@userPlans');
		Route::post('/method', 'API\PlanController@paymethod');
		Route::post('/update/{id}', 'API\PlanController@update');
	});

	Route::group(['prefix' => 'invoices'], function() {
		Route::get('/{id}', 'InvoiceController@index');
	});

	Route::group(['prefix' => 'cars'],function(){
		Route::get('/car-details/{id}', 'CarsController@edit');
		Route::get('/user', 'CarsController@show');
		Route::post('/edit/{id}', 'CarsController@update');
		Route::post('/post', 'CarsController@create');
		Route::post('/update', 'CarsController@update');
		Route::post('/delete/{id}', 'CarsController@destroy');
		Route::get('/filter', 'CarsController@mostViewCars');

		/* active cars and inactive */
		Route::get('/inactive', 'CarsController@getUserInactiveCars');
		Route::get('/active', 'CarsController@getUserActiveCars');
		Route::get('/rotate/image/{id}', 'CarsController@rotate');
	});



	Route::post('/update-profile', 'ApiProfileController@update');
	Route::get('/profile', 'ApiProfileController@profile');
	Route::get('/logout', 'API\AuthController@logout');
    Route::get('/plans', 'PlansController@index');

    /**
     * ***********************************************************
     * Paypal Checkout
     * ***********************************************************
     */
    Route::post('/create-payment', 'PaymentController@create');
    
    Route::post('payment', 'PayPalController@payment');
	Route::get('cancel', 'PayPalController@cancel');
	Route::get('payment/success', 'PayPalController@success');

	Route::get('email/resend', 'API\VerificationController@resend')->name('verificationapi.resend');
});

	Route::group(['prefix' => 'payments'], function() {
		// Route::get('/activity', 'PaymentController@index');
		Route::get('/invoice/{id}', 'PaymentController@invoice');
	});

Route::get('/referral-points', 'ReferralController@points');

// Route::group(['prefix' => 'credits'], function() {
// 	Route::get('/create', 'API\SubscriptionController@purchaseCredit');
// 	Route::get('/', 'API\CreditsController@index');
// });

/*
|-----------------------------------------------------------------------------
| Email Verification API
|-----------------------------------------------------------------------------
| Here is wehere the messaging api goes for the application
|-----------------------------------------------------------------------------
*/

Route::get('email/verify/{id}', 'API\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'API\VerificationController@resend')->name('verificationapi.resend');

/* Plans Routes */
Route::get('/plan-details/{id}', 'API\PlanController@details');
Route::get('/user-plan', 'API\PlanController@userPlans');

Route::get('bodystyles', 'UserController@Bodystyles');
Route::get('parishes', 'UserController@Parish');
# ========================================================
#                   Public Car Routes                    =
# ========================================================
Route::group(['prefix' => 'cars'],function(){
	Route::get('/details/{id}', 'CarsController@details');
	Route::post('/filter', 'CarsController@filterCars');
});
# ========================================================


Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');

/**
 *These routes get namse field
 */
Route::group(['prefix' => 'name'], function () {
	Route::get('/make-name/{id}', 'MakesController@VehicleMake');
	Route::get('/model-name/{id}', 'ModelsController@VehicleModel');
	Route::get('/year-name/{id}', 'ModelsYearsController@VehicleYear');
	Route::get('/vehicles-name/{id}', 'VehiclesController@VehicleDetails');
});

// Show make list
Route::get('vehicles/makes', [
	'uses' => 'MakesController@makes',
	'as' => 'api.vehicles.makes'
]);

// Show make models list
Route::get('vehicles/{make}/models', [
	'uses' => 'ModelsController@models',
	'as' => 'api.vehicles.models'
]);

// Show model years list
Route::get('vehicles/{make}/{model}/years', [
	'uses' => 'ModelsYearsController@years',
	'as' => 'api.vehicles.years'
]);

// Show vehicles list
Route::get('vehicles/{make}/{model}/{year}/vehicles', [
	'uses' => 'VehiclesController@vehicles',
	'as' => 'api.vehicles.vehicles'
]);

// Show vehicle details
Route::get('vehicles/{vehicle}/vehicle', [
	'uses' => 'VehiclesController@vehicle',
	'as' => 'api.vehicles.vehicle'
]);

Route::get('/viewcounts/{id}', 'CarsController@countPageviews');
Route::get('/hot-cars', 'CarsController@mostViewCars');



// Route::middleware('auth:api')->get('/profile', 'Api\ProfileController@getUser');