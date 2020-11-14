<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Gate;

use Illuminate\Http\Request;

class UsersController extends Controller
{
  /* public function __construct()
    {
        $this->middleware('auth');
    } */
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with('roles')->where('user_type_id', '=', 1)->get();

        $response = [
            'users' => $users
          ];
        return response()->json(['status'=> true,$response], 200); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function roleattach(Request $request,$userid)
    {
       $user = User::where('email', '=', $request->input('email'))->first();
       $role=user::find($userid)->roles()->wherePivot('user_id', $userid)->first();
       $role=user::find($userid)->roles()->detach();
       $user = User::where('email', '=', $request->input('email'))->first();
       $role = Role::where('name', '=', $request->input('role'))->first();

       $user->roles()->attach($role);

       return response()->json("assigned as " . $role->name);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function roledetach($userid)
    { 
        $user = User::where('email', '=', $request->input('email'))->first();
        $role=user::find($userid)->roles()->wherePivot('user_id', $userid)->first();
        $role=user::find($userid)->roles()->detach();
        $response = [
            'role' => $role
          ];

        return response()->json(['message' => 'Role Detach'], 404);

    }
    public function getusers($id)
    {
        //lists user role
        $role=user::find($id)->roles;

        $response = [
            'role' => $role
          ];

        return response()->json($response, 200);
    }
    public function getrole()
    { 
      $roles = Role::all(); 
      
        $response = [
          'roles' => $roles
        ];
        return response()->json($response, 200);
    }
}
