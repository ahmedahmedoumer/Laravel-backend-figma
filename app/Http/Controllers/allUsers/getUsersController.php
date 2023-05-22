<?php

namespace App\Http\Controllers\allUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brands;
class getUsersController extends Controller
{
    //
    public function getAllUsers(Request $request){
        try {
            $page = $request->query('perPage');
            $currentPage=$request->query('currentPage');
                    // return $page.'   '.$currentPage;
            $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany'])->paginate(perPage:$page,page:$currentPage);
            return response()->json($allEmployeeData, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }    
    }
}
