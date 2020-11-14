<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Gate;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function _construct(){
        $this->middlware('auth:api');
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with('roles')->where('user_type_id', '=', 1)->get();
        return response()->json(['status'=> true,'users'=> $users], 200);
    }
    public function getUser($id)
    {
        $user = User::find($id);
        return response()->json(['user' => $user], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* if(Gate::denies('edit-users')){
            return redirect(route('admin.users.index'));
        } */
        $role = Role::find($id);
        /* if (!$role) {
            return response()->json(['message' => 'User not found'], 404);
        } */

        //$roles=Role::all();
        /* return view('admin.users.edit')->with([
            'user'=>$user,
            'roles'=>$roles
        ]);  */
         $role=$request->input('name');
        
        $role->save();

        $response = [
            'role' => $role
          ];
        return response()->json($response, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       // dd($request);
       $user->roles()->sync($request->roles);
       $user->name=$request->name;
       $user->email=$request->email;
       

       return redirect()->route('admin.users.index');
    }


   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    { 
        if(Gate::denies('delete-users')){
            return response()->json(['message' => 'unauthorized'], 500);
        }
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
