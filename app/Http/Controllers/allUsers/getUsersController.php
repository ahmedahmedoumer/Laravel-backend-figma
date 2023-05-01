<?php

namespace App\Http\Controllers\allUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brands;
class getUsersController extends Controller
{
    //
    public function getAllUsers(){

        // $allEmployeeData=brands::find(6)->company();
        // $allEmployeeData=brands::all()->company;
        $allEmployeeData = brands::with(['planner', 'designer','brandsCompany'])->get();
        return response()->json(['AllUsers',$allEmployeeData],200);
    }
}
