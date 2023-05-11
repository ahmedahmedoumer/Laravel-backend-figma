<?php

namespace App\Http\Controllers\designLibrary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\designLibrary;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\addDesignFormRequest;
use App\Models\designs;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;


class DesignLibraryController extends Controller
{
    /////////////////////////    for all design Library Page   ////////////////////////////////////////////////////////////////
    public function getAllDesignLibrary()
    {
        try {
        $allDesignLibrary=designLibrary::all();
        return $allDesignLibrary ? response()->json($allDesignLibrary, 200) : response()->json("Empty Design Library", 400);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function addDesignLibrary(addDesignFormRequest $request)
    {
        try {
        $requestData=$request->only('designTitle','image','sourceFile');
        $zipFileName=$request->file('sourceFile');
        $imageFileName=$request->file('image');
        $imageFileOriginalName= $imageFileName->getClientOriginalName();
        $zipFileOriginalName = $zipFileName->getClientOriginalName();
        $storepPathForZipFile = public_path() . '/uploads/zipFiles';
        $storepPathForImageFile = public_path() . '/uploads/imageFiles';
        $zipFileName->move($storepPathForZipFile, $zipFileOriginalName);
        $imageFileName->move($storepPathForImageFile, $imageFileOriginalName);

        $ZipFilestoreAs='/uploads/zipFiles/'. $zipFileOriginalName;
        $ImageFilestoreAs = '/uploads/imageFiles/' . $imageFileOriginalName;

        $addDesignLibrary=designLibrary::create([
            'designTitle'=> $requestData['designTitle'],
            'image'=> $ImageFilestoreAs,
            'sourceFile'=> $ZipFilestoreAs,
           ]);
           return $addDesignLibrary ? response()->json($addDesignLibrary,201) : response()->json("Failed to add design !!", 400);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function updateDesignLibrary(addDesignFormRequest $request,$id){
        try {
            $requestData=$request->only('designTitle','image','sourceFile');
            $zipFileName=$request->file('sourceFile');
            $imageFileName=$request->file('image');
            $imageFileOriginalName= $imageFileName->getClientOriginalName();
            $zipFileOriginalName = $zipFileName->getClientOriginalName();
            $storepPathForZipFile = public_path() . '/uploads/zipFiles';
            $storepPathForImageFile = public_path() . '/uploads/imageFiles';
            $zipFileName->move($storepPathForZipFile, $zipFileOriginalName);
            $imageFileName->move($storepPathForImageFile, $imageFileOriginalName);
    
            $ZipFilestoreAs='/uploads/zipFiles/'. $zipFileOriginalName;
            $ImageFilestoreAs = '/uploads/imageFiles/' . $imageFileOriginalName;

            $findDesignPlan=designLibrary::find($id);
            $check=null;
            if($findDesignPlan){
            $findDesignPlan->designTitle=$requestData['designTitle'];
            $findDesignPlan->image=$ImageFilestoreAs;
            $findDesignPlan->sourceFile=$ZipFilestoreAs;
            $check=$findDesignPlan->save();
            }
            $allDesignLibrary = designLibrary::all();
            return $allDesignLibrary && $check ? response()->json(["message"=>"successfully updated",'data'=>$allDesignLibrary], 200) : response()->json([ $message="Empty Design Library",$data=$allDesignLibrary||Null], 400);

        } catch (\Throwable $th) {
          return response()->json(['error'=>$th],401);
        }
    }
    //////////////////////////////////// for report page ///////////////////////////////////////////////////////////////////
    public function deleteDesignRequest($id){

        try {
             $designs=designs::findOrFail($id);
             $checkDelete=$designs->delete();
             return $checkDelete ? response()->json(['Deleted successfully'],200) : response()->json(['failed to Delete successfully'],401);
             } catch (\Throwable $th) {
                 return response()->json(['error' => $th], 401);
             }
    }
    public function approveDesignRequest($id){
        try {
             $findDesigns = designs::where('brands_id',$id);
             $findDesigns->status = "Approve";
             $findDesigns->approved_by=Auth::id();
             $findDesigns->approved_on=now();
            return $findDesigns->save() ? response()->json(['message'=>"successfully approved",'data'=> designs::paginate(4)], 200) : response()->json(['message' => "Failed to  approved", 'data' => designs::paginate(4)], 401);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function setStatusNeedEditForDesignRequest($id){
          try{
                $findUserDesign=designs::where('brands_id',$id)->update('status','Need Edit');
                return $findUserDesign ? response()->json('successfully update Status', 200):response()->json('Failed to update Status', 401);
           } catch (\Throwable $th) {
             return response()->json('Something Wrong',401);
           }
    }
    public function addbulkDesign(Request $request)
    {
        try {
        $request->validate([
         'zipFile' => 'required',
        ]);
        $csvFile= Reader::createFromPath($request->file('zipFile')->getRealPath());
        $csvFile->setHeaderOffset(0);
       
        foreach ($csvFile as $row) {
            $validator = Validator::make($row, [
                 'textOnPost' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $designs=new designs();
            $designs->textOnPost=$row['textOnPost'];
            $checkCreated=$designs->save();
        }
           return $checkCreated ? response()->json('Successefully created',200): response()->json('Failed to Add bulk design', 401);
           
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }

    
}
