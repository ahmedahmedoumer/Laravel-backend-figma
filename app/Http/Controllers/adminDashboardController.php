<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notification;
use App\Services\UserProfileUpdateServices;
use App\Models\team_members;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\adminLoginRequest;
use App\Http\Requests\adminProfileUpdateRequest;
use Illuminate\Validation\ValidationException;


class adminDashboardController extends Controller
{
    public function adminDashboard(){
        $notificationReader=new notification();
        $notificationReader=$notificationReader::where('status','notread')->get();
    }
    public function adminLogin(adminLoginRequest $request){
               $checkRequestEmail= team_members::where('email',$request->email)->first();
               if($checkRequestEmail && Hash::check($request->password,$checkRequestEmail->password)){
               $token=$checkRequestEmail->createToken('Token Name')->plainTextToken;
                 return response()->json([
                    'user'=>$checkRequestEmail,
                    'status'=>200,
                    'token'=>$token,
                    'current_project'=>30000,
                    'new_projects'=>250,
                    'all_task'=>30000,
                    'new_task'=>250
               ]);
               }
                $data="your credential are not match please try again !!";
                return response()->json($data, 401);
    }
    public function adminProfileUpdateRequest(adminProfileUpdateRequest $request){
        $userData=$request->only(['firstName','lastName','email','phone','title','status',  'password','confirmPassword']);
        $updateUserProfile=new UserProfileUpdateServices();
        $header=$updateUserProfile->updateUserProfile($userData);
        return response()->json($header);
        // if ($header) {
        //     $data="Successfully  Updated";
        //      return response()->json(['status'=>200,'data'=>$data]);
        //  }
        //  $data="Failed to update check your entry data";
        //  return response()->json($data, 400, $headers);
        // }
    }}