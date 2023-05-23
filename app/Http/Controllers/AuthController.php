<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;


class AuthController extends Controller
{
    public function register(Request $request) {    
        $validator = Validator::make($request->all(), [ 
                     'first_name' => 'required',
                     'last_name' => 'required',
                     'email' => 'required|email',
                     'password' => 'required',  
                     'c_password' => 'required|same:password', 
                     'city' => 'required',
                     'adress' => 'required',
                     'postcode' => 'required',
           ] ,
      );   
         if ($validator->fails()) {          
              return response()->json(['message'=>$validator->errors()], 401);                        
         }    
         else{
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
               return response()->json(['message'=>'user exist!'], 401); 
            } else{

               $data = $request->all();  
               $data['password'] = bcrypt($data['password']);
               $user = User::create($data); 
               $success['token'] =  $user->createToken('AppName')->accessToken;
               return response()->json(['message'=>'User has been successfully created ', 'success'=>$success], 200); 

            }
         }
      }
         
          
public function login(){ 
         $validator = Validator::make(['email' => request('email'), 'password' => request('password')], [ 
            'email' => 'required|email',
            'password' => 'required',  
         ] ,
);   
if ($validator->fails()) {          
     return response()->json(['message'=>$validator->errors()], 401);                        
}    
else{
       if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
          $user = Auth::user(); 
           return response()->json([
                     'messages'=>'success' , 
                  'token' => $user->createToken('AppName')-> accessToken], 200); 
         } else{ 
          return response()->json(['messages'=>'Unauthorised'], 401); 
          } 
       }
      }

      public function profile(){
         $user = Auth::user();
     
         if ($user) {
             return response()->json([
                 'msg' => 'success!',
                 'profile'  => $user,
             ], 200);
         }else{
            return response()->json([
               'msg' => 'Authentification necessary ',
           ], 200);
         }
     }
     


}
