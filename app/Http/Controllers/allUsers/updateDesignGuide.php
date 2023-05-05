<?php

namespace App\Http\Controllers\allUsers;

use App\Http\Controllers\Controller;
use App\Models\brands;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class updateDesignGuide extends Controller
{
    public function updateDesignGuide($id , Request $request){

        try {
             $request->validate([
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
             ]);
                $image=$request->file('image')->store('public/images');
                $findBrandRow=brands::find();
                $findBrandRow->image=$image;
                $check=$findBrandRow->save();
                if($check){
                $allEmployeeData = brands::with(['planner', 'designer', 'brandsCompany'])->get();
                return response()->json(['AllUsers', $allEmployeeData], 200);
                 }
                return response()->json(['data', "Failed to updating design Guide"], 402);
                } catch (\Throwable $th) {
                return response()->json(['error' => $th], 401);
            }  
     
    }
}
