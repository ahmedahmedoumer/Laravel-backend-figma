<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 


class UserProfileUpdateServices
{
    public function updateUserProfile( array $userData)
    {
        $userId=Auth::id();
        $findUserData = User::where('id', $userId)->first();
        $findUserData->firstName = $userData['firstName'];
        $findUserData->lastName = $userData['lastName'];
        $findUserData->email = $userData['email'];
        $findUserData->phone = $userData['phone'];
        $findUserData->title = $userData['title'];
        $findUserData->status = $userData['status'];
        $findUserData->password = Hash::make($userData['password']);
        $check=$findUserData->save();
        return $check;
}
    public function registerTeamMember(array $userData)
    {
        $findUserData = User::create([
            'firstName'=> $userData['firstName'],
            'lastName'=> $userData['lastName'],
            'email'=>$userData['email'],
            'phone' => $userData['phone'],
            'title' => $userData['title'],
            'status' => $userData['status'],
            'password' => Hash::make($userData['password']),
        ]);
        return $findUserData;
    }
}