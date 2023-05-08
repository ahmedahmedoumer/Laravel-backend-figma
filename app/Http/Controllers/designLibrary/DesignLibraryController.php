<?php

namespace App\Http\Controllers\designLibrary;

use App\Http\Controllers\Controller;
// use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\designLibrary;
use Illuminate\Support\Str;
use App\Models\brands;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\addDesignFormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\planFormRequest;
use App\Models\planLibrary;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use League\Csv\Statement;
// use Maatwebsite\Excel\Concerns\ToArray;


class DesignLibraryController extends Controller
{
    //
    public function getAllDesignLibrary(){
        try {
        $allDesignLibrary=designLibrary::all();
        return $allDesignLibrary ? response()->json($allDesignLibrary, 200) : response()->json("Empty Design Library", 400);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function addDesignLibrary(addDesignFormRequest $request){
        try {
        $requestData=$request->only('designTitle','image','zipFile');
        $zipFileName=$request->file('zipFile');
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
    public function updateDesignLibrary(Request $request,$id){
        try {
           $validator = Validator::make($request->all(), [
                'sourceFile'=>'required|mimes:zip'
            ]);
           if ($validator->fails()) {
            $response = new JsonResponse([
                'status' => 'validation error',
                'errors' => $validator->errors()
            ], 422);
            throw new \Illuminate\Validation\ValidationException($validator, $response);
            }
            $findDesignPlan=designLibrary::find($id);
            $check=null;
            if($findDesignPlan){
            $file=$request->sourceFile;
            $zipFileName = $file->getClientOriginalName();
            $storepPathForZipFile = public_path() . '/uploads/zipFiles';

            $file->move($storepPathForZipFile, $zipFileName);
            $path ='/uploads/zipFiles/'.$zipFileName;

            $findDesignPlan->sourceFile=$path;
            $check=$findDesignPlan->save();
            }
            $allDesignLibrary = designLibrary::all();
            return $allDesignLibrary && $check ? response()->json(["message"=>"successfully updated",'data'=>$allDesignLibrary], 200) : response()->json("Empty Design Library", 400);
        } catch (\Throwable $th) {
          return response()->json(['error'=>$th],401);
        }
    }
    public function deleteDesignRequest($id){

        try {
            DB::transaction(function () {
            $designLibrary=designLibrary::findOrFail($id);
            $findBrandsById=brands::findOrFail($designLibrary->brands_id);
            $findBrandsById->designers_id=NULL;
            $checkDelete=$designLibrary->delete()  &&  $findBrandsById->save();
           return $checkDelete ? response()->json(['Deleted successfully'],200) : response()->json(['failed to Delete successfully'],400);
          });
             } catch (\Throwable $th) {
                 return response()->json(['error' => $th], 401);
             }
    }
    public function approveDesignRequest($id){
        try {
            DB::beginTransaction();  
             $findDesignLibrary = designLibrary::findOrFail($id);
             $findDesignLibrary->status = "Approve";
             if($findDesignLibrary->save()){
             $findBrands = brands::findOrFail($findDesignLibrary->brands_id);
             $findBrands->designers_id = $findDesignLibrary->designer_id;
             $check = $findBrands->save();
            if (!$check) {
                DB::rollback();
            return response()->json('Failed to register plan ', 400);
            }}
            DB::commit();
            return response()->json(designLibrary::paginate(4), 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],401);
        }
    }
    public function setStatusNeedEditForDesignRequest(Request $request){
        $id=$request->data;
           try {
            foreach ($id as $key => $value) {
                $designItem = designLibrary::find($value);
                $designItem->status = "Need Edit";
                $designItem->save();
            }
            return response()->json('successfully update Status', 200);
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
                 'designTitle' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $designLibrary=new designLibrary();
            $designLibrary->designTitle=$row['designTitle'];
            $checkCreated=$designLibrary->save();
        }
           return $checkCreated ? response()->json('Successefully created',200): response()->json('Failed to Add bulk design', 400);
           
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        }
    }

    
}
