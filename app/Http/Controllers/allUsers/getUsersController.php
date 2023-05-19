<?php

namespace App\Http\Controllers\allUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brands;
class getUsersController extends Controller
{
    //
    public function getAllUsers(){
        try {
            $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany'])->get();
            return response()->json($allEmployeeData, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }    
    }
}
