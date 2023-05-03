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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password ])) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'status' => 200,
                'token' => $token,
                'current_project' => 30000,
                'new_projects' => 250,
                'all_task' => 30000,
                'new_task' => 250
            ]);
        }
        $data = "your credential are not match please try again !!";
        return response()->json($data, 401);
    }
    public function logoutUser()
    {   
        $user = Auth::guard('sanctum')->user();
        $user->tokens()->delete();
        return response()->json(['message' => "successfully Logged out !!"],200);
    }
}
