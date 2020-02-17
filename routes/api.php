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

	/*Route::get('/user', function(Request $request){ 
	     return $request->user();
	});
	*/

	Route::group(['prefix' => 'user'],function(){
		Route::get('/', function(Request $request){
		    return $request->user();
	  	});
	  	Route::post('/save-filter', 'UserController@SaveUserFilter');
	  	Route::get('/get-user-filter', 'UserController@UserFilter');
	});


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
		/**********************************************************/
	});

	Route::group(['prefix' => 'subscriptions'], function() {
		Route::post('/create', 'API\SubscriptionController@subscribe');
		Route::get('/check', 'API\SubscriptionController@checkSubscription');
	});

	Route::get('/logout', 'API\AuthController@logout');
	Route::get('/profile', 'ApiProfileController@profile');
	Route::post('/update-profile', 'ApiProfileController@update');

});

Route::get('/plan-details/{id}', 'API\PlanController@details');
Route::get('/user-plan', 'API\PlanController@userPlans');
Route::get('/plans', 'API\PlanController@index');


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

// Route::middleware('auth:api')->get('/profile', 'Api\ProfileController@getUser');