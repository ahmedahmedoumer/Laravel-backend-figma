<?php

namespace App\Services;
use App\Models\team_members;

class UserProfileUpdateServices
{
    public function updateUserProfile( array $userData)
    {
    //    $filename = Str::random(20) . '.' . ($userData->file('image')->getClientOriginalExtension()?);
    //     $path = $request->file('image')->storeAs('public/images', $filename);
        $findUserData = team_members::where('email', $userData['email'])->first();
        return $findUserData;
        $imageFile=$path.'/'.$filename;
        $findUserData->firstName = $userData['firstName'];
        $findUserData->lastName = $userData['lastName'];
        $findUserData->phone = $userData['phone'];
        $findUserData->title = $userData['title'];
        $findUserData->status = $userData['status'];
        $findUserData->password = $userData['password'];
        // $findUserData->image=$userData['image'];
        $check=$findUserData->save();
       
    
}
}