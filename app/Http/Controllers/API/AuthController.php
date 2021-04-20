<?php
namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Repositories\Referrals;
use DB;

class AuthController extends Controller
{

	/**
	 * [login description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function login(Request $request)
    {

	    $user = User::where('email', '=', $request->email)->first();
       
        if ($user) {
	        if (Hash::check($request->password, $user->password)) {

                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $user, 'message' => 'Login successfull'];

                return response($response, 200);

            } else {
	            $response = "Password missmatch";
	            return response($response, 422);
	        }
	    } else {
	        $response = 'User does not exist';
	        return response($response, 422);
	    }
        
    }

    /**
     * [register description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function register(Request $request)
    {

        // Auto Dealer Sign up
        if ($request->type == 2) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => 2,
                'company' => $request->company,
                'address' => $request->address,
                'city' => $request->parish,
                'district' => $request->location,
                'password' => Hash::make($request->password),
            ]);
        }


        if ($request->type == 1) {
             $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }


        if ($request->type == 3) {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => 3,
                'address' => $request->address,
                'city' => $request->parish,
                'district' => $request->location,
                'password' => Hash::make($request->password),
            ]);
        }
       
       
        $user->sendApiEmailVerificationNotification();
        
        /**
         *  save refferrals 
         */
        if ($request->referral_id) {
             $ref = new Referrals;
             $ref_id = $ref->saveReferral($user->id, $request->referral_id);
        }

        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        return response()->json(['success' => $success]);
    }
    
    /**
     * [logout description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function logout (Request $request) {

	    $token = $request->user()->token();
	    $token->revoke();

	    $response = 'You have been succesfully logged out!';
	    return response($response, 200);
	}
}