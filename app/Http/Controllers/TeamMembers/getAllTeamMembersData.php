<?php

namespace App\Http\Controllers\TeamMembers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserProfileUpdateServices;
use App\Http\Requests\addTeamMemberRequest;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;


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
}