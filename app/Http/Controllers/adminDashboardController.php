<?php

namespace App\Http\Controllers;

use App\Models\notification;
use App\Services\UserProfileUpdateServices;
use App\Models\User;
use App\Http\Requests\adminProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class adminDashboardController extends Controller
{

// public function __construct()
// {

//        $this->middleware('auth:sanctum');
// }
     
    public function adminDashboard()
    {
        $notificationReader = new notification();
        $notificationReader = $notificationReader::where('status', 'notread')->get();
    }
   
    public function adminProfileUpdateRequest(adminProfileUpdateRequest $request)
    {
        $userData = $request->only(['firstName', 'lastName', 'email', 'phone', 'title', 'status',  'password', 'confirmPassword']);
        $updateUserProfile = new UserProfileUpdateServices();
        $header = $updateUserProfile->updateUserProfile($userData);
        if ($header) {
            $data="Successfully  Updated";
             return response()->json(['status'=>200,'data'=>$data]);
         }
         $data="Failed to update check your entry data";
         return response()->json($data, 400);
        }
    
}
