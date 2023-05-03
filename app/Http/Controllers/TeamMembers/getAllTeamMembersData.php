<?php

namespace App\Http\Controllers\TeamMembers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserProfileUpdateServices;
use App\Http\Requests\addTeamMemberRequest;

class getAllTeamMembersData extends Controller
{
    public function getAllTeamMember(){
       $allTeamMembers=User::all();
       return response()->json(['data',$allTeamMembers],200);
    }

    public function addTeamMember(addTeamMemberRequest $request){
        $allRequestedData=$request->only('firstName','lastName','email','phone','title','status','password');
        $services=new UserProfileUpdateServices();
        $checkCreated=$services->registerTeamMember($allRequestedData);
        if ($checkCreated) {
            $allTeamMembers = User::all();
            return response()->json(['data', $allTeamMembers], 200);
        }         
   }
   public function editTeamMemberData(addTeamMemberRequest $request,$id){
        $allRequestedData = $request->only('firstName', 'lastName', 'email', 'phone', 'title', 'status', 'password');
        $services = new UserProfileUpdateServices();
        $findTeamMember=$services->updateTeamMemberData($id, $allRequestedData);
        $data= "Failed to update team Member";
        $allTeamMembers = User::all();
         return $findTeamMember ? response()->json(['data', $allTeamMembers], 200): response()->json($data,400);
   }
}