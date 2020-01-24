<?php  
namespace App\Repositories;

use App\VehicleModelYear;
use App\Subscription;
use App\VehicleModel;
use App\VehicleMake;
use App\CarImage;
use App\Vehicle;
use App\Profile;
use App\User;
use App\Car;

class Helper {

	private $vehicle;
	private $model;
	private $make;
	private $year;
	private $sub;

	public function __construct() {

		$this->year = new VehicleModelYear;
		$this->model = new VehicleModel;
		$this->vehicle = new Vehicle;
		$this->make = new VehicleMake;
		$this->sub = new Subscription;
	}


	/**
	 * [getMakeById description]
	 * @param  [type] $make_id [description]
	 * @return [type]          [description]
	 */
	public function getMakeById($make_id) {

		$make = VehicleMake::where('id', '=', $make_id)->first();
		if ( isset($make)) {
			return $make->name;
		}
		return false;
	}

 /**
  * this function bolde details by id
  * @param  [type] $make_id [description]
  * @return [type]          [description]
  */
  public function getModelById($model_id) {

  	// $model = VehicleModel::findOrFail($model_id);
  	// if (isset ($model)) {
  	// 	return $model->name;
  	// }
  }

  /**
   * get vehilev
   * @return [type] [description]
   */
  public function getVehicleYearById () {
  	$year = $this->year->where('id', '=', $id)->first();
  	return $year;
  }

  /**
   * Get model year by year id
   * @param  [type] $year_id [description]
   * @return [type]          [description]
   */
  public function getYearById($year_id) {

  	$year = VehicleModelYear::find( $year_id );
  	if ( isset ($year)) {
  		return $year->year;
  	}
  }


  public function getVehicleById( $make, $model, $year) {
  	return $vehicle = Vehicle::where('make_id', '=', $make)->where('model_id', '=' , $model)->where('year_id', '=', $year)->first();
  }

  /**
   * this function get car image
   * @param  [type] $car_id [description]
   * @return [type]         [description]
   */
  public function getCarImage( $car_id ) {

  	$image = CarImage::where('car_id', '=', $car_id)->first();
  	if ($image) {
  		return $image->image;
  	}
  	return false;
  }

  /**
   * This funcition conver money to intger
   * @param  [type] $money [description]
   * @return [type]        [description]
   */
  public function getAmount($money)
  {
	    $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
	    $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

	    $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

	    $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
	    $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

	    return (float) str_replace(',', '.', $removedThousandSeparator);
	}

	/**
	 * this function check id car is subscripe to a plan
	 * @param  [type] $car_id [description]
	 * @return [type]         [description]
	 */
	public function checkIfSubscribe($car_id) {

		$subscriptions = Subscription::where('car_id', '=', $car_id)->first();
		if ( isset($subscriptions)) {
			return true;
		}
		return false;
	}

  /**
   * [getUserProfileByUserId description]
   * @param  [type] $user_id [description]
   * @return [type]          [description]
   */
  public function getUserProfileByUserId( $user_id ) {

       $user = User::find($user_id);
       $response = array(
          'name' => $user->name,
          'username' => $user->username,
          'email' => $user->email,
          'dealer' => $user->isDealer,
          'company' => $user->company,
          'address' => $user->address,
          'district' => $user->district,
          'parish' => $user->city,
          'about' => $user->about,
          'name' => $user->name,
          'email' => $user->email,
          'phone' => $user->phone
        );

        return $response;
  }
}
?>

