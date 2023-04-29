<?php

namespace App\Services;

use App\Models\team_members;
class updateUserProfileService{

public function update( array $userData)
    {
       $filename = Str::random(20) . '.' . $userData->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('public/images', $filename);
        $findUserData = team_members::where('email', $userData['email'])->firstOrFail();
        $imageFile=$path.'/'.$filename;
        $findUserData->firstName = $userData['firstName'];
        $findUserData->lastName = $userData['lastName'];
        $findUserData->phone = $userData['phone'];
        $findUserData->title = $userData['title'];
        $findUserData->status = $userData['status'];
        $findUserData->password = $userData['password'];
        $findUserData->image=$userData['image'];
           return $findUserData->save();
    }

}