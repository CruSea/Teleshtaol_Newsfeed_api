<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\User_log;
use Carbon\Carbon;
use App\Role;
use Illuminate\Support\Facades\Hash;

class MobileAuthenticate extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('api', ['except' => ['login','signup']]);
    } */

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);
        $rules = [
            'email' => 'required|email',
            'password' => 'required|max:255',
            
        ];
        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status'=>false, 'error'=>'validation error'],500);
            }

        if (! $token = auth()->attempt($data)) {
            return response()->json(['error' => 'Email or Password doesn\'t exist'], 401);
        }
        $user = User::first();
        $user_log = $this->saveLogHistory($user);
        return $this->respondWithToken($token);
    }
    public function signup(Request $request){

        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string|max:30',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = $validator->messages();
            return response()->json([ 'error'=>$error],500);
        }
        //$role=Role::select('id')->where('name','Author')->first();
        $user=User::create($request->all());
        $user->user_type_id = 2;
        //$user->roles()->attach($role);
        $user->save();

        //return $this->respondWithToken($token);
        
        return $this->login($request);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $id=auth()->user()->id;

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->name,
            'user_role_id'=>user::find($id)->roles,
            //'user_role_id'=>auth()->user()->id,
        ]);
        
    }
    public function getcurrentuser(){
        $user = auth()->user();
        return response()->json($user); 
    }
    
    public function saveLogHistory($user){
        $user_log = new User_log();
        $user_log ->user_id = $user->id;
        $user_log ->last_login_at = Carbon::now();
        $user_log ->save();
        return response()->json(['status'=>true, 'message'=> 'successfully registered', 'user_log'=>$user_log],200);
    }
}
