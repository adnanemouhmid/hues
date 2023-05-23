<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
      if ($users == null) {
        return response()->json([
                'message'  => "Users not found!",
          ], 422);
     } else{
        return response()->json($users, 201);
    }
    }

    //show one user
    public function show($id){
        $user = User::find($id);
        if ($user == null) {
            return response()->json([
                    'message'  => "User not found!",
              ], 422);
         } else{
            return response()->json([
                'utilisateur'  => $user,
            ], 200);
         }
    }

    public function destroy($id){
    $user = User::find($id);
    if ($user == null) {
        return response()->json([
                'message'  => "User not found!",
          ], 422);
     } else{
         User::destroy($id);
         return response()->json([
            'msg' =>'User deleted successfully',
        ], 200);

    }
}

public function update(Request $request, $id){
    $user = User::find($id);
    if ($user == null) {
        return response()->json([
                'message'  => "User not found!",
          ], 422);
     } else{
        $user->update($request->all());
        return response()->json([
            'msg' =>'User updated successfully',
            'utilisateur'  => $user,
        ], 200);
     }
}



}
