<?php

namespace App\Http\Controllers\allUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\User;
class getUsersController extends Controller
{
    //
    public function getAllUsers(Request $request){
        try {
            if($request->filled('perPage') && $request->filled('currentPage')){
                $page = $request->query('perPage');
                $currentPage=$request->query('currentPage');
            $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany'])->paginate(perPage:$page,page:$currentPage);
            return response()->json($allEmployeeData, 200);

            }
            else{
            $planner = User::where('title','planner')->get();
            $designner=User::where('title','designner')->get();
            return response()->json(['planner'=>$planner,'designner'=>$designner], 200);

            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }    
    }
}
