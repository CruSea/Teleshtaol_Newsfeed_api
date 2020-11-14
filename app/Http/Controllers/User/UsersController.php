<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function destroy($id)
    { 
        $oldUser = User::where('id', '=', $id)->first();
        $oldUser->roles()->detach();
        $oldUser->delete();

    }
}
