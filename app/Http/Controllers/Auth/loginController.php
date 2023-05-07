<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\adminLoginRequest;

class loginController extends Controller
{
    public function adminLogin(adminLoginRequest $request)
    {
        try {
             if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'title'=>"admin",'status'=>"Active" ])) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'status' => 200,
                'token' => $token
            ]);
             }
             $data = "your credential are not match please try again !!";
             return response()->json($data, 401);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }  
    }
    public function logoutUser()
    {   
        try{
            $user = Auth::guard('sanctum')->user();
            $user->tokens()->delete();
            return response()->json(['message' => "successfully Logged out !!"], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }  

      
    }
}
