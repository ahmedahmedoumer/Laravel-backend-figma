<?php

namespace App\Http\Controllers\brandRe_assign;

use App\Http\Controllers\Controller;
use App\Models\brands;
use App\Models\User;
use Illuminate\Http\Request;

class brandDesignerRe_assign extends Controller
{
    //
    public function brandDesignerReassign($brand_id, $designer_id)
    {
       try{
            $findBrandRow = brands::find($brand_id);
            $findDesinner = User::where('id',$designer_id)->where('title', 'designner')->first();
            if ($findBrandRow && $findDesinner) {
            $findBrandRow->designers_id = $designer_id;
            $saveAssigning = $findBrandRow->save();
            if ($saveAssigning) {
                $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany'])->get();
                return response()->json(['AllUsers' => $allEmployeeData], 200);
            }
            return response()->json(['data' => "Failed to assign Planner !!"], 200);
            }
            return response()->json(['data' => "Failed to assign Designer check the assigned member !!"], 200);
        }
        catch(\Throwable $th){
            return response()->json(['error',$th],401);
        }
    }
}
