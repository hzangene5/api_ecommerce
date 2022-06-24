<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
     public function register(Request $request)
     {
        $validator = Validator::make($request->all(),[
           'name' => 'required|string',
           'email' => 'required|email|unique:users,email',
           'password' => 'required|string',
           'c_password' => 'required|same:password',
           'address' => 'required|string',
           'cellphone' => 'required',
           'postal_code' => 'required',
           'province_id ' => 'nullable',
           'city_id ' => 'nullable',

        ]);

        if($validator->fails()){
            return $this->errorResponse($validator->getMessageBag(),422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'address' => $request->address,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
        ]);

         $token = $user->createToken('mayApp')->plainTextToken;

  
         return $this->successResponse([
            'user' => $user,
            'token' => $token
         ],200);
          


     }


     public function login(Request $request)
     {
        $validator = Validator::make($request->all(),[

            'email' => 'required|email',
            'password' => 'required|string',
 
         ]);
 
         if($validator->fails()){
             return $this->errorResponse($validator->getMessageBag(),422);
         }

        $user = User::where('email' , $request->email)->first();

        if(!$user){
            return $this->errorResponse('user not found',401);
        }

        if(!Hash::check($request->password, $user->password)){
            return response()->json('password is incorrect', 401);
        }

        $token = $user->createToken('mayApp')->plainTextToken;

  
        return $this->successResponse([
           'user' => $user,
           'token' => $token
        ],201);

     }
}
