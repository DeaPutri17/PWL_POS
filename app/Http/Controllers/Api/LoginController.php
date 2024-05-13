<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
        ]);

        //if validations fails
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('username', 'password');

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'succes' => false,
                'message' => 'Username atau Password anda salah'
            ], 401);
        }

        //if auth succes
        return response()->json([
            'succes' => true,
            'user'  => auth()->guard('api')->user(),
            'token'  => $token
        ], 200);
    }
}