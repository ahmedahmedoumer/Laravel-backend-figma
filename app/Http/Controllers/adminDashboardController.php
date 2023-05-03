<?php

namespace App\Http\Controllers;

use App\Models\notification;
use App\Services\UserProfileUpdateServices;
use App\Models\User;
use App\Models\designLibrary;
use App\Models\planLibrary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\http\Requests\adminProfileUpdateRequest;
use Illuminate\Support\Facades\DB;


class adminDashboardController extends Controller
{    
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

    public function fetchAllDashboardData(){
        $currentProjects=DB::table('task_progress_view')->get()->count();
        $newProject=designLibrary::whereMonth('approved_on', now()->month)->get()->count();
               $newTasks=planLibrary::where('status','!=',NULL)->get()->count();
               $currentTasks=planLibrary::where('design_status','!=',"approved")->get()->count();
               $notifications=notification::all();
        return response()->json([
            'current_projects'=>$currentProjects,
            'newProject'=>$newProject,
            'newTask'=>$newTasks,
            'currentTask'=>$currentTasks,
            'notification'=>$notifications
             ],200);
        }
    
}
