<?php

namespace App\Http\Controllers\TeamMembers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserProfileUpdateServices;
use App\Http\Requests\addTeamMemberRequest;

class getAllTeamMembersData extends Controller
{
    public function getAllTeamMember(){
        try {
       $allTeamMembers=User::paginate(6);
       return response()->json(['data',$allTeamMembers],200);
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
   public function editTeamMemberData(addTeamMemberRequest $request,$id){
    try {
        $allRequestedData = $request->only('firstName', 'lastName', 'email', 'phone', 'title', 'status', 'password');
        $services = new UserProfileUpdateServices();
        $findTeamMember=$services->updateTeamMemberData($id, $allRequestedData);

        $data= "Failed to update team Member";
        $allTeamMembers = User::paginate(6);
         return $findTeamMember ? response()->json(['data', $allTeamMembers], 200): response()->json($data,400);
        } catch (\Throwable $th) {
        return response()->json(['error'=>$th],401);
        }
   }
}