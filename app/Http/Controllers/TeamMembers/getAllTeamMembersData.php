<?php

namespace App\Http\Controllers\TeamMembers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserProfileUpdateServices;
use App\Http\Requests\addTeamMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 



class getAllTeamMembersData extends Controller
{
    public function getAllTeamMember(Request $request){
        try {
            $page = $request->query('perPage');
            $currentPage=$request->query('currentPage');
       $allTeamMembers=User::paginate(perPage:$page,page:$currentPage);
       return response()->json($allTeamMembers,200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function addTeamMember(addTeamMemberRequest $request){
        try {
        $allRequestedData=$request->only('firstName','lastName','email','phone','title','status','password');
        $services=new UserProfileUpdateServices();
        $checkCreated=$services->registerTeamMember($allRequestedData);
        if ($checkCreated) {
            $allTeamMembers = User::paginate(6);
            return response()->json(['data', $allTeamMembers], 200);
        }
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }      
   }
   public function editTeamMemberData(Request $request){
    try {
      
        $id=$request->query('updateId');
        // $allRequestedData = $request->only('firstName', 'lastName', 'email', 'phone', 'title', 'status', 'password');
        // $services = new UserProfileUpdateServices();
        $user=User::findOrFail($id);
        $user->firstName=$request->firstName;
        $user->lastName=$request->lastName;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->title=$request->title;
        $user->status=$request->status;
        $user->password=Hash::make($request->password);
        $check=$user->save();
        // $services->updateTeamMemberData($id, $allRequestedData);
        // $findTeamMember=$services->updateTeamMemberData($id, $allRequestedData);
        $data= "Failed to update team Member";
        $allTeamMembers=User::paginate(6);
         return $allTeamMembers && $check ? response()->json( $allTeamMembers, 200): response()->json($data,400);
        } catch (\Throwable $th) {
        return response()->json(['error'=>$th],401);
        }
   }
}