<?php
namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
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
	            $response = ['token' => $token, 'user' => $user];
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register success.',
        ]);
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